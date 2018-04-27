<template lang="html">
  <div class="search-list" v-show="searches.length">
    <ul>
      <li @click="selectItem(item)" class="search-item" v-for='item in searches'>
        <span class="text">{{item}}</span>
        <span class="icon1" @click.stop="deleteOne(item)">
          <i class="icon iconfont icon-shachu-xue"></i>
        </span>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    props: {
      searches: {
        type: Array,
        default: []
      }
    },
    methods: {
      selectItem(item) {
        this.$emit('select',item)
      },
      deleteOne(item) {
        this.$emit('delete',item)
      }
    }
  }
</script>

<style lang="css" scoped="">
.search-list .search-item{
  display: flex;
  align-items: center;
  height: 40px;
  overflow: hidden;
}
.search-list .search-item .text{
  flex: 1;
  color: rgba(255, 255, 255, 0.5);
}
.search-list .search-item .icon1{
  position: relative;
}
.search-list .search-item .icon1::before{
  content: '';
  position: absolute;
  top: -10px;
  left: -10px;
  right: -10px;
  bottom: -10px;
}
.icon-shanchu{
  font-size: 12px;
  color: rgba(255, 255, 255, 0.3);
}


</style>
