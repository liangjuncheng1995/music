webpackJsonp([5],{"5RER":function(t,n){},BRgg:function(t,n,e){"use strict";n.b=function(){var t=s()({},c.b,{uin:0,playform:"h5",needNewCode:1});return Object(o.a)("https://c.y.qq.com/v8/fcg-bin/fcg_myqq_toplist.fcg",t,c.c)},n.a=function(t){var n=s()({},c.b,{topid:t,platform:"h5",needNewCode:1,page:"detail",type:"top",tpl:3});return Object(o.a)("https://c.y.qq.com/v8/fcg-bin/fcg_v8_toplist_cp.fcg",n,c.c)};var i=e("aA9S"),s=e.n(i),o=e("Gak4"),c=e("T452")},s3x3:function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var i=e("4YfN"),s=e.n(i),o=e("kvay"),c=e("HVJf"),a=e("BRgg"),r=e("T452"),u=e("PvFA"),g={computed:s()({title:function(){return this.topList.topTitle},bgImage:function(){return this.songs.length?this.songs[0].image:""}},Object(c.c)(["topList"])),data:function(){return{songs:[],rank:!0}},created:function(){this._getMusicList()},methods:{_getMusicList:function(){var t=this;this.topList.id?Object(a.a)(this.topList.id).then(function(n){n.code===r.a&&(console.log(1),t.songs=t._normalizeSongs(n.songlist))}):this.$router.push("/rank")},_normalizeSongs:function(t){var n=[];return t.forEach(function(t){var e=t.data;e.songid&&e.albumid&&n.push(Object(u.a)(e))}),n}},components:{MusicList:o.a}},f={render:function(){var t=this.$createElement,n=this._self._c||t;return n("transition",{attrs:{name:"slide"}},[n("music-list",{attrs:{rank:this.rank,title:this.title,"bg-image":this.bgImage,songs:this.songs}})],1)},staticRenderFns:[]};var l=e("Z0/y")(g,f,!1,function(t){e("5RER")},null,null);n.default=l.exports}});