<template>
    <modal @before-open="beforeOpen" class="addcard" name="add-card" transition="pop-out" :width="modalWidth" :focus-trap="true" :height="400" :adaptive="true" :clickToClose="false"> 
      <div class="addcard__box">
        <h4 class="addcard__title"> {{ update ? 'UPDATE CARD' : 'ADD CARD'}}</h4>
        <form @submit.prevent="saveCard">
          <div class="form-group">
            <input v-model="form.title" type="text" class="form-control" placeholder="Card Title" />
            <span class="form-error" v-text="title[0]"></span>
          </div>
          <div class="form-group">
            <textarea v-model="form.description" class="form-control" cols="10" rows="5" placeholder="Card Description"></textarea>
            <span class="form-error" v-text="description[0]"></span>
          </div>
          <div class="form-group">
            <button class="button addcard__button addcard__button--hover" :disabled="loader">
              Save
              <img v-if="loader" src="../assets/loader.svg" class="loader" alt="loader" />
            </button>
          </div>
        </form>

        <div class="addcard__cancel">
          <span v-on:click="closeModal">Cancel</span>
        </div>
      </div>
    </modal>
</template>
<script>
const MODAL_WIDTH = 656

const initialData = () => ({
      update: false,
      modalWidth: MODAL_WIDTH,
      loader: false,
      title: [],
      description: [],
      card_id: '',
      form: {
        title: '',
        description: '',
        columns_id: ''
      }
  }
)
export default {
  name: 'AddCard',
  data() {
    return initialData();
  },
  created() {
    this.modalWidth =
      window.innerWidth < MODAL_WIDTH ? MODAL_WIDTH / 2 : MODAL_WIDTH
  },
  methods: {
    beforeOpen (event) {
      this.form.columns_id = event.params.columns_id;
      this.update = event.params.update;
      if (this.update) {
        this.card_id = event.params.card.id;
        Object.assign(this.form,  event.params.card);
      }
    },
    closeModal() {
      // reset state
      const data = initialData()
      Object.keys(data).forEach(k => this[k] = data[k])
      this.$modal.hide('add-card');
    },
    saveCard() {
      this.title = [];
      this.description = [];
      if (this.form.title && this.form.description) {
        this.loader = true;
        if (this.update) {
           this.$store.dispatch('updateCard', this.form).then(() => {          
            this.loader = false;
            const error = this.$store.getters.getError;
            this.title = error?.title || []; this.description = error?.description || [];
            if (this.title.length == 0 && this.description.length == 0) {
              this.form.title = '';
              this.form.description = '';
              this.closeModal();
            }
          });;
        } else { 
          this.$store.dispatch('addCard', this.form).then(() => {          
            this.loader = false;
            const error = this.$store.getters.getError;
            this.title = error?.title || []; this.description = error?.description || [];
            if (this.title.length == 0 && this.description.length == 0) {
              this.form.title = '';
              this.form.description = '';
              this.closeModal();
            }
          });
        }
        
      } else {
        this.title = (!this.form.title) ? ['Card title is required'] : [];
        this.description = (!this.form.description) ? ['Card description is required'] : [];
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  .addcard {
    &__cancel {
      text-align: center;
      text-decoration: underline;
      color: #ccc;
      cursor: pointer;
      margin: 15px auto;
    }
    &__box {
      padding: 20px;
    }
    &__title {
      text-align: center;
    }
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