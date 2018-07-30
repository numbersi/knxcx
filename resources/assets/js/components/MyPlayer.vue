<template>
 <div class="container">
 <div class="player">
  <video-player class="video-player vjs-custom-skin"
      ref="videoPlayer"
      :playsinline="true"
      :options="options"
      @play="onPlayerPlay($event)"
      @loadeddata="onPlayerLoadeddata($event)"
      @loadstart ="onPlayerPlay($event)"
  >
  </video-player>
 </div>
 </div>
</template>

<script>
// import  { Toast } from 'muse-ui';

import { videoPlayer } from 'vue-video-player'
export default {
  data () {
    return {
      alert: true
    }
  },
  mounted() {
    //do something after mounting vue instance

},
  components: {
    videoPlayer
  },
  methods: {
    onPlayerPlay (player) {
      console.log('loadstart````````````````````````````````');
  var ctx = document.getElementById("canvas").getContext("2d");
  console.log(ctx);

  ctx.font = "italic 35px 黑体";
  ctx.fillStyle = "Red";
  ctx.fillText("绘制填充文字",30,60,200);
  ctx.font = "bold 35px 宋体";
  ctx.fillStyle = "blue";
  ctx.fillText("绘制填充文字",30,100);
  ctx.font = "25px 隶书";
  ctx.fillStyle = "Green";
  ctx.fillText("绘制填充文字",30,130);
    },
    onPlayerPause(player) {
      console.log('player pause!', player)
    },
    onPlayerLoadeddata(player) {
      console.log('player Loadeddata!', player)
    },
    showAlert () {
      this.alert = true;
    },
    closeAlert () {
      this.alert = false;
    }
    // onPlayerWaiting(player) {
    //   // console.log('player Waiting!', player)
    // },
    // onPlayerPlaying(player) {
    //   // console.log('player Playing!', player)
    // },
    // onPlayerTimeupdate(player) {
    //   // console.log('player Timeupdate!', player.currentTime())
    // },
    // onPlayerCanplay(player) {
    //   // console.log('player Canplay!', player)
    // },
    // onPlayerCanplaythrough(player) {
    //   // console.log('player Canplaythrough!', player)
    // },
    // // or listen state event
    // playerStateChanged(playerCurrentState) {
    //   // console.log('player current update state', playerCurrentState)
    // },
    // // player is ready
    // playerReadied(player) {
    //   // seek to 10s
    //   // console.log('example player 1 readied', player)
    //   // player.currentTime(10)
    //   // console.log('example 01: the player is readied', player)
    // }
  },
  computed: {
    player () {
      return this.$refs.videoPlayer.player
    }
  },
  props: {
    options: Object,
  }
}
</script>
