<template lang="html">
  <scroll class="suggest"
          :data="result"
          :pullup="pullup"
          :beforeScroll="beforeScroll"
          @scrollToEnd="searchMore"
          @beforeScroll="listScroll"
          ref="suggest"

  >
    <ul class="suggest-list">
      <li @click="selectItem(item)" class="suggest-item" v-for="item in result">
        <div class="icon1">
          <i :class="getIconCls(item)"></i>
        </div>
        <div class="name">
          <p class="text" v-html="getDisplayName(item)"></p>
        </div>
      </li>
      <loading v-show="hasMore" title=""></loading>
    </ul>
    <div v-show="!hasMore && !result.length" class="no-result-wrapper">
      <no-result title="抱歉,暂无搜索结果"></no-result>
    </div>
  </scroll>
</template>

<script>
  import {search} from 'api/search'
  import {ERR_OK} from 'api/config'
  import {createSong} from 'common/js/song'
  import Scroll from 'base/scroll/scroll'
  import Loading from 'base/loading/loading'
  import Singer from 'common/js/singer'
  import {mapMutations,mapActions} from 'vuex'
  import NoResult from 'base/no-result/no-result'

  const TYPE_SINGER = 'singer'
  const perpage = 20

  export default {
    props: {
      query: {
        type: String,
        default: ''
      },
      showSinger: {
        type: Boolean,
        default: true
      }
    },
    data() {
      return  {
        page:1,
        result: [],
        pullup: true,
        beforeScroll: true,
        hasMore:true
      }
    },
    methods: {
      search() {
        this.page = 1
        this.hasMore = true
        this.$refs.suggest.scrollTo(0,0)
        search(this.query,this.page,this.showSinger,perpage).then((res) => {
          if(res.code === ERR_OK){
            this.result = this._genResult(res.data)
            this._checkMore(res.data)
          }
        })
      },
      searchMore() {
        if(!this.hasMore) {
          return
        }
        this.page ++
        search(this.query,this.page,this.showSinger,perpage).then((res) => {
          this.result = this.result.concat(this._genResult(res.data))
          this._checkMore(res.data)
        })
      },
      getIconCls(item) {
        if(item.type === TYPE_SINGER) {
          return 'icon iconfont icon-user'
        }else{
          return 'icon iconfont icon-185068musicnotestreamline'
        }
      },
      getDisplayName(item) {
        if(item.type === TYPE_SINGER) {
          return item.singername
        }else{
          return `${item.name}-${item.singer}`
        }
      },
      selectItem(item) {
        if(item.type === TYPE_SINGER) {
          const singer = new Singer({
            id: item.singermid,
            name: item.singername
          })
          this.$router.push({
            path:`/search/${singer.id}`
          })
          this.setSinger(singer)
        } else {
          this.insertSong(item)
        }
        this.$emit('select')
      },
      listScroll() {
        this.$emit('listScroll')
      },
      _checkMore(data) {
        const song = data.song
        if(!song.list.length || (song.curnum + song.curpage * perpage) > song.totalnum) {
          this.hasMore = false
        }
      },
      _genResult(data) {
        let ret = []
        if(data.zhida && data.zhida.singerid) {
          ret.push({...data.zhida,...{type:TYPE_SINGER}})
        }
        if(data.song) {
          ret = ret.concat(this._normalizeSongs(data.song.list))
        }
        return ret
      },
      _normalizeSongs(list) {
        let ret = []
        list.forEach((musicData) => {
          if(musicData.songid && musicData.albumid) {
            ret.push(createSong(musicData))
          }
        })
        return ret
      },
      ...mapMutations({
        setSinger:'SET_SINGER'
      }),
      ...mapActions([
        'insertSong'
      ])
    },
    watch:{
      query() {
        this.search()
      }
    },
    components: {
      Scroll,
      Loading,
      NoResult
    }
  }
</script>

<style lang="css" scoped="">
.suggest{
  height: 100%;
  overflow: hidden;
}
.suggest .suggest-list{
  padding: 0 30px;
}
.suggest .suggest-list .suggest-item{
  display: flex;
  align-items: center;
  padding-bottom: 20px;
}
.suggest .suggest-list .icon1{
  flex: 0 0 30px;
  width: 30px;
}
.suggest .suggest-list .name{
  flex: 1;
  font-size: 14px;
  color: rgba(255, 255, 255, 0.3);
  overflow: hidden;
}
.suggest .suggest-list .name .text{
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}
.no-result-wrapper{
  position: absolute;
  width: 100%;
  top: 50%;
  transform: translateY(-50%);
}

</style>
