<template>
  <Sigining>
    <div class="login">
      <form class="form-signin">
        <h3>Sign In</h3>
        <div class="form-group">
        <label>User Name</label>
        <input v-model="username" id="username, id" class="form-control form-control-lg" />
        </div>
        <div class="form-group">
        <label for="pwd">Password</label>
        <input v-model="password" type="password" id="pwd" name="pwd" class="form-control form-control-lg" />
        </div>
        <button type="submit" @click.prevent="login()" class="btn btn-dark btn-lg btn-block">Sign In</button>
        <b-alert variant="danger" v-if="error" :show="error" fade @dimssed="error=false" dismissible>
          The username or password are incorrect
        </b-alert>
        <b-alert variant="pass" v-if="pass" :show="pass" fade @dimssed="pass=false" dismissible>
          Succesful login
        </b-alert>
        <p class="forgot-password text-right">
          Don't have an account?
        <router-link :to="{name: 'signup'}">Sign up</router-link>
        <b-button @click.prevent="forceLoginState()">forceLoginState</b-button>
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
    id: 1,
    username: '',
    password: '',
    error: false,
    pass: false,
    dismissSecs: 5,
    dismissCountDown: 0,
    showDismissibleAlert: false
  }),
  methods: {
    login () {
      console.log(this.id)
      this.$store.dispatch('user/LOGIN', {
        id: this.id + 1,
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
    },
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
    forceLoginState () {
      this.$router.push('/contacts')
      this.$store.commit('user/setLoggedIn', true)
    }
  }
}
</script>
