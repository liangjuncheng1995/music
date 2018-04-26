<template lang="html">
  <div class="no-result">
    <div class="no-result-icon">
    <p class="no-result-text">{{title}}</p>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      title: {
        type: String,
        default: ''
      }
    }
  }
</script>

<style lang="css" scoped="">
  .no-result{
    text-align: center;
  }
  .no-result-icon{
    width: 86px;
    height: 90px;
    margin: 0 auto;
    background: url(recom-only.png);
    background-size: 86px 90px;
  }
  .no-result-text{
    margin-top: 30px;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.3);
    position: relative;
    top: -40px;

  }

</style>
