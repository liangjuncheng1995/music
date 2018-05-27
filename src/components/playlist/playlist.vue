<template lang="html">
  <transition name="list-fade">
    <div class="playlist" v-show="showFlag" @click='hide'>
      <div class="list-wrapper" @click.stop>
        <div class="list-header">
          <h1 class="title">
            <i class="icon1" :class="iconMode" @click="changeMode"></i>
            <span class="text">{{modeText}}</span>
            <span class="clear" @click="showConfirm"><i class="icon iconfont icon-shanchu"></i></span>
          </h1>
        </div>
        <scroll ref="listContent" :refreshDelay="refreshDelay" :data="sequenceList" class="list-content">
          <transition-group  tag="ul" name="list" >
            <li class="item" v-for="(item,index) in sequenceList" :key="item.id" @click="selectItem(item,index)" ref="listItem">
              <i class="current" :class="getCurrentIcon(item)"></i>
              <span class="text">{{item.name}}</span>
              <span @click.stop="toggleFavorite(item)" class="like">
                <i class="icon iconfont" :class="getFavoriteIcon(item)"></i>
              </span>
              <span class="delete" @click.stop="deleteOne(item)">
                <i class="icon iconfont icon-shachu-xue"></i>
              </span>
            </li>
          </transition-group>
        </scroll>
        <div class="list-operate">
          <div class="add" @click="addSong">
            <i class="icon iconfont icon-msnui-add-line"></i>
            <span class="text">添加歌曲列表</span>
          </div>
        </div>
        <div @click="hide" class="list-close">
          <span>关闭</span>
        </div>
      </div>
      <confirm ref="confirm" @confirm="confirmClear" text="是否清空播放列表" confirmBtnText="清空"></confirm>
      <add-song ref="addSong"></add-song>
    </div>
  </transition>
</template>

<script>
  import {mapActions} from 'vuex'
  import {playMode} from 'common/js/config'
  import Scroll from 'base/scroll/scroll'
  import Confirm from 'base/confirm/confirm'
  import {playerMixin} from 'common/js/mixin'
  import AddSong from 'components/add-song/add-song'
  export default {
    mixins: [playerMixin],
    data() {
      return {
        showFlag:false,
        refreshDelay: 100
      }
    },
    computed: {
      modeText() {
        return this.mode === playMode.sequence ? '顺序播放' : this.mode === playMode.random ? '随机播放' : '单曲循环'
      }
    },
    methods: {
      show() {
        this.showFlag = true
        setTimeout(() => {
          this.$refs.listContent.refresh()
          this.scrollToCurrent(this.currentSong)
        },20)
      },
      hide() {
        this.showFlag = false
      },
      getCurrentIcon(item) {
        if(this.currentSong.id === item.id){
          return 'icon iconfont icon-play'
        }
        return ''
      },
      selectItem(item,index) {
        if(this.mode === playMode.random) {
          index = this.playlist.findIndex((song) => {
            return song.id === item.id
          })
        }
        this.setCurrentIndex(index)
        this.setPlayingState(true)
      },

      scrollToCurrent(current) {
        const index = this.sequenceList.findIndex((song) => {
          return current.id === song.id
        })
        this.$refs.listContent.scrollToElement(this.$refs.listItem[index], 300)
      },
      deleteOne(item) {
        this.deleteSong(item)
        if(!this.playlist.length){
          this.hide()
        }
      },
      showConfirm() {
        this.$refs.confirm.show()
      },
      confirmClear() {
        this.deleteSongList()
      },
      addSong() {
        this.$refs.addSong.show()
      },
      ...mapActions([
        'deleteSong',
        'deleteSongList'
      ])
    },
    watch: {
      currentSong(newSong,oldSong) {
        if(!this.showFlag || newSong.id === oldSong.id){
          return
        }
        this.scrollToCurrent(newSong)
      }
    },
    components: {
      Scroll,
      Confirm,
      AddSong
    }
  }
</script>

<style lang="css" scoped="">
  .playlist{
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    z-index: 200;
    background-color: rgba(0, 0, 0, 0.3);
  }
  .list-fade-enter-active, .list-fade-leave-active{
    transition: opacity 0.3s;
  }
  .list-fade-enter, .list-fade-leave-to{
    opacity: 0;
  }
  .list-fade-enter-active .list-wrapper {
    transition: all 0.3s;
  }
  .list-fade-leave-active .list-wrapper{
    transition: all 0.3s;
  }
  .list-fade-enter .list-wrapper {
    transform: translate3d(0, 100%, 0);
  }
  .list-fade-leave-to  .list-wrapper{
    transform: translate3d(0, 100%, 0);
  }
  .playlist  .list-wrapper{
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: #333;
  }
  .playlist  .list-wrapper .list-header{
    position: relative;
    padding: 20px 30px 10px 20px;
  }
  .playlist  .list-wrapper .list-header .title{
    display: flex;
    align-items: center;
  }
  .playlist  .list-wrapper .list-header .title .icon1{
    margin-right: 10px;
    font-size: 30px;
    color: rgba(251, 114, 153, 0.5);
  }
  .playlist  .list-wrapper .list-header .title .text{
    flex: 1;
    font-size: 14px;
    color:rgba(255, 255, 255, 0.5);
  }
  .playlist  .list-wrapper .list-header .title .clear{
    position: relative;
  }
  .playlist  .list-wrapper .list-header .title .clear::before{
    content: '';
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
  }
  .icon-shanchu{
    font-size: 14px;
    color: rgba(255, 255, 255, 0.3);
  }

  .list-content{
    max-height: 240px;
    overflow: hidden;
  }
  .list-content .item{
    display: flex;
    align-items: center;
    height: 40px;
    padding: 0 30px 0 20px;
    overflow: hidden;
  }

  .list-content .list-enter-active, .list-content .list-leave-active{
    transition: all 0.1s linear;
  }
  .list-content .list-enter, .list-content .list-leave-to{
    height: 0;
  }
  .list-content .item .current{
    flex: 0 0 20px;
    width: 20px;
    font-size: 12px;
    color: rgba(251 , 114, 153, 0.5);
  }
  .list-content .item .text{
    flex: 1;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.3);
  }
  .list-content .item .like{
    position: relative;
    margin-right: 15px;
    font-size: 12px;
    color: rgb(251 , 114, 153);
  }
  .list-content .item .like::before{
    content: '';
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
  }
  .list-content .item .like .icon-favorite{
    color: #d93f30;
  }
  .list-content .item .delete{
    position: relative;
    font-size: 12px;
    color: rgb(251 , 114, 153);
  }
  .list-content .item .delete::before{
    content: '';
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
  }


  .list-operate{
    width: 140px;
    margin: 20px auto 30px auto;
  }
  .list-operate .add{
    display: flex;
    align-items: center;
    padding: 8px 16px;
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 100px;
    color: rgba(255, 255, 255, 0.5);
  }
  .icon-msnui-add-line{
    margin-right: 5px;
    font-size:10px;
  }
  .list-operate .add .text{
    font-size: 12px;
  }
  .list-close{
    text-align: center;
    line-height: 50px;
    background: #222;
    font-size: 16px;
    color: rgba(255, 255, 255, 0.5);
  }




</style>
