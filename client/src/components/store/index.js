// src/store/index.js
import { createStore } from 'vuex';

export default createStore({
  state: {
    user: {
      name: null,
      email: null,
      userId:null
    },
    intendedRoute: null,
    // other state properties
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
    setIntendedRoute(state, route) {
      state.intendedRoute = route;
    },
    LOGOUT(state) {
      
      state.user = { name: null, email: null,userId:null }; // reset user to initial state
    },
  },
  actions: {
    setUser({ commit }, user) {
      commit('setUser', user);
    },
    logout({ commit }) {
      commit('LOGOUT');
      localStorage.removeItem('token'); // clear token
      localStorage.removeItem('user'); // clear user data
    },
    // other actions if needed
  },
  getters: {
    user: (state) => state.user,
    // other getters if needed
  },
});
