<template>
  <div class="tab">
    <router-link tag="div" class="tab-item" to="/recommend">
      <span class="tab-link">推荐</span>
    </router-link>
    <router-link tag="div" class="tab-item" to="/singer">
      <span class="tab-link">歌手</span>
    </router-link>
    <router-link tag="div" class="tab-item" to="/rank">
      <span class="tab-link">排行</span>
    </router-link>
    <router-link tag="div" class="tab-item" to="/search">
      <span class="tab-link">搜索</span>
    </router-link>
  </div>
</template>

<script type="text/javascript">
  export default{

  }
</script>

<style lang="css">
  .tab{
    display: flex;
    height: 44px;
    line-height: 44px;
    font-size: 14px;
  }
  .tab-item{
    flex: 1;
    text-align: center;
  }
  .tab-link{
    padding-bottom: 5px;
    color: rgba(255, 255, 255, 0.5);
  }
  .router-link-active .tab-link{
    color: #fb7299;
    border-bottom: 2px solid #fb7299;
  }
</style>
