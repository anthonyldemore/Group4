import axios from 'axios'

export default {
  namespaced: true,
  state: {
    user_log_id: 0, // If ID is zero they are not logged in. The state will always be zero if they are not logged in
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
              onsole.log('Before assigning users ID: ' + user_log_id)
              user_log_id == respone.data.results.id
              console.log('Aftering assigning users ID: ' + user_log_id)
              resolve(true)
            }
          })
          .catch(error => {
            console.log('FAILURE' + response.results.id)
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
