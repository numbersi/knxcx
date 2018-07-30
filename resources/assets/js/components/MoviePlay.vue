<template>
  <div >

    <MyPlayer   id="MoviePlay" :options="playerOptions" ></MyPlayer>
    <canvas v-if="showTishi"  v-on:click="canvass()" id="canvas" width="500" height="400" style="position:absolute;top:0;left:0; z-index: 2147483647;">
        您的浏览器不支持canvas标签。
    </canvas>
    <mu-card style="width: 100%; max-width: 1000px; margin: 0 auto; margin-bottom: 40% ;" >
      <mu-card-actions  >
        <mu-button color="error" v-for="(item, index) in links"  v-on:click="play(item,index)"   :key="index" flat>{{index}}</mu-button>
      </mu-card-actions>
  <mu-card-title :title="movieName" ></mu-card-title>
  <mu-card-text>
        {{content}}
  </mu-card-text>

</mu-card>
</mu-container>
  </div>
</template>
<script>
// import VideoPlayer  from  './VideoPlayer.Vue'
import axios from  'axios'
import MyPlayer from './MyPlayer'

// var canvas = document.getElementById('canvas')
// console.log(canvas);
export default {
  data () {
      return {
        showTishi:true,
        movieName:null,
        content:null,
        links:[],
        playerOptions: {
          //  playbackRates: [0.7, 1.0, 1.5, 2.0], //播放速度
          autoplay: false, // 如果true,浏览器准备好时开始回放。
          muted: false, // 默认情况下将会消除任何音频。
          loop: false, // 导致视频一结束就重新开始。
          preload: 'auto', // 建议浏览器在<video>加载元素后是否应该开始下载视频数据。auto浏览器选择最佳行为,立即开始加载视频（如果浏览器支持）
          language: 'zh-CN',
          aspectRatio: '16:9', // 将播放器置于流畅模式，并在计算播放器的动态大小时使用该值。值应该代表一个比例 - 用冒号分隔的两个数字（例如"16:9"或"4:3"）
          fluid: true, // 当true时，Video.js player将拥有流体大小。换句话说，它将按比例缩放以适应其容器。
          sources: [
            {
              type: 'application/x-mpegURL',
              src:
                'https://www1.yuboyun.com/hls/2018/06/12/4aKz2NeV/playlist.m3u8' // 你的m3u8地址（必填）
            }
          ],
          poster: '', // 你的封面地址
          width: document.documentElement.clientWidth,
          notSupportedMessage: '此视频暂无法播放，请稍后再试', // 允许覆盖Video.js无法播放媒体源时显示的默认信息。
                 controlBar: {
                   timeDivider: true,
                   durationDisplay: true,
                   fullscreenToggle: true , //全屏按钮
                   remainingTimeDisplay: false
                 }
        }
      }
  },
  mounted() {
    this.getMovieLinks(this.$route.query.id)
  },
  methods: {
    canvass(){
      this.showTishi = false
      console.log(this.showTishi);
    },
    getMovieLinks(id) {
      axios.get('/movie/getMovieLinks/'+id).then((res)=>{
        var data = res.data.data
        console.log(data);
        this.movieName = data.movieName
        this.content = data.video_info.content
        this.links = data.video_list
        this.playerOptions.poster= data.video_info.bgimage
        this.playerOptions.sources[0].src= this.getObjFirst(data.video_list)
        this.$store.commit('changeHeadTitle',data.movieName)
      })
    },
    getObjFirst(obj){
      for(let i in obj) return obj[i];
    }
    ,
    play(item,index){
      console.log(item);
      this.playerOptions.autoplay= true
        this.playerOptions.sources[0].src = item
    },

  },  components: {
    MyPlayer
  }
}
</script>
<style >
  #MoviePlay{
    width: 100%;
  margin: 10% auto;
  }
    .xf{
      position: absolute;
  left: 30px;
  top: 20px;
  /* z-index:999999999999999999 */
  -webkit-transform: translateZ(0)
    }
</style>
