<template>
<div style="width=100%;">
      <!-- <div class="container">
        <div style="width: 100%; background: #fff; padding: 8px;">
    <mu-flex class="flex-wrapper" align-items="center">
      <mu-flex class="flex-demo" justify-content="center" fill> <router-link :to="{ name: 'movieList'}"><mu-button color="primary">美剧</mu-button></router-link></mu-flex>
      <mu-flex class="flex-demo" justify-content="center" fill>  <mu-button color="secondary">Secondary</mu-button></mu-flex>
      <mu-flex class="flex-demo" justify-content="center" fill>  <mu-button color="success">Success</mu-button></mu-flex>
      <mu-flex class="flex-demo" justify-content="center" fill>     <mu-button color="info"> <mu-icon value="search" left></mu-icon>搜索</mu-button></mu-flex>

    </mu-flex>

  </div> -->
<mu-appbar style="width: 100%;" color="primary">
  <mu-button icon slot="left">
    <mu-icon value="menu"></mu-icon>
  </mu-button>
  {{$store.state.headTitle}}
  <mu-menu slot="right">
    <mu-button flat>MENU</mu-button>
    <mu-list slot="content">
      <mu-list-item button>
        <mu-list-item-content>
          <mu-list-item-title>Menu Item 1</mu-list-item-title>
        </mu-list-item-content>
      </mu-list-item>
      <mu-list-item button>
        <mu-list-item-content>
          <mu-list-item-title>Menu Item 2</mu-list-item-title>
        </mu-list-item-content>
      </mu-list-item>
    </mu-list>
  </mu-menu>
</mu-appbar>
        <!-- <mu-container>

        </mu-container> -->
        <router-view id='router_view'></router-view>
        <mu-alert color="error">
          <mu-icon left value="warning"></mu-icon> this is error alert
        </mu-alert>
        <div id='footer'>
            <mu-bottom-nav :value.sync="shift">
              <mu-bottom-nav-item  to="/movieList" title="书架" value="书架" icon="person_outline"></mu-bottom-nav-item>
              <mu-bottom-nav-item to="/myBooks" title="今日推荐" value="今日推荐" icon="restore"></mu-bottom-nav-item>
              <mu-bottom-nav-item to="/category" title="搜索" value="分类" icon="sort"></mu-bottom-nav-item>
              <mu-bottom-nav-item to="/rank" title="排行榜" value="排行榜" icon="receipt"></mu-bottom-nav-item>
            </mu-bottom-nav>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
          return{
              shift: '书架',
        }
        },
        mounted: function () {
            console.log('sa')
        },
    }
</script>
<style>
/* @import url("//unpkg.com/muse-ui@3.0.0-rc.3/dist/muse-ui.css"); */
    .demo-text {
        padding: 16px;
        background: #fff;
    }

    .demo-text p {
        margin: 8px 0;
    }
#router_view{
  margin-bottom: 4%
}
#footer {

    bottom: 0;
    width: 100%;
    height: 60px;/*脚部的高度*/
    background: #6cf;
    clear:both;
    position:fixed;
}
</style>
