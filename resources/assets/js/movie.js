
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import theme from 'muse-ui/lib/theme';
theme.use('dark');
import Vue from 'vue'
import VueRouter from 'vue-router'
import MuseUI from 'muse-ui';
import 'muse-ui/dist/muse-ui.css';
import Movielist  from  './components/MovieList.vue'
import MoviePlay  from  './components/MoviePlay.vue'
import VueVideoPlayer from 'vue-video-player'
 import 'videojs-contrib-hls';
 require('video.js/dist/video-js.css')
require('vue-video-player/src/custom-theme.css')

import Vuex from 'vuex'
Vue.use(Vuex)
const store = new Vuex.Store({
  state:{
    demo:'demosss',
    headTitle:'飞鸟'
  },
   mutations: {
      changeHeadTitle(state,newheadTitle) {
    // 变更状态
      state.headTitle = newheadTitle
    }
  }
})

Vue.use(VueVideoPlayer)
Vue.use(MuseUI);
Vue.use(VueRouter);
// 3. 创建 router 实例，然后传 `routes` 配置
// 你还可以传别的配置参数, 不过先这么简单着吧。
const router = new VueRouter({
  // mode:'history',
  routes: [
    { path: '/movieList',
      name: 'movieList',
      component: Movielist
     },
    { path: '/play',
      name: 'play',
     component: MoviePlay }
]
 // (缩写) 相当于 routes: routes,
})

Vue.component('movie', require('./components/Movie.vue'));
const app = new Vue({
    router,
    store,
    el: '#app'
});
