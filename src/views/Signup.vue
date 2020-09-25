<template>
  <Signing>
    <div class="login">
      <form>
        <h3>Sign Up</h3>
        <div class="form-group">
          <label>User Name</label>
          <input v-model="username" type="text" class="form-control form-control-lg"/>
        </div>
        <div class="form-group">
          <label>Full Name</label>
          <input v-model="name" type="text" class="form-control form-control-lg"/>
        </div>
        <div class="form-group">
          <label for="email">Email address</label>
          <input v-model="email" type="email" id="email" name="email" class="form-control form-control-lg" />
        </div>
        <div class="form-group">
          <label for="pwd">Password</label>
          <input v-model="password" type="password" id="pwd" name="pwd" class="form-control form-control-lg" />
        </div>
        <div class="form-group">
          <label for="cpwd">Confirm Password</label>
          <input v-model="confirmPassword" type="password" id="cpwd" name="cpwd" class="form-control form-control-lg" />
        </div>
         <b-alert variant="danger" :show="fail" fade @dimssed="fail=false" dismissible>
          The username or password are incorrect
        </b-alert>
        <b-alert variant="pass" :show="pass" fade @dimssed="pass=false" dismissible>
          Succesful Registration!
        </b-alert>
         <button type="submit" @click.prevent="signup(), fail, pass" class="btn btn-dark btn-lg btn-block">Sign Up</button>
        <p class="forgot-password text-right">
          Already registered
        <router-link :to="{name: 'login'}">sign in?</router-link>
        </p>
      </form>
    </div>
  </Signing>
</template>

<script>
import Signing from '../layouts/Signing.vue'
export default {
  name: 'signup',
  components: {
    Signing
  },
  data: () => ({
    username: '',
    name: '',
    email: '',
    password: '',
    confirmPassword: '',
    fail: false,
    pass: false
  }),
  methods: {
    signup () {
      if (this.password === this.confirmPassword) {
        this.$store.dispatch('user/SIGNUP', {
          username: this.username,
          name: this.name,
          email: this.email,
          password: this.password
        })
          .then(success => {
            this.$router.push('/contacts')
          })
          .catch((error) => {
            if (error) console.log(error)
            this.fail = true
            console.log('Here!!! ' + error)
          })
      } else { this.fail = true }
    }
  }
}
</script>
