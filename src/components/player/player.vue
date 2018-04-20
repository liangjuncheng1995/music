<template lang="html">
  <div class="player" v-show='playlist.length>0'>
    <transition name="normal" @enter="enter" @after-enter="afterEnter" @leave="leave" @after-leave="afterLeave">
      <div class="normal-player" v-show="fullScreen">
        <div class="background">
          <img width="100%" height="100%" :src="currentSong.image" >
        </div>
        <div class="top">
          <div class="back" @click="back">
            <i class="icon iconfont icon-fanhui"></i>
          </div>
          <h1 class="title" v-html="currentSong.name"></h1>
          <h2 class="subtitle" v-html="currentSong.singer"></h2>
        </div>
        <div class="middle">
          <div class="middle-l">
            <div class="cd-wrapper" ref="cdWrapper">
              <div class="cd" :class="cdCls">
                <img class="image" :src="currentSong.image">
              </div>
            </div>
          </div>
        </div>
        <div class="bottom">
          <div class="progress-wrapper">
            <span class="time time-l">{{format(currentTime)}}</span>
            <div class="progress-bar-wrapper">
              <progress-bar :percent="percent" @percentChange="onProgressBarChange"></progress-bar>
            </div>
            <span class="time time-r">{{format(currentSong.duration)}}</span>
          </div>
          <div class="operators">
            <div class="icon1 i-left" @click="changeMode">
              <i :class="iconMode"></i>
            </div>
            <div class="icon1 i-left" :class="disableCls">
              <i @click="prev" class="icon iconfont icon-icon-1"></i>
            </div>
            <div class="icon1 i-center" :class="disableCls">
              <i @click="togglePlaying" :class="playIcon"></i>
            </div>
            <div class="icon1 i-right" :class="disableCls">
              <i @click="next" class="icon iconfont icon-icon-"></i>
            </div>
            <div class="icon1 i-right">
              <i class="icon iconfont icon-favoriteoutline"></i>
            </div>
          </div>
        </div>
      </div>
    </transition>
    <transition name="mini">
      <div class="mini-player" v-show="!fullScreen" @click="open">
        <div class="icon-img">
          <img :class="cdCls" width="40" height="40" :src="currentSong.image">
        </div>
        <div class="text">
          <h2 class="name" v-html="currentSong.name"></h2>
          <p class="desc" v-html="currentSong.singer"></p>
        </div>
        <div class="control">
          <progress-circle :radius="radius"  :percent="percent">
            <i @click.stop="togglePlaying" class="icon-mini" :class="miniIcon" id="minizi"></i>
          </progress-circle>
        </div>
        <div class="control">
          <i class="icon iconfont icon-liebiao"></i>
        </div>
      </div>
    </transition>
    <audio ref="audio" source='' :src="currentSong.url" @canplay="ready" @error="error" @timeupdate="undateTime" @ended="end"></audio>
  </div>
</template>

<script>
import {mapGetters,mapMutations} from 'vuex'
import animations from 'create-keyframe-animation'
import {prefixStyle} from 'common/js/dom'
import ProgressBar from 'base/progress-bar/progress-bar'
import ProgressCircle from 'base/progress-circle/progress-circle'
import {playMode} from 'common/js/config'
import {shuffle} from 'common/js/util'

