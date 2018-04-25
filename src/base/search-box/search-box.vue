<template lang="html">
  <div class="search-box">
    <i class="icon iconfont icon-sousuo"></i>
    <input class="box" v-model="query" :placeholder="placeholder">
    <i @click="clear" v-show="query" class="icon iconfont icon-delete"></i>
  </div>
</template>

<script>
export default {
  props: {
    placeholder: {
      type:String,
      default: '搜索歌曲、歌手'
    }
  },
  data() {
    return {
      query: ''
    }
  },
  methods: {
    clear() {
      this.query = ''
    },
    setQuery(query) {
      this.query = query
    }
  },
  created() {
    this.$watch('query' ,(newQuery) => {
      this.$emit('query',newQuery)
    })
  }
}
</script>

<style lang="css" scoped="">
  .search-box{
    display: flex;
    align-items: center;
    box-sizing: border-box;
    width: 100%;
    padding: 0 6px;
    height: 40px;
    background: #333;
    border-radius: 6px;
  }
  .icon-sousuo{
    font-size: 24px;
    color: #222;
  }
  .box{
    flex: 1;
    margin: 0 20px;
    line-height: 18px;
    background: #333;
    color: #fff;
    font-size: 14px;
  }
  input::-webkit-input-placeholder{ /*WebKit browsers*/
    color: rgba(255, 255, 255, 0.3);
  }
  input::-moz-input-placeholder{ /*Mozilla Firefox*/
    color: rgba(255, 255, 255, 0.3);
  }
  input::-ms-input-placeholder{ /*Internet Explorer*/
    color: rgba(255, 255, 255, 0.3);
  }
  .icon-delete{
    font-size: 16px;
    color: #222;
  }

/* .search-box
  display: flex
  align-items: center
  box-sizing: border-box
  width: 100%
  padding: 0 6px
  height: 40px
  background: $color-highlight-background
  border-radius: 6px
  .icon-search
    font-size: 24px
    color: $color-background
  .box
    flex: 1
    margin: 0 5px
    line-height: 18px
    background: $color-highlight-background
    color: $color-text
    font-size: $font-size-medium
    &::placeholder
      color: $color-text-d
  .icon-dismiss
    font-size: 16px
    color: $color-background */
</style>
