<template lang="html">
  <scroll class="listview" :data="data">
    <ul>
      <li v-for="group in data" class="list-group">
        <h2 class="list-group-title">{{group.title}}</h2>
        <ul>
          <li v-for="item in group.items" class="list-group-item">
            <img v-lazy="item.avatar" class="avatar" alt="">
            <span class="name">{{item.name}}</span>
          </li>
        </ul>
      </li>
    </ul>
  </scroll>
</template>

<script>
  import scroll from 'base/scroll/scroll'

  export default {
    props:{
      data:{
        type:Array,
        default:[]
      }
    },
    components:{
      scroll
    }
  }
</script>

<style lang="css">
.listview{
  position: relative;
  width: 100%;
  height: 100%;
  overflow: hidden;
  background: #222;
}
.list-group{
  padding-bottom: 30px;
}
.list-group-title{
  height: 30px;
  line-height: 30px;
  padding-left: 20px;
  font-size: 12px;
  color: rgba(255, 255, 255, 0.5);
  background: #333;
}
.list-group-item{
  display: flex;
  align-items: center;
  padding: 20px 0 0 30px;
}
.list-group-item .avatar{
  width: 50px;
  height: 50px;
  border-radius: 50%;
}
.list-group-item .name{
  margin-left: 20px;
  color: rgba(255, 255, 255, 0.5);
  font-size: 14px;
}

</style>