const transform = prefixStyle('transform')
export default {
  data() {
    return {
      songReady:false,
      currentTime : 0,
      radius:32
    }
  },
  computed:{
    cdCls(){
      return this.playing? 'play' : 'play pause'
    },
    playIcon() {
      return this.playing? 'icon iconfont icon-zanting': 'icon iconfont icon-play'
    },
    iconMode() {
      return this.mode === playMode.sequence ? 'icon iconfont icon-shunxubofang' : this.mode === playMode.loop ? 'icon iconfont icon-danquxunhuan' :
      'icon iconfont icon-suijibofang'
    },
    miniIcon() {
      return this.playing? 'icon iconfont icon-zanting1': 'icon iconfont icon-play'
    },
    disableCls() {
      return this.songReady? '' : 'disable'
    },
    percent() {
      return this.currentTime / this.currentSong.duration
    },
    ...mapGetters([
      'fullScreen',
      'playlist',
      'currentSong',
      'playing',
      'currentIndex',
      'mode',
      'sequenceList'
    ])
  },
  methods:{
    back() {
      this.setFullScreen(false)
    },
    open() {
      this.setFullScreen(true)
    },
    enter(el,done){
      const {x,y,scale} = this._getPosAndScale()
      // console.log(x,y,scale)
      let animation = {
        0:{
          transform: `translate3d(${x}px,${y}px,0) scale(${scale})`
        },
        60: {
          transform: `translate3d(0,0,0) scale(1.1)`
        },
        100:{
          transform: `translate3d(0,0,0) scale(1)`
        }
      }
      animations.registerAnimation({
        name:"move",
        animation,
        presets: {
          duration: 400,
          easing: 'linear'
        }
      })
      animations.runAnimation(this.$refs.cdWrapper, 'move', done)
    },
    afterEnter(){
      animations.unregisterAnimation('move')
      this.$refs.cdWrapper.style.animation = ''
    },
    leave(el,done){
      this.$refs.cdWrapper.style.transition = 'all 0.4s'
      const {x,y,scale} = this._getPosAndScale()
      this.$refs.cdWrapper.style[transform] = `translate3d(${x}px,${y}px,0) scale(${scale})`
      this.$refs.cdWrapper.addEventListener('transitionend',done)
    },
    afterLeave(){
      this.$refs.cdWrapper.style.transition = ''
      this.$refs.cdWrapper.style[transform] = ''
    },
    togglePlaying() {
      if(!this.songReady){
        return
      }
      this.setPlayingState(!this.playing)
    },
    end() {
      if(this.mode === playMode.loop){
        this.loop()
      }else{
        this.next()
      }
    },
    loop() {
      this.$refs.audio.currentTime = 0
      this.$refs.audio.play()
    },
    next() {
      if(!this.songReady){
        console.log('地址错误。请求不了播放歌曲的数据 下一首歌曲获取不了')
        return
      }
      //正常下一首
      let index = this.currentIndex + 1
      if(index === this.playlist.length) {
        index = 0
      }
      this.setCurrentIndex(index)
      //正常下一首
      if(!this.playing){//切换下一首时，播放暂停按钮正确显示
        this.togglePlaying()
      }
      this.songReady = false
    },
    prev() {
      if(!this.songReady){
        console.log('地址错误。请求不了播放歌曲的数据 上一首歌曲获取不了')
        return
      }
      //正常上一首
      let index = this.currentIndex - 1
      if(index === -1){
        index = this.playlist.length - 1
      }
      this.setCurrentIndex(index)
      //正常上一首
      if(!this.playing){
        this.togglePlaying()//切换上一首时，播放暂停按钮正确显示
      }
      this.songReady = false
    },
    ready() {
      this.songReady = true
      console.log("歌曲地址获取正确")
    },
    error() {
      this.songReady = true
      console.log('地址错误')
    },
    undateTime(e) {
      this.currentTime = e.target.currentTime
    },
    format(interval) {
      interval = interval | 0
      const minute = interval / 60 | 0
      const second = this._pad(interval % 60)
      return `${minute}:${second}`
    },
    onProgressBarChange(percent) {
      this.$refs.audio.currentTime = this.currentSong.duration * percent
      if(!this.playing) {
        this.togglePlaying()
      }
    },
    changeMode() {
      const mode = (this.mode+1) % 3
      this.setPlayMode(mode)
      let list = null
      if(mode === playMode.random) {
        list = shuffle(this.sequenceList)
      }else{
        list = this.sequenceList
      }
      this._resetCurrentIndex(list)
      this.setPlayList(list)
    },
    _resetCurrentIndex(list) {
      let index = list.findIndex((item) => {
        return item.id === this.currentSong.id
      })
      this.setCurrentIndex(index)
    },
    _pad(num, n = 2) {//补零操作
      let len = num.toString().length
      while(len<n){
        num = '0' + num
        len ++
      }
      return num
    },
    _getPosAndScale() {
      const targetWidth = 40
      const paddingLeft = 40
      const paddingBottom = 30
      const paddingTop = 80
      const width = window.innerWidth * 0.8
      const scale = targetWidth / width
      const x = -(window.innerWidth / 2 - paddingLeft)
      const y = window.innerHeight - paddingTop - width / 2 - paddingBottom
      return {
        x,
        y,
        scale
      }
    },
    ...mapMutations({
      setFullScreen:'SET_FULL_SCREEN',
      setPlayingState:'SET_PLAYING_STATE',
      setCurrentIndex:'SET_CURRENT_INDEX',
      setPlayMode:'SET_PLAY_MOOE',
      setPlayList:'SET_PLAYLIST'
    })
  },
  watch: {
    currentSong(newSong,oldSong) {
      if(newSong.id === oldSong.id){
        return
      }
      this.$nextTick(() => {
        this.$refs.audio.play()
        this.currentSong.getLyric()
      })
    },
    playing(newPlaying) {
      const audio = this.$refs.audio
      this.$nextTick(() => {
        newPlaying?  audio.play() : audio.pause()
      })
    }
  },
  components:{
    ProgressBar,
    ProgressCircle
  }
}
</script>

<style lang="css" scoped="">
.player  .normal-player{
  position: fixed;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  z-index: 150;
  background: #222;
}
.normal-enter-active,.normal-leave-active{
  transition: all 0.4s
}

