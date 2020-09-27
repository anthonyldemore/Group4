<template>
<Signing>
    <div class="login">
      <form class="form-signin">
        <h5>Sign In</h5>
        <div class="form-group">
          <div class= "username">
        <label id="username">Username</label>
        </div>
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
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group
          :state="userNameState"
          label="User Name"
          label-for="user-input"
          invalid-feedback="Username is required"
        >
          <b-form-input
            id="username-input"
            v-model="username"
            :state="userNameState"
            required
          >
          </b-form-input>
        </b-form-group>
        <b-form-group
          :state="passwordState"
          label="Password"
          label-for="password-input"
          invalid-feedback="Password is required"
        >
          <b-form-input
            id="password-input"
            v-model="password"
            :state="passwordState"
            v-on:keyup.enter="login"
            required
          >
          </b-form-input>
        </b-form-group>
      </form>
        <button type="submit" @click.prevent.stop="login()" class="btn btn-dark btn-lg btn-block">Sign In</button>
        <b-alert variant="danger" v-if="fail" :show="fail" fade @dimssed="fail=false" dismissible>
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
    </div>
    </Signing>
</template>

<style>
body.modal-open {
  height: 100vh;
  overflow: hidden;
}
</style>

<script>
import Signing from '../layouts/Signing.vue'
// TODO: Manage user ID from login response in state
// Anytime I make a call to the api, I need to include the
// userID from state.
import Sigining from '../layouts/Signing.vue'
export default {
  name: 'login',
  components: {
    Signing
  },
  data () {
    return {
      userId: 0,
      username: '',
      password: '',
      userNameState: null,
      passwordState: null,
      fail: false,
      pass: false,
      dismissSecs: 5,
      dismissCountDown: 0,
      showDismissibleAlert: false
    }
  },
  methods: {
    login () {
      if (!this.fail || !this.username || !this.password) {
        this.$store.dispatch('user/LOGIN', {
          username: this.username,
          password: this.password
        })
          .then(response => {
            this.$router.push('/contacts')
          })
          .catch((error) => {
            if (error) console.log('Login catch errors: ' + error)
            this.fail = true
          })
      }
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
