<template>
  <Sigining>
    <div class="login">
      <!-- <form class="form-signin">
        <h3>Sign In</h3>
        <div class="form-group">
        <label>User Name</label>
        <input
          v-model="username"
          id="username"
          class="form-control form-control-lg"
        >
        </div>
        <div class="form-group">
        <label for="pwd">Password</label>
        <input
          v-model="password"
          type="password"
          id="pwd"
          name="pwd"
          class="form-control form-control-lg"
          v-on:keyup.enter="login()"
        >
        </div>
        <button type="submit" @click.prevent="login()" class="btn btn-dark btn-lg btn-block">Sign In</button>
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
      </form> -->
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
        <b-button @click.prevent="forceLoginState()" :disabled="checkValidity">forceLoginState</b-button>
        </p>
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
    userNameState: null,
    passwordState: null,
    fail: false,
    pass: false,
    dismissSecs: 5,
    dismissCountDown: 0,
    showDismissibleAlert: false
  }),
  methods: {
    login () {
      if (!this.fail) {
        this.$store.dispatch('user/LOGIN', {
          username: this.username,
          password: this.password
        })
          .then(success => {
            console.log('Successful login' + success.json + success.data + this.username)
            this.$router.push('/contacts')
          })
          .catch((error) => {
            if (error) console.log(error)
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
    checkFormValidity () {
      const valid = this.$refs.form.checkValidity()
      this.nameState = valid
      this.emailState = valid
      return valid
    },
    forceLoginState () {
      this.$router.push('/contacts')
      this.$store.commit('user/setLoggedIn', true)
    }
  }
}
</script>
