<template>
  <div class="recommend">
    <div class="recommend-content">
      <div class="slider-wrapper"></div>
      <div class="recommend-list">
        <h1 class="list-title">热门歌单推荐</h1>
        <ul></ul>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
  // import Slider from 'base/slider/slider'
  import {getRecommend} from 'api/recommend'
  import {ERR_OK} from 'api/config'
  export default {

    created(){
      this._getRecommend()
    },
    methods:{
      _getRecommend(){
        getRecommend().then((res) => {
          if(res.code === ERR_OK){
            // console.log(res.data.slider)
          }
        })
      }
    }
  }
</script>

<style type="text/css">
  .recommend{
    position: fixed;
    width: 100%;
    top: 88px;
    bottom: 0;
  }
  .recommend-content{
    height: 100%;
    overflow: hidden;
  }
  .slider-wrapper{
    position: relative;
    width: 100%;
    overflow: hidden;
  }
  .list-title{
    height: 65px;
    line-height: 65px;
    text-align: center;
    font-size: 14px;
    color: #fb7299;
  }
</style>
