import axios from 'axios'

export default {
  namespaced: true,
  state: {
    isLoggedIn: false
  },
  getters: {
    loggedIn: state => {
      return state.loggedIn
    }
  },
  mutations: {
    setLoggedIn: (state, value) => {
      state.isLoggedIn = value
    }
  },
  actions: {
    LOGIN: ({ commit }, payload) => {
      return new Promise((resolve, reject) => {
        axios
          .post('Login.php', payload)
          .then(_ => {
            console.log('SUCCESS')
            commit('setLoggedIn', true)
            resolve(true)
          })
          .catch(error => {
            console.log('FAILURE')
            commit('setLoggedIn', false)
            reject(error)
          })
      })
    },
    SIGNUP: ({ commit }, payload) => {
      return new Promise((resolve, reject) => {
        axios
          .post('createUser.php', payload)
          .then(_ => {
            console.log('SUCCESS')
            commit('setLoggedIn', true)
            resolve(true)
          })
          .catch(error => {
            console.log('FAILURE')
            commit('setLoggedIn', false)
            reject(error)
          })
      })
    }
  }
}
