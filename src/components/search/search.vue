<template>
  <div class="search">
    <div class="search-box-wrapper">
      <search-box ref="searchBox" @query="onQueryChange"></search-box>
    </div>
    <div ref="shortcutWrapper" class="shortcut-wrapper" v-show="!query">
      <scroll :refreshDelay="refreshDelay" class="shortcut" ref="shortcut" :data="shortcut">
        <div>
          <div class="hot-key">
            <h1 class="title">热门搜索</h1>
            <ul>
              <li @click="addQuery(item.k)" class="item" v-for="item in hotKey">
                <span>{{item.k}}</span>
              </li>
            </ul>
          </div>
          <div class="search-history" v-show="searchHistory.length">
              <h1 class="title">
              <span class="text">搜索历史</span>
              <span class="clear" @click="showConfirm">
                  <i class="icon iconfont icon-shanchu"></i>
              </span>
            </h1>
            <search-list @select="addQuery" @delete="deleteSearchHistory" :searches="searchHistory"></search-list>
          </div>
        </div>
      </scroll>
    </div>
    <div ref="searchResult" class="search-result" v-show="query">
      <suggest ref="suggest" @select='saveSearch' @listScroll="blurInput" :query="query"></suggest>
    </div>
    <confirm ref="confirm" text="是否清空所有搜索历史" confirmBtnText="清空" @confirm="clearSearchHistory"></confirm>
    <router-view></router-view>
  </div>
</template>

<script type="text/javascript">
  import SearchBox from 'base/search-box/search-box'
  import {getHotKey} from 'api/search'
  import {ERR_OK} from 'api/config'
  import suggest from 'components/suggest/suggest'
  import SearchList from 'base/search-list/search-list'
  import Confirm from 'base/confirm/confirm'
  import Scroll from 'base/scroll/scroll'
  import {mapActions} from 'vuex'
  import {playlistMixin,searchMixin} from 'common/js/mixin'
  export default {
    mixins: [playlistMixin,searchMixin],
    created() {
      this._getHotKey()
    },
    data() {
      return  {
        hotKey: []
      }
    },
    computed: {
      shortcut() {
        return this.hotKey.concat(this.searchHistory)
      }
    },
    methods: {
      handlePlaylist(playlist) {
        const bottom = playlist.length > 0 ? '60px' : ''
        this.$refs.shortcutWrapper.style.bottom = bottom
        this.$refs.shortcut.refresh()
        this.$refs.searchResult.style.bottom = bottom
        this.$refs.suggest.refresh()
      },

      showConfirm() {
        this.$refs.confirm.show()
      },
      _getHotKey() {
        getHotKey().then((res) => {
          if(res.code === ERR_OK){
            this.hotKey = res.data.hotkey.slice(0,10)
          }
        })
      },
      ...mapActions([
        'clearSearchHistory'
      ])
    },
    watch: {
      query(newQuery) {
        if(!newQuery) {
          setTimeout(() => {
            this.$refs.shortcut.refresh()
          },20)
        }
      }
    },
    components: {
      SearchBox,
      suggest,
      SearchList,
      Confirm,
      Scroll
    }
  }
</script>

<style type="text/css" scoped="">
  .search .search-box-wrapper{
    margin: 20px;
  }
  .shortcut-wrapper{
    position: fixed;
    top: 178px;
    bottom: 0;
    width: 100%;
  }
  .shortcut-wrapper .shortcut{
    height: 100%;
    overflow: hidden;
  }
  .shortcut-wrapper .shortcut .hot-key{
    margin: 0 20px 20px 20px;
  }
  .title{
    margin-bottom: 20px;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.5);
  }
  .item{
    display: inline-block;
    padding: 5px 10px;
    margin: 0 20px 10px 0;
    border-radius: 6px;
    background: #333;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.3);
  }
  .search-result{
    position: fixed;
    width: 100%;
    top: 178px;
    bottom: 0;
  }
  .search-history{
    position: relative;
    margin: 0 20px;
  }
  .search-history .title{
    display: flex;
    align-items: center;
    height: 40px;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.5);
  }
  .search-history .title .text{
    flex: 1;
  }
  .search-history .title .clear{
    position: relative;
  }
  .search-history .title .clear::before{
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




/* .search
  .search-box-wrapper
    margin: 20px
  .shortcut-wrapper
    position: fixed
    top: 178px
    bottom: 0
    width: 100%
    .shortcut
      height: 100%
      overflow: hidden
      .hot-key
        margin: 0 20px 20px 20px
        .title
          margin-bottom: 20px
          font-size: $font-size-medium
          color: $color-text-l
        .item
          display: inline-block
          padding: 5px 10px
          margin: 0 20px 10px 0
          border-radius: 6px
          background: $color-highlight-background
          font-size: $font-size-medium
          color: $color-text-d
      .search-history
        position: relative
        margin: 0 20px
        .title
          display: flex
          align-items: center
          height: 40px
          font-size: $font-size-medium
          color: $color-text-l
          .text
            flex: 1
          .clear
            extend-click()
            .icon-clear
              font-size: $font-size-medium
              color: $color-text-d
  .search-result
    position: fixed
    width: 100%
    top: 178px
    bottom: 0 */
</style>
