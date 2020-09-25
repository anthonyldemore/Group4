<template>
  <Header>
    <div>
      <h1>Contacts Under Construction</h1>
      <b-table striped hover :items="items" :fields="fields" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" sort-icon-left responsive="sm">
        <thead>
        </thead>
        <tbody>
          <tr v-for="contact in contacts" v-bind="contacts" :key="contact">
            <td> {{contacts.name}} </td>
            <td> {{contacts.email}} </td>
            <td> {{contacts.position}} </td>
          </tr>
        </tbody>
      </b-table>
      <div>
      Sorting By: <b>{{ sortBy }}</b>, Sort Direction:
      <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b>
    </div>
    <b-button v-b-modal.modal-prevent-closing-add>Add Contact</b-button>
    <b-modal
      id="modal-prevent-closing-add"
      ref="modal"
      title="Add Contact"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk, submitData"
      ok-title="Add Contact"
    >
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group
          :state="nameState"
          label="Name"
          label-for="name-input"
          invalid-feedback="Name is required"
        >
          <b-form-input
            id="name-input"
            v-model="name"
            :state="nameState"
            required
          >
          </b-form-input>
        </b-form-group>
        <b-form-group
          :state="emailState"
          label="Email"
          label-for="email-input"
          invalid-feedback="Email is required"
        >
          <b-form-input
            id="email-input"
            v-model="email"
            :state="emailState"
            required
          >
          </b-form-input>
        </b-form-group>
        <b-form-group
          :state="positionState"
          label="Position"
          label-for="position-input"
          invalid-feedback="Position is required"
        >
          <b-form-input
            id="position-input"
            v-model="position"
            :state="positionState"
            required
          >
          </b-form-input>
        </b-form-group>
      </form>
    </b-modal>
    <b-button v-b-modal.modal-prevent-closing-delete>Delete Contact</b-button>
    <b-button @click.prevent="logout()">Logout</b-button>

    </div>
  </Header>
</template>

<script>
import Header from '../layouts/Header'
import axios from 'axios'
export default {
  name: 'contacts',
  components: {
    Header
  },
  data () {
    return {
      name: '',
      email: '',
      position: '',
      nameState: null,
      emailState: null,
      positionState: null,
      contacts: [],
      errors: [],
      sortBy: 'name',
      sortDesc: false,
      actionButton: 'Insert',
      fields: [
        { key: 'name', sortable: true },
        { key: 'email', sortable: true },
        { key: 'position', sortable: true }
      ],
      items: [
        { name: 'Juan S Rodriguez', email: 'juansrodz@gmail.com', position: 'Programmer' },
        { name: 'Juan S Rodriguez', email: 'juansrodz@gmail.com', position: 'Programmer' }
      ]
    }
  },
  created () {
    this.fetchContacts()
  },
  methods: {
    logout () {
      this.$store.commit('user/setLoggedIn', false)
      this.$router.push('/login')
    },
    // fetch data and populate the contacts table
    fetchContacts () {
      axios
        .get('Search.php')
        .then(response => {
          this.contacts = response.data
        })
        .catch((error) => {
          if (error) console.log(error)
          this.errors.push(error)
        })
    },
    submitData () {
      if (this.actionButton === 'Insert') {
        console.log('Inserting contact')
        axios
          .post('addContact.php', {
            name: this.name,
            email: this.email,
            position: this.position
          })
          .then(response => {
            console.log('Successfully added a contact ' + response)
            this.resetModal()
            this.fetchContacts()
          })
          .catch((error) => {
            if (error) console.log('Error when adding' + error)
            this.error = true
          })
      }
    },
    checkFormValidity () {
      const valid = this.$refs.form.checkValidity()
      this.nameState = valid
      this.emailState = valid
      this.positionState = valid
      return valid
    },
    resetModal () {
      this.name = ''
      this.nameState = null
      this.email = ''
      this.emailState = null
      this.position = ''
      this.positionState = null
    },
    handleOk (bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault()
      // Trigger submit handler
      this.handleSubmit()
    },
    handleSubmit () {
      // Exit when the form isn't valid
      if (!this.checkFormValidity()) {
        return
      }
      // TODO: add contact function here
      // this.contacts.push(this.name, this.email, this.position)
      this.$nextTick(() => {
        this.$bvModal.hide('modal-prevent-closing-add')
      })
    }
  }
}
</script>