/* 动画 */
.normal-enter-active .top{
  transition: all 0.4s cubic-bezier(0.86, 0.18, 0.82, 1.32);
}
.normal-leave-active .top{
  transition: all 0.4s cubic-bezier(0.86, 0.18, 0.82, 1.32);
}
.normal-enter-active .bottom{
  transition: all 0.4s cubic-bezier(0.86, 0.18, 0.82, 1.32);
}
.normal-leave-active .bottom{
  transition: all 0.4s cubic-bezier(0.86, 0.18, 0.82, 1.32);
}
.normal-enter, .normal-leave-to{
  opacity: 0;
}
.normal-enter, .normal-leave-to .top{
  transform: translate3d(0, -100px, 0);
}
.normal-enter, .normal-leave-to .bottom{
  transform: translate3d(0, 100px, 0);
}

.normal-player .background{
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
  opacity: 0.6;
  filter: blur(20px);
}
.normal-player .top{
  position: relative;
  margin-bottom: 25px;
}
.normal-player .top .back{
  position:absolute;
  top: 0;
  left: 6px;
  z-index: 50;
}
.normal-player .top .back .icon-fanhui{
  display: block;
  padding: 9px;
  font-size: 22px;
  color: #fb7299;
  transform: rotate(-90deg);
}
.normal-player .top .title{
  width: 70%;
  margin: 0 auto;
  line-height: 40px;
  text-align: center;
  /* no-wrap() */
  font-size: 18px;
  color: #fff;
}
.normal-player .top .subtitle{
  line-height: 20px;
  text-align: center;
  font-size: 14px;
  color: #fff;
}
.normal-player .middle{
  position: fixed;
  width: 100%;
  top: 80px;
  bottom: 170px;
  white-space: nowrap;
  font-size: 0;
}
.normal-player .middle .middle-l{
  display: inline-block;
  vertical-align: top;
  position: relative;
  width: 100%;
  height: 0;
  padding-top: 80%;
}
.normal-player .middle .middle-l .cd-wrapper{
  position: absolute;
  left: 10%;
  top: 0;
  width: 80%;
  height: 100%;
}
.normal-player .middle .middle-l .cd-wrapper .cd{
  width: 100%;
  height: 100%;
  box-sizing: border-box;
  border: 10px solid rgba(255, 255, 255, 0.1);
  border-radius: 50%;
}
.normal-player .middle .middle-l .cd-wrapper .cd .image{
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  border-radius: 50%;
}
.normal-player .bottom{
  position: absolute;
  bottom: 50px;
  width: 100%;
}
.normal-player .bottom .progress-wrapper{
  display: flex;
  align-items: center;
  width: 80%;
  margin: 0px auto;
  padding: 10px 0;
}
.normal-player .bottom .progress-wrapper .time{
  color: #fff;
  font-size: 12px;
  flex: 0 0 30px;
  line-height: 30px;
  width: 30px;
}
.normal-player .bottom .progress-wrapper .time-l{
    text-align: left;
}
.normal-player .bottom .progress-wrapper .time-r{
  text-align: right;
}
.normal-player .bottom .progress-wrapper .progress-bar-wrapper{
  flex: 1;
}



.normal-player .bottom .dot-wrapper{
  text-align: center;
  font-size: 0;
}
.normal-player .bottom .operators{
  display: flex;
  align-items: center;
}
.normal-player .bottom .operators .icon1{
  flex: 1;
  color: #fb7299;
}
.normal-player .bottom .operators .icon1 i{
  font-size: 30px;
}
.normal-player .bottom .operators .i-left{
  text-align: right;
}
.normal-player .bottom .operators .i-center{
  padding: 0 20px;
  text-align: center;
}
.normal-player .bottom .operators .i-center i{
  font-size: 40px;
}
.normal-player .bottom .operators .i-right{
  text-align: left;
}

.mini-player{
  display: flex;
  align-items: center;
  position: fixed;
  left: 0;
  bottom: 0;
  z-index: 180;
  width: 100%;
  height: 60px;
  background:#333;
}
.mini-player .icon-img{
  flex: 0 0 40px;
  width: 40px;
  padding: 0 10px 0 20px;
}
.mini-player .icon-img img{
  border-radius: 50%;
}
.mini-player .text{
  display: flex;
  flex-direction: column;
  justify-content: center;
  flex: 1;
  line-height: 20px;
  overflow: hidden;
}
.mini-player .text .name{
  margin-bottom: 2px;
  /* no-wrap() */
  font-size: $font-size-medium;
  color: #fff;
}
.mini-player .text .desc{
  /* no-wrap() */
  font-size: 12px;
  color: rgba(255, 255, 255, 0.3);
}
.mini-player .control{
  flex: 0 0 30px;
  width: 30px;
  padding: 0 10px;
}
.icon-liebiao{
  font-size: 30px;
  color: rgba(251, 114, 153, 0.5);
}
.control i{
  font-size: 30px;
}
#minizi{
  font-size: 32px !important;
}
.play{
  animation: rotate 20s linear infinite;
}
.pause{
  animation-play-state: paused;
}
.disable{
  color: rgba(251, 114, 153, 0.5) !important
}
.icon-mini{
  position: absolute;
  left: 0.5px;
  top: 0px;
}

@keyframes rotate{
  0%{
    transform: rotate(0)
  }
  100%{
    transform: rotate(360deg)
  }
}




</style>
