// src/store/index.js
import { createStore } from 'vuex';

export default createStore({
  state: {
    user: null, // Ensure this matches the structure you expect
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
  },
  actions: {
    // Define your actions to commit mutations and fetch user data, if needed
    setUser({ commit }, user) {
      commit('setUser', user);
    }
  },
  getters: {
    user: (state) => state.user,
  },
});
