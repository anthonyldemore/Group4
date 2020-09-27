import axios from 'axios'

export default {
  namespaced: true,
  state: {
    user_log_id: -1, // If ID is zero they are not logged in. The state will always be zero if they are not logged in
    // user_info: [],
    isLoggedIn: false
  },
  getters: {
    user_log_id: state => {
      return state.user_log_id
    },
    loggedIn: state => {
      return state.isLoggedIn
    }
  },
  mutations: {
    setLoggedIn: (state, value) => {
      state.isLoggedIn = value
    },
    setUserID: (state, ID) => {
      state.user_log_id = ID
    }
  },
  actions: {
    LOGIN: ({ commit }, payload) => {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/Login.php', payload)
          .then((response) => {
            if (response.data.results) {
              commit('setLoggedIn', true)
              commit('setUserID', response.data.results.ID)
              resolve(true)
              console.log('SUCCESS' + response.data.results)
              return
            } 
            if (response.data.error) console.log('Error' + response.data.error)
            else console.log(response.data)
            commit('setLoggedIn', false)
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
          .post('/api/createUser.php', payload)
          .then((response) => {
            if (response.data.results) {
              commit('setLoggedIn', true)
              commit('setUserID', response.data.results.ID)
              resolve(true)
              console.log('SUCCESS' + response.data.results)
              return
            } 
            if (response.data.error) console.log('Error' + response.data.error)
            else console.log(response.data)
            commit('setLoggedIn', false)
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