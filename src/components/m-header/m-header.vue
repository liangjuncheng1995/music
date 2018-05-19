<template>
  <div class="m-header">
	<div class="header-icon"></div>
	<h1 class="header-text">Bilibili Music</h1>
  <router-link to="/user" class="mine" tag="div">
    <i class="icon iconfont icon-user"></i>
  </router-link>
  </div>
</template>

<script type="text/javascript">
	export default {}
</script>

<style type="text/css">
	.m-header{
		position: relative;
	    height: 44px;
	    text-align: center;
	    color: #fb7299;
	    font-size: 0;
	}
	.header-icon{
	  display: inline-block;
      vertical-align: top;
      margin-top: 5px;
      width: 30px;
      height: 32px;
      margin-right: 9px;
      background: url('logo@2x.png');
      background-size: 30px 32px;
	}
	.header-text{
	  display: inline-block;
      vertical-align: top;
      line-height: 44px;
      font-size: 18px;
	}
  .mine{
    position: absolute;
    top: 0;
    right: 0;
  }
  .icon-user{
    display: block;
    padding: 12px;
    font-size: 20px;
    color: #fb7299;
  }




</style>
