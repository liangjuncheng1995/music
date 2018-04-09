<template>
  <div class="recommend">
    <div class="recommend-content">
      <div v-if="recommends.length" class="slider-wrapper">
        <slider>
          <div v-for="item in recommends">
            <a :href="item.linkUrl">
              <img :src="item.picUrl">
            </a>
          </div>
        </slider>
      </div>
      <div class="recommend-list">
        <h1 class="list-title">新</h1>
        <ul></ul>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
  import Slider from 'base/slider/slider'
  import {getRecommend} from 'api/recommend'
  import {ERR_OK} from 'api/config'
  export default {
    data(){
      return{
        recommends:[]
      }
    },
    created(){
      this._getRecommend()
    },
    methods:{
      _getRecommend(){
        getRecommend().then((res) => {
          if(res.code === ERR_OK){
            this.recommends = res.data.slider
          }
        })
      }
    },
    components:{
      Slider
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
