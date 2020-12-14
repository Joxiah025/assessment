<template>
    <div class="addcolumn">
        <h3>Add Column</h3>
        <form @submit.prevent="createColumn">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Column title" v-model="column" />
                <span class="form-error" v-text="error"></span>
            </div>
            <div class="form-group">
                <button type="submit" class="button addcolumn__button addcolumn__button--hover" :disabled="loader">
                    Save
                    <img v-if="loader" src="../assets/loader.svg" class="loader" alt="loader" />
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'AddColumn',
        data: () => {
            return {
                column: '',
                error: '',
                loader: false,
            }
        },
        methods: {
            createColumn() {
                this.error = '';
                if (this.column && this.column.trim()) {
                    this.loader = true;
                    this.$store.dispatch('addColumns', this.column).then(() => {                            
                            this.loader = false;
                            this.error = this.$store.getters.getError;
                            if (!this.error) {
                                this.column = '';
                            }
                        }
                    );
                } else {  
                    this.loader = false;                 
                    this.error = 'Column title is required.';
                }
            },
        }
    }
</script>

<style lang="scss" scoped>
    .addcolumn {
        text-align: center;
        width: 100%;
        border-radius: 15px;
        background: #fff;
        color: #000;
        padding: 80px 15px;
        min-height: 500px;
        &__button {
            --bg-opacity: 1;
            background: rgba(43,108,176,var(--bg-opacity));
            color: #fff;
            outline: none;
            width: 100%;
            &--hover {
                &:hover {
                    --bg-opacity: 0.5;
                    background: rgba(43,108,176,var(--bg-opacity));
                    outline: none;
                }
                &:focus {
                    outline: none;
                }
                &:disabled {
                    --bg-opacity: 0.5;
                    background: rgba(43,108,176,var(--bg-opacity));
                }
            }
        }
    }
</style>
