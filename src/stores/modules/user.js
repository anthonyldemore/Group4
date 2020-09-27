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
      return state.loggedIn
    }
  },
  mutations: {
    setLoggedIn: (state, value) => {
      state.isLoggedIn = value
    },
    setUserId: (state, ID) => {
      state.user_log_id = ID
    }
  },
  actions: {
    LOGIN: ({ commit }, payload) => {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/Login.php', payload)
          .then((response) => { 
            if (!!response.data.results){
              commit('setLoggedIn', true),
              commit('setUserID', response.data.results.ID)
              resolve(true)
              console.log('SUCCESS' + response.body.results)
            } else if (!!response.body.error) {
              console.log('Error' + response.body.error)
            }
            else {
              console.log(response.body)
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
          .then((response) => { 
            if (!!response.data.results){
              commit('setLoggedIn', true),
              commit('setUserID', response.data.results.Id)
              resolve(true)
              console.log('SUCCESS' + response.body.results)
            } else if (!!response.body.error) {
              console.log('Error' + response.body.error)
            }
            else {
              console.log(response.body)
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
