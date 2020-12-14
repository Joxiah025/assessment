
<template>
  <div class="board">    
    <div class="board__row" v-for="item in columns" :key="item.id">
      <app-column :column="item" :columns="columns"></app-column>
    </div>
    <div class="board__row">
        <add-column></add-column>
    </div>
  </div>
</template>

<script>
import AddColumn from '../components/AddColumn.vue'
import Column from '../components/Column.vue'
import { mapState } from 'vuex'

export default {
  name: 'board',
  components: {
    'add-column': AddColumn,
    'app-column': Column,
  },
  mounted() {
    this.$store.dispatch('fetchColumns');
  },
  computed: mapState({
    columns: state => state.columns
  }), 
}
</script>

<style lang="scss" scoped>
  .board {
    margin-top: 80px;
    padding: 20px;
    display: inline-flex;
    justify-content: center;
    &__row {
      margin: 15px;
      overflow-x: auto;
      position: relative;
      width: 18rem;
      &__notification {
        margin: 0px auto;
        text-align: center;
        padding: 10px;
        margin-top: 150px;
      }
    }
  }
</style>

