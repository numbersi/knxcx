<template>
    <div >
      <mu-load-more @refresh="refresh" :refreshing="refreshing" :loading="loading" @load="load">
        <mu-grid-list class="gridlist-demo"  >
        <mu-grid-tile v-for="item in movieList"  :key="item.id">
        <img :src="item.video_info.bgimage">
        <span slot="title">{{item.movieName}}</span>
        <span slot="subTitle">{{item.video_info.content}}</span>
        <mu-button slot="action" icon v-on:click="play(item.id)">
        <mu-icon value="play_circle_filled" size="56" ></mu-icon>
        </mu-button>
        </mu-grid-tile>
        </mu-grid-list>
      </mu-load-more>
    </div>
</template>
<script>
    import axios from  'axios'
    export default {
        data() {
            return {
                movieList:[],
                num: 10,
                refreshing: false,
                loading: false,
                text: 'List',
                next_page_url:''
            }
        },
        mounted: function () {
          this.getList()
          this.$store.commit('changeHeadTitle', 'sd')
        },
        methods: {
          getList() {
            axios.get('/movie/movieList').then((res)=>{
              this.movieList = res.data.data,
              this.next_page_url =res.data.next_page_url
            })
          },
          play(id){
            this.$router.push({path:'play',query:{id:id}});
          },
          refresh () {
            console.log('refresh');
            this.refreshing = true;
            this.$refs.container.scrollTop = 0;
            setTimeout(() => {
              this.refreshing = false;
              this.text = this.text === 'List' ? 'Menu' : 'List';
              this.num = 10;
            }, 2000)
          },
          load () {
            console.log('load');

            this.loading = true;
            axios.get(this.next_page_url).then((res)=>{
              this.movieList= this.movieList.concat(res.data.data)
              this.next_page_url =res.data.next_page_url
              this.loading = false;
            })

          }
                }
    }
</script>
