<template lang="html">
  <transition name="slide">
    <div class="user-center">
      <div class="back">
        <i class="icon iconfont icon-fanhui"></i>
      </div>
      <div class="switches-wrapper">
        <switches @switch="switchItem" :switches="switches" :currentIndex="currentIndex"></switches>
      </div>
      <div ref="playBtn" class="play-btn">
        <i class="icon iconfont icon-play"></i>
        <span class="text">随机播放全部</span>
      </div>
      <div class="list-wrapper" ref="listWrapper">

      </div>
    </div>
  </transition>
</template>

<script>
  import Switches from 'base/switches/switches'
  export default {
    data() {
      return {
        currentIndex : 0,
        switches: [
          {name: '我喜欢的'},
          {name: '最近听的'}
        ]
      }
    },
    methods: {
      switchItem(index) {
        this.currentIndex = index
      }
    },
    components: {
      Switches
    }
  }
</script>

<style lang="css" scoped="">
  .user-center{
    position: fixed;
    top: 0;
    bottom: 0;
    z-index: 100;
    width: 100%;
    background: #222;
  }
  .slide-enter-active, .slide-leave-active{
    transition: all 0.3s;
  }
  .slide-enter, .slide-leave-to{
    transform: translate3d(100%, 0, 0);
  }
  .user-center .back{
    position:absolute;
    top: 0;
    left: 6px;
    z-index: 50;
  }
  .user-center .back .icon-fanhui{
    display: block;
    padding: 10px;
    font-size: 22px;
    color: #fb7299;
  }
  .user-center .switches-wrapper{
    margin: 10px 0 30px 0;
  }
  .user-center .play-btn{
    box-sizing: border-box;
    width: 135px;
    padding: 7px 0;
    margin: 0 auto;
    text-align: center;
    border: 1px solid  rgba(255, 255, 255, 0.5);
    color: rgba(255, 255, 255, 0.5);
    border-radius: 100px;
    font-size: 0;
  }
  .user-center .play-btn .icon-play{
    display: inline-block;
    vertical-align: middle;
    margin-right: 6px;
    font-size: 16px;
  }
  .user-center .play-btn .text{
    display: inline-block;
    vertical-align: middle;
    font-size: 12px;
  }
  .list-wrapper{
    position: absolute;
    top: 110px;
    bottom: 0;
    width: 100%;
  }
</style>
