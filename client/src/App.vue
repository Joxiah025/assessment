<template>
  <div class="app">
    <nav class="app__nav">
      <div class="app__nav__logo">
        <img class="app__nav__logo__image" alt="Vue logo" src="./assets/logo.png" />
      </div>
    </nav>
    <router-view/>
    <div class="app__export" v-on:click="exportSql">
      <img src="./assets/export.svg" alt="export"/>
    </div>
  </div> 
</template>
<script>
import axios from 'axios';
import { base_url } from './utils/constants';
export default {
  methods: {
    exportSql() {
      axios.get(base_url + 'dump').then(() => {
        window.location = base_url + 'download';
      });
    }
  }
}
</script>
<style lang="scss">
@import "assets/style.scss";

.app {
  overflow-x: auto;
  min-width: 100%;
  position: relative;
  &__export {
    text-align: center;
    position: fixed;
    bottom: 50px;
    right: 50px;
    background: #fff;
    width: 70px;
    height: 70px;
    border-radius: 50%;  
    display: flex;
    justify-content: center;
    cursor: pointer;
    img {
      display:table-cell; 
      vertical-align:middle; 
      text-align:center
    }  
  }
  &__nav {  
    z-index: 1000;
    position: fixed;  
    background-color: #fff;
    background-color: rgba(255,255,255,var(--bg-opacity));
    padding: 15px;
    display: flex;
    justify-content: center;
    border-bottom-width: 1px;
    border-color: #e2e8f0;
    border-color: rgba(226,232,240,var(--border-opacity));
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 1px 1px 1px 1px #ccc;
    &__logo {
      &__image {
        width: 2rem;
        height: 2rem;
      }
    }
  }
}
</style>
