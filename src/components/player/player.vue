<template lang="html">
  <div class="player" v-show='playlist.length>0'>
    <div class="normal-player" v-show="fullScreen">
      播放器
      <div class="background">
        <img width="100%" height="100%" src="" >
      </div>
      <div class="top">
        <div class="back">
          <i class="icon iconfont icon-fanhui"></i>
        </div>
        <h1 class="title"></h1>
        <h2 class="subtitle"></h2>
      </div>
      <div class="middle">
        <div class="middle-l">
          <div class="cd-wrapper">
            <div class="cd">
              <img class="image">
            </div>
          </div>
        </div>
      </div>
      <div class="bottom">
        <div class="operators">
          <div class="icon i-left">
            <i class="icon-sequence"></i>
          </div>
          <div class="icon i-left">
            <i class="icon-prev"></i>
          </div>
          <div class="icon i-center">
            <i class="icon-play"></i>
          </div>
          <div class="icon i-right">
            <i class="icon-next"></i>
          </div>
          <div class="icon i-right">
            <i class="icon icon-not-favorite"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="mini-player" v-show="!fullScreen">
      <div class="icon">
        <img width="40" height="40">
      </div>
      <div class="text">
        <h2 class="name"></h2>
        <p class="desc"></p>
      </div>
      <div class="control">

      </div>
      <div class="control">
        <i class="icon-playlist"></i>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
  computed:{
    ...mapGetters([
      'fullScreen',
      'playlist'
    ])
  }
}
</script>

<style lang="css">
.player  .normal-player{
  position: fixed;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  z-index: 150;
  background: #222;
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





</style>
