import axios from 'axios'

export default {
  namespaced: true,
  state: {
    contacts: [],
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
          .then(({ _, status }) => {
            if (status === 200) {
              console.log('SUCCESS')
              commit('setLoggedIn', true)
              resolve(true)
            }
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
          .then(({ _, status }) => {
            if (status === 200) {
              console.log('SUCCESS')
              commit('setLoggedIn', true)
              resolve(true)
            }
          })
          .catch(error => {
            console.log('FAILURE')
            commit('setLoggedIn', false)
            reject(error)
          })
      })
    },
    FETCHCONTACTS: ({ response }, payload) => {
      return new Promise((resolve, reject) => {
        axios
          .get('Search.php', payload)
          .then(({ _, status }) => {
            if (status === 200) {
              console.log('SUCCESS')
              this.contacts = response.data
              // commit('setLoggedIn', true)
              resolve(true)
            }
          })
          .catch(error => {
            console.log('FAILURE')
            // commit('setLoggedIn', false)
            reject(error)
          })
      })
    }
  }
}
