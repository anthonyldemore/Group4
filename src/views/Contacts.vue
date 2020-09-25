<template>
  <Header>
    <div>
      <h1>Contacts Under Construction</h1>
        <!-- <b-table-simple>
        <b-tbody>
          <b-thead>
            <b-tr v-for="contact in contacts" v-bind="contacts" :key="contact">
              <b-td> {{contacts.name}} </b-td>
              <b-td> {{contacts.email}} </b-td>
              <b-td> {{contacts.position}} </b-td>
              <b-td><b-button size="sm" name="edit" class="edit" >Edit</b-button></b-td>
              <b-td><b-button size="sm" class="delete">Delete</b-button></b-td>
            </b-tr>
          </b-thead>
        </b-tbody>
        </b-table-simple> -->
        <b-table
        striped hover
        :items="items"
        :fields="fields"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        sort-icon-left
        responsive="sm"
        >
          <template v-slot:cell(items)="row">
           {{ row.contacts.name }} {{ row.contacts.email }} {{ row.contacts.positions }}
          </template>
          <template v-slot:cell(actions)>
            <b-button size="sm" class="mr-1 edit">Edit</b-button>
            <b-button size="sm" class="mr-1 delete">Delete</b-button>
          </template>
      </b-table>
      <div>
      Sorting By: <b>{{ sortBy }}</b>, Sort Direction:
      <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b>
    </div>
    <b-button size="sm" class="mr-1" v-b-modal.modal-prevent-closing-add>Add Contact</b-button>
    <b-modal
      id="modal-prevent-closing-add"
      ref="modal"
      title="Add Contact"
      @show="resetModal"
      @hidden="submitData"
      @ok="handleOk"
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
    <b-button size="sm" class="mr-1" v-b-modal.modal-prevent-closing-delete>Delete Contact</b-button>
    <b-button size="sm" @click.prevent="logout()">Logout</b-button>

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
        { key: 'name', label: 'Full name', sortable: true },
        { key: 'email', label: 'Email', sortable: true },
        { key: 'position', label: 'Position', sortable: true },
        { key: 'actions', label: 'Actions' }
      ],
      items: [
        { name: 'Juan S Rodriguez', email: 'juansrodz@gmail.com', position: 'Programmer' },
        { name: 'Albert', email: 'dddnsrodz@gmail.com', position: 'Arogrammer' },
        { name: 'Wayne', email: 'xxansrodz@gmail.com', position: 'Zrogrammer' }
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
      this.$nextTick(() => {
        this.$bvModal.hide('modal-prevent-closing-add')
      })
    }
  }
}
</script>
