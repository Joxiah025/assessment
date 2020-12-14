import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import { base_url } from '../utils/constants';

Vue.use(Vuex)
const store = new Vuex.Store({
    state () {
        return {
          columns: [],
          error: [String, Object]
        }
    },
    mutations: {
        addColumnsFromFetch (state, payload) {
            state.columns = payload;
        },
        addColumns (state, payload) {
            state.columns.push(payload);
        },
        clearColumns (state) {
            state.columns = []
        },
        removeColumn (state, payload) {
            const index = state.columns.findIndex(x => x == payload);
            state.columns.splice(index, 1);
        },
        addError (state, payload) {
            state.error = payload;
        },
        clearError (state) {
            state.error = null;
        },
        addCard (state, payload) {
            const column = state.columns.find(x => x.Id == payload.column_id);
            // column.cards.push(payload);
        }
    },
    actions: {
        async fetchColumns(context) {  
            context.commit('clearError')        
            await axios.get(base_url + 'columns').then(res => {
                context.commit('addColumnsFromFetch', res.data.data);
            })
            .catch(err => {
                context.commit('addError', err.response.data.message);
            })            
        },
        async addColumns(context, data) {
            if (context.getters.titleExist(data)) {
                context.commit('addError', 'Column title already exist');
            } else {
                context.commit('clearError');       
                await axios.post(base_url + 'columns', { title: data }).then(res => {
                    context.dispatch('fetchColumns')
                })
                .catch(err => {
                    context.commit('addError', err.response.data.data);
                }) 
            }        
        },
        async updateColumns(context, data) {
            context.commit('clearError');       
            await axios.put(base_url + 'columns', data).then(res => {
                context.dispatch('fetchColumns')
            })
            .catch(err => {
                context.commit('addError', err.response.data.message);
            })        
        },
        async removeColumn(context, data) {
            context.commit('clearError');       
            await axios.delete(base_url + `columns/${data}`).then(res => {
                context.dispatch('fetchColumns')
            })
            .catch(err => {
                context.commit('addError', err.response.data.data);
            })           
        },
        async addCard(context, data) {
            context.commit('clearError');
            await axios.post(base_url + 'card', data).then(() => {
                context.dispatch('fetchColumns')
            })
            .catch(err => {
                context.commit('addError', err.response.data.data);
            }) 
        },
        async updateCard(context, data) {
            context.commit('clearError');
            await axios.put(base_url + `card/${data.id}`, data).then(() => {
                context.dispatch('fetchColumns')
            })
            .catch(err => {
                context.commit('addError', err.response.data.data);
            }) 
        },
    },
    getters: {
        getColumns (state) {
            return state.columns;
        },
        getColumnCount (state) {
            return state.columns.length;
        },
        getError (state) {
            return state.error;
        },
        titleExist: (state) => (title) => {
            const exist = state.columns.find(x => x.title.toLowerCase() == title.toLowerCase());
            return exist != undefined
        }
    }
})

export default store