import  {getLyric} from 'api/song'
import {ERR_OK} from 'api/config'
import {Base64} from 'js-base64'
export default class Song {
  constructor({id,mid,singer,name,album,duration,image,url}) {
    this.id = id
    this.mid = mid
    this.singer = singer
    this.name = name
    this.album = album
    this.duration = duration
    this.image = image
    this.url = url
  }
  getLyric() {
    if(this.lyric) {
      return Promise.resolve(this.lyric)
    }
    return new Promise((resolve,reject) => {
      getLyric(this.mid).then((res) => {
        if(res.retcode === ERR_OK){
          this.lyric = Base64.decode(res.lyric)
          resolve(this.lyric)
        }else{
          reject('no lyric')
        }
      })
    })
  }
}
export function createSong(musicData){
  return new Song({
    id:musicData.songid,
    mid:musicData.songmid,
    singer:filterString(musicData.singer),
    name:musicData.songname,
    album:musicData.albumname,
    duration:musicData.interval,
    // image:`https://y.gtimg.cn/music/photo_new/T001R300x300M000${musicData.albummid}.jpg?max_age=2592000`,
    // image:`https://y.gtimg.cn/music/photo_new/T002R300x300M000${musicData.albummid}.jpg?max_age=2592000`,
    image: `https://y.gtimg.cn/music/photo_new/T002R300x300M000${musicData.albummid}.jpg?max_age=2592000`,
    // url: `http://ws.stream.qqmusic.qq.com/${musicData.songid}.m4a?fromtag=46`
    // url:`https://thirdparty.gting.com/${musicData.songid}.m4a?fromtag=38`
    // url:`http://thirdparty.gtimg.com/C100${musicData.songmid}.m4a?fromtag=38`//18-4-15播放地址
    url: `http://dl.stream.qqmusic.qq.com/C400${musicData.songmid}/${musicData.songid}.m4a?guid=263427534&fromtag=66`//18-4-19播放地址
    //18-5-28播放地址
    // url: `http://dl.stream.qqmusic.qq.com/C400${musicData.songmid}/${musicData.songid}.m4a?guid=2313974775&vkey=4089D067F5ABDCE1F6242A8E97EFF9F23BDF84E7CBF09F7BBC79C06025869C3405ED038D62BD842B27E4DDD8CBC994F0009B4818FAA5016A&uin=&fromtag=999`
  })
}
export function filterString(singer) {
  let ret = []
  if(!singer) {
    return ''
  }
  singer.forEach((s) => {
    ret.push(s.name)
  })
  return ret.join('/')
}
