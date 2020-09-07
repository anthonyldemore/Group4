<template>
  <Sigining>
    <div class="login">
      <form class="form-signin">
        <h3>Sign In</h3>

        <div class="form-group">
        <label>User Name</label>
        <input v-model="username" class="form-control form-control-lg" />
        </div>
        <div class="form-group">
        <label for="pwd">Password</label>
        <input v-model="password" type="password" id="pwd" name="pwd" class="form-control form-control-lg" />
        </div>
          <button type="submit" @click.prevent="login()" class="btn btn-dark btn-lg btn-block">Sign In</button>
        <b-alert
          color="error"
          :value="error"
          icon="close"
        >
          The username or password are incorrect
        </b-alert>
        <p class="forgot-password text-right">
          Don't have an account?
        <router-link :to="{name: 'signup'}">Sign up</router-link>
        <!-- <b-button @click.prevent="forceLoginState()">forceLoginState</b-button> -->
        </p>
      </form>
    </div>
  </Sigining>
</template>

<script>
import Sigining from '../layouts/Signing.vue'
export default {
  name: 'login',
  components: {
    Sigining
  },
  data: () => ({
    username: '',
    password: '',
    error: false
  }),
  methods: {
    login () {
      this.$store.dispatch('user/LOGIN', {
        username: this.username,
        password: this.password
      })
        .then(success => {
          this.$router.push('/contacts')
        })
        .catch((error) => {
          if (error) console.log(error)
          this.error = true
        })
    }
    // forceLoginState () {
    //   this.$router.push('/contacts')
    //   this.$store.commit('user/setLoggedIn', true)
    // }
  }
}
</script>
