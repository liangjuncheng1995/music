<template lang="html">
  <div class="slider" ref="slider">
    <div class="slider-group" ref="sliderGroup">
      <slot>

      </slot>
    </div>
    <div class="dots">
      <span class="dot" v-for="(item,index) in dots" :class="{active:currentPageIndex === index}"></span>
    </div>
  </div>
</template>

<script>
  import {addClass} from 'common/js/dom'
  import BScroll from 'better-scroll'
  export default {
    // name: 'slider',
    data(){
      return {
        dots:[],
        currentPageIndex : 0
      }
    },
    props:{
      loop:{
        type:Boolean,
        default:true
      },
      autoPlay:{
        type:Boolean,
        default:true
      },
      interval:{
        type:Number,
        default:4000
      }
    },
    mounted(){
      setTimeout(() => {
        this._setSliderWidth()
        this._initDots()
        this._initSlider()
        if(this.autoPlay){
          this._play()
        }
      },20)
      window.addEventListener('resize', () => {
        if(!this.slider){
          return
        }
        this._setSliderWidth(true)
        this.slider.refresh()
      })
    },
    methods:{
      _setSliderWidth(isResize) {
        this.children = this.$refs.sliderGroup.children
        console.log(this.children.length)
        let width = 0
        let sliderWidth = this.$refs.slider.clientWidth
        for(let i=0;i<this.children.length;i++){
          let child = this.children[i]
          addClass(child,'slider-item')
          child.style.width = sliderWidth + 'px'
          width += sliderWidth
        }
        if(this.loop && !isResize){
          width += 2 * sliderWidth
        }
        this.$refs.sliderGroup.style.width = width + 'px'
      },
      _initDots(){
        this.dots = new Array(this.children.length)
      },
      _initSlider() {//控制轮播图的滚动
        this.slider = new BScroll(this.$refs.slider,{
          scrollX:true,
          scrollY:true,
          momentum:false,
          snap:true,
          snapLoop:this.loop,
          snapThreshold:0.3,
          snapSpeed:400,
          click:true
        })
        this.slider.on('scrollEnd',() => {
          let pageIndex = this.slider.getCurrentPage().pageX
          if(this.loop){
            pageIndex -= 1
            this.currentPageIndex = pageIndex
            if(this.autoPlay){
              clearTimeout(this.timer)
              this._play()
            }
          }
        })
      },
      _play(){
        let pageIndex = this.currentPageIndex + 1
        if(this.loop){
          pageIndex += 1
        }
        this.timer = setTimeout(() => {
          this.slider.goToPage(pageIndex,0,400)
        },this.interval)
      }
    },
    destroyed(){
      clearTimeout(this.timer)
    }
  }
</script>

<style lang="css">
  .slider{
    min-height: 1px;
  }
  .slider-group{
    position: relative;
    overflow: hidden;
    white-space: nowrap;
  }
  .slider-group a{
    display: block;
    width: 100%;
    overflow: hidden;
    text-decoration: none;
  }
  .slider-group img{
    display: block;
    width: 100%;
  }
  .dots{
    position: absolute;
    right: 0;
    left: 0;
    bottom: 12px;
    text-align: center;
    font-size: 0;
  }
  .slider-item{
    float: left;
    box-sizing: border-box;
    overflow: hidden;
    text-align: center;
  }
  .dots{
    position: absolute;
    right: 0;
    left: 0;
    bottom: 12px;
    text-align: center;
    font-size: 0;
  }
  .dot{
    display: inline-block;
    margin: 0 4px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
  }
  .dots .active{
    width: 20px;
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.8);
  }
</style>
