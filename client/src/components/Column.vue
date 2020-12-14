<template>
    <div class="column">
        <div class="column__header">
            <div class="column__header__title">
                {{column.title}}
            </div>
            <div class="column__header__options">
                <button class="column__header__options__button" v-on:click="addCard">
                    <img src="../assets/plus.svg" alt="plus" />
                </button>
                <button class="column__header__options__button" v-on:click="removeColumn">
                    <img src="../assets/trash.svg" alt="trash" />
                </button>
            </div>
        </div>
        <draggable v-model="column.cards" @change="movementLog()" group="columns" @start="drag=true" @end="drag=false" handle=".card__controls">
            <app-card v-for="item in column.cards" :key="item.id" :card="item"></app-card>
        </draggable>
        <v-dialog :clickToClose="false"/>
        <add-card/>
    </div>
</template>

<script>
    import Card from './Card.vue'
    import AddCard from './AddCard.vue'
    import draggable from 'vuedraggable'
    export default { 
        name: 'Column',
        props: {
            column: {
                type: Object,
                required: true
            },
            columns: {
                type: Array,
                required: true
            }
        },
        methods: { 
            addCard () {
                this.$modal.show('add-card', { columns_id: this.column.id, update: false });
            },
            removeColumn () {
                this.$modal.show('dialog', {
                title: 'You are about to delete a column',
                text: 'This action is will clear every card in this column and it is irreversible',
                buttons: [
                        {
                            title: 'Cancel',
                            handler: () => {
                                this.$modal.hide('dialog')
                            }
                        },
                        {
                            title: 'Continue',
                            handler: () => {
                                this.deleteColumn();
                            }
                        }
                    ]
                })
            },
            deleteColumn () {
                this.$store.dispatch('removeColumn', this.column.id).then(() => {
                    this.$modal.hide('dialog');
                });
            },
            movementLog () {
                this.$store.dispatch('updateColumns', this.columns)
            }
        },
        components: {
            'app-card': Card,
            'add-card': AddCard,
            draggable
        }
    }
</script>
<style lang="scss" scoped>
    .column {
        width: 100%;
        border-radius: 15px;
        background: #fff;
        color: #000;
        padding: 15px;
        min-height: 500px;
        &__header {
            display: flex;
            &__title {
                text-overflow: ellipsis;
                width: 60%;
            }
            &__options {
                width: 40%;
                display: flex;
                justify-content: flex-end;
                &__button {
                    width: auto;
                    outline: none;
                    border: none;
                    border-radius: .3rem;
                    background: none;
                    color: #000;
                    margin: 0.2rem;
                    cursor: pointer;
                    img {
                        width: 1rem;
                        height: 1rem;
                    }
                }                
            }
        }
    }
</style>