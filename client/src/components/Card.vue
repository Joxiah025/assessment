<template>
    <div class="card">
        <div class="card__title" v-on:click="updateCard">{{card.title}}</div>
        <div class="card__controls">
            <img src="../assets/reorder.svg" alt="reorder_icon" />
        </div>
    </div>
</template>

<script lang="ts">
    export default { 
        name: 'Card',
        props: {
            card: {
                required: true
            }
        },
        methods: {
            updateCard() {
                this.$modal.show('add-card', {columns_id: this.card.columns_id, update: true, card: this.card})
            }
        }
    }
</script>
<style lang="scss" scoped>
    .card {
        display: flex;
        justify-content: space-between;
        margin: 1rem auto;
        box-shadow: 1px 1px 1px 1px #ccc;        
        border-radius: 4px;
        &__title {
            width: 80%;
            padding: 10px 8px;
            cursor: pointer;
        }
        &__controls {
            width: 20%;
            padding: 10px 8px;
            cursor: move;
            text-align: center;
            img {
                width: 14px;
                height: 14px;
            }
        }
    }
</style>