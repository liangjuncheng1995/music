<template lang="html">
  <transition name="slide">
    <div class="add-song" v-show="showFlag" @click.stop>
      <div class="header">
        <h1 class="title">添加歌曲到列表</h1>
        <div class="close" @click="hide">
          <i class="icon iconfont icon-shachu-xue"></i>
        </div>
      </div>
      <div class="search-box-wrapper">
        <search-box @query="onQueryChange" placeholder="搜索歌曲"></search-box>
      </div>
      <div class="shortcut" v-show="!query">

      </div>
      <div class="search-result" v-show="query">
        <suggest :query="query" :showSinger="showSinger" @select="selectSuggest" @listScroll="blurInput"></suggest>
      </div>
    </div>
  </transition>
</template>

<script>
  import SearchBox from 'base/search-box/search-box'
  import Suggest from 'components/suggest/suggest'
  import {searchMixin} from 'common/js/mixin'


  export default {
    mixins:[searchMixin],
    data() {
      return {
        showFlag : false,
        showSinger : false
      }
    },
    methods: {
      show() {
        this.showFlag = true
      },
      hide() {
        this.showFlag = false
      },

      selectSuggest() {
        this.saveSearch()
      }
    },
    components: {
      SearchBox,
      Suggest
    }
  }
</script>

<style lang="css" scoped="">
  .add-song{
    position: fixed;
    top: 0;
    bottom: 0;
    width: 100%;
    z-index: 200;
    background: #222;
  }
  .slide-enter-active, .slide-leave-active{
    transition: all 0.3s;
  }
  .slide-enter, .slide-leave-to{
    transform: translate3d(100%, 0, 0);
  }
  .add-song .header{
    position: relative;
    height: 44px;
    text-align: center;
  }
  .add-song .header .title{
    line-height: 44px;
    font-size: 18px;
    color: #fff;
  }
  .add-song .header .close{
    position: absolute;
    top: 0;
    right: 8px;
  }
  .icon-shachu-xue{
    display: block;
    padding: 12px;
    font-size: 20px;
    color: #fb7299;
  }
  .search-box-wrapper{
    margin: 20px;
  }



</style>
