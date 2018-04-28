<template lang="html">
  <transition name="list-fade">
    <div class="playlist">
      <div class="list-wrapper">
        <div class="list-header">
          <h1 class="title">
            <i class="icon1"></i>
            <span class="text"></span>
            <span class="clear"><i class="icon iconfont icon-shanchu"></i></span>
          </h1>
        </div>
        <div class="list-content">
          <ul>
            <li class="item">
              <i class="current"></i>
              <span class="text"></span>
              <span class="like">
                <i class="icon iconfont icon-favoriteoutline"></i>
              </span>
              <span class="delete">
                <i class="icon iconfont icon-shachu-xue"></i>
              </span>
            </li>
          </ul>
        </div>
        <div class="list-operate">
          <div class="add">
            <i class="icon iconfont icon-msnui-add-line"></i>
            <span class="text">添加歌曲列表</span>
          </div>
        </div>
        <div class="list-close">
          <span>关闭</span>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {

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

  .list-enter-active, .list-leave-active{
    transition: all 0.1s;
  }
  .list-enter, .list-leave-to{
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
