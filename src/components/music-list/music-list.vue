<template lang="html">
  <div class="music-list">
    <div class="back" @click="back">
      <i class="icon iconfont icon-fanhui"></i>
    </div>
    <h1 class="title" v-html="title"></h1>
    <div class="bg-image" :style="bgStyle" ref="bgImage">
      <div class="play-wrapper">
        <div class="play" ref="playBtn" v-show='songs.length>0' @click="random">
          <i class="icon iconfont icon-play"></i>
          <span class="text">随机播放全部</span>
        </div>
      </div>
      <div class="filter" ref="filter"></div>
    </div>
    <div class="bg-layer" ref="layer"></div>
    <scroll @scroll="scroll" :probe-type='probeType' :listen-scroll="listenScroll" :data="songs" class="list" ref="list">
      <div class="song-list-wrapper">
        <song-list :rank="rank" @select="selectItem" :songs="songs"></song-list>
      </div>
      <div class="loading-container" v-show="!songs.length">
        <loading></loading>
      </div>
    </scroll>
  </div>
</template>

<script>
  import scroll from 'base/scroll/scroll'
  import SongList from 'base/song-list/song-list'
  import loading from 'base/loading/loading'
  import {prefixStyle} from 'common/js/dom'
  import {mapActions} from 'vuex'
  import {playlistMixin} from 'common/js/mixin'

  const RESERVED_HEIGHT = 40
  const transform = prefixStyle('transform')
  const backdrop = prefixStyle('backdrop-filter')

  export default {
    mixins: [playlistMixin],
    props:{
      bgImage:{
        type:String,
        default:''
      },
      songs:{
        type:Array,
        default:[]
      },
      title:{
        type:String,
        default:''
      },
      rank:{
        type:Boolean,
        default:false
      }
    },
    data()  {
      return {
        scrollY:0
      }
    },
    computed:{
      bgStyle() {
        return `background-image:url(${this.bgImage})`
      }
    },
    created(){
      this.probeType = 3
      this.listenScroll = true
    },
    mounted() {
      this.imageHeight = this.$refs.bgImage.clientHeight
      this.minTranslateY = -this.imageHeight + RESERVED_HEIGHT
      this.$refs.list.$el.style.top = `${this.$refs.bgImage.clientHeight}px`
    },
    methods: {
      handlePlaylist(playlist) {
        const bottom = playlist.length > 0 ? '60px' : ''
        this.$refs.list.$el.style.bottom = bottom
        this.$refs.list.refresh()
      },
       scroll(pos){
         this.scrollY = pos.y
       },
       back(){
         this.$router.back()
       },
       selectItem(item,index){
         this.selectPlay({
           list:this.songs,
           index
         })
       },
       random() {
         this.randomPlay({
           list:this.songs
         })
       },
       ...mapActions([
         'selectPlay',
         'randomPlay'
       ])
    },
    watch:{
      scrollY(newY){
        let translateY = Math.max(this.minTranslateY,newY)
        let zIndex = 0
        let scale = 1
        let blur = 0
        this.$refs.layer.style[transform] = `translate3d(0,${translateY}px,0)`
        const percent = Math.abs(newY / this.imageHeight)
        if(newY>0){
          scale = 1 + percent
          zIndex = 10
        }
        else {
          blur = Math.min(20 * percent,20)
        }
        this.$refs.filter.style[backdrop] = `blur(${blur}px)`
        if(newY < this.minTranslateY) {
          zIndex = 10
          this.$refs.bgImage.style.paddingTop = 0
          this.$refs.bgImage.style.height = `${RESERVED_HEIGHT}px`
          this.$refs.playBtn.style.display = 'none'
        }else {
          this.$refs.bgImage.style.paddingTop = '70%'
          this.$refs.bgImage.style.height = 0
          this.$refs.playBtn.style.display = 'block'
        }
        this.$refs.bgImage.style.zIndex = zIndex
        this.$refs.bgImage.style[transform] = `scale(${scale})`
      }
    },
    components:{
      scroll,
      SongList,
      loading
    }
  }
</script>

<style lang="css" scoped="">
.music-list{
  position: fixed;
  z-index: 100;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  background: #222;
}
.back{
  position:absolute;
  top: 0;
  left: 6px;
  z-index: 50;
}
.icon-fanhui{
  display: block;
  padding: 10px;
  font-size: 22px;
  color: #fb7299;
  font-weight: bolder;
}
.title{
  position: absolute;
  top: 0;
  left: 10%;
  z-index: 40;
  width: 80%;
  /* no-wrap(); */
  text-align: center;
  line-height: 40px;
  font-size: 18px;
  color: #fff;
}
.bg-image{
  position: relative;
  width: 100%;
  height: 0;
  padding-top: 70%;
  transform-origin: top;
  background-size: cover;
}
.play-wrapper{
  position: absolute;
  bottom: 20px;
  z-index: 50;
  width: 100%;
}
.play-wrapper .play{
  box-sizing: border-box;
  width: 135px;
  padding: 7px 0;
  margin: 0 auto;
  text-align: center;
  border: 1px solid #fb7299;
  color: #fb7299;
  border-radius: 100px;
  font-size: 0;
}
.icon-play{
  display: inline-block;
  vertical-align: middle;
  margin-right: 6px;
  font-size: 16px;
  font-weight: bold;
}
.play-wrapper .play .text{
  display: inline-block;
  vertical-align: middle;
  font-size: 12px;
}
.filter{
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(7, 17, 27, 0.4);
}
.music-list .list{
  position: fixed;
  top: 0;
  bottom: 0;
  width: 100%;
  background: #222;
  /* overflow: hidden; */
}
.song-list-wrapper{
  padding: 20px 30px;
}
.bg-layer{
  position: relative;
  height: 100%;
  background: #222;
}


/* .music-list
  position: fixed
  z-index: 100
  top: 0
  left: 0
  bottom: 0
  right: 0
  background: $color-background
  .back
    position absolute
    top: 0
    left: 6px
    z-index: 50
    .icon-back
      display: block
      padding: 10px
      font-size: $font-size-large-x
      color: $color-theme
  .title
    position: absolute
    top: 0
    left: 10%
    z-index: 40
    width: 80%
    no-wrap()
    text-align: center
    line-height: 40px
    font-size: $font-size-large
    color: $color-text
  .bg-image
    position: relative
    width: 100%
    height: 0
    padding-top: 70%
    transform-origin: top
    background-size: cover
    .play-wrapper
      position: absolute
      bottom: 20px
      z-index: 50
      width: 100%
      .play
        box-sizing: border-box
        width: 135px
        padding: 7px 0
        margin: 0 auto
        text-align: center
        border: 1px solid $color-theme
        color: $color-theme
        border-radius: 100px
        font-size: 0
        .icon-play
          display: inline-block
          vertical-align: middle
          margin-right: 6px
          font-size: $font-size-medium-x
        .text
          display: inline-block
          vertical-align: middle
          font-size: $font-size-small
    .filter
      position: absolute
      top: 0
      left: 0
      width: 100%
      height: 100%
      background: rgba(7, 17, 27, 0.4)
  .bg-layer
    position: relative
    height: 100%
    background: $color-background
  .list
    position: fixed
    top: 0
    bottom: 0
    width: 100%
    background: $color-background
    .song-list-wrapper
      padding: 20px 30px
    .loading-container
      position: absolute
      width: 100%
      top: 50%
      transform: translateY(-50%) */
</style>
