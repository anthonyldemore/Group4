<template>
  <Header>
    <div>
      <h3>Add Contact</h3>
      <b-button @click.prevent="logout()">Logout</b-button>
    </div>
  </Header>
</template>

<script>
import Header from '../layouts/Header'
export default {
  name: 'add',
  components: {
    Header
  },
  methods: {
    logout () {
      this.$store.commit('user/setLoggedIn', false)
      this.$router.push('/login')
    }
  }
}
</script>
