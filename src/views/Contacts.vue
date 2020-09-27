<template>
  <Header>
    <div>
      <h1>Contacts Under Construction</h1>
        <b-table
          show-empty
          small
          striped hover
          :items="items"
          :fields="fields"
          :sort-by.sync="sortBy"
          :sort-desc.sync="sortDesc"
          sort-icon-left
          responsive="sm"
        >
         <template v-slot:cell(actions)>
            <b-button size="sm" class="mr-1 edit" v-b-modal.modal-prevent-closing-edit>Edit</b-button>
            <b-button size="sm" class="mr-1 delete" @click="deleteData" ok-title="Delete Contact">Delete</b-button>
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
      @hidden="resetModal"
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
            v-model="contactName"
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
          :state="companyNameState"
          label="Company Name"
          label-for="companyName-input"
          invalid-feedback="companyName is required"
        >
          <b-form-input
            id="companyName-input"
            v-model="companyName"
            :state="companyNameState"
            required
          >
          </b-form-input>
        </b-form-group>
      </form>
    </b-modal>

    <b-modal
      id="modal-prevent-closing-edit"
      ref="modal"
      title="Edit Contact"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
      @click="submitData"
      ok-title="Confirm Edit"
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
            v-model="contactName"
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
          :state="companyNameState"
          label="Company Name"
          label-for="companyName-input"
          invalid-feedback="companyName is required"
        >
          <b-form-input
            id="companyName-input"
            v-model="companyName"
            :state="companyNameState"
            required
          >
          </b-form-input>
        </b-form-group>
      </form>
    </b-modal>
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
      userID: 0,
      contactName: '',
      companyName: '',
      address: '',
      email: '',
      phone: '',
      nameState: null,
      emailState: null,
      companyNameState: null,
      sortBy: 'name',
      sortDesc: false,
      actionButton: 'Insert',
      fields: [
        { key: 'ID', label: 'Contact ID', sortable: true },
        { key: 'ContactName', label: 'Contact Name', sortable: true },
        { key: 'CompanyName', label: 'CompanyName', sortable: true },
        { key: 'Address', label: 'Address', sortable: true },
        { key: 'Email', label: 'Email', sortable: true },
        { key: 'Phone', label: 'Phone', sortable: true },
        { key: 'actions', label: 'Actions' }
      ],
      items: [],
      errors: []
    }
  },
  created () {
    this.fetchContacts(1)
  },
  methods: {
    fetchContacts (userId) { // fetch data and populate the contacts table
      var postData = {
        userID: userId,
        search: ''
      }
      axios
        .post('/api/Search.php', postData)
        .then(response => {
          console.log('Fetching contacts from ' + response.json + response.data.results)
          if ('error' in response.data) {
            console.log('A 200 Status Error Occured... This error could also be due to an empty results array')
          } else {
            // store.state.user.user_info = response.data.result // Just added this line
            this.items = response.data.results
            console.log('Contacts ' + this.userId + this.items.values)
          }
        })
        .catch((error) => {
          if (error) console.log('Error fetching contacts ' + error)
          this.errors.push(error)
        })
    },
    submitData (contactNameInput) {
      var postData = {
        userID: this.userID,
        contactName: this.contactName,
        companyName: this.companyName,
        address: this.address,
        email: this.email,
        phone: this.phone
      }
      if (this.actionButton === 'Insert') {  // Just added from line 213 to 221
        console.log('Inserting contact ')
        axios
          .post('/api/addContact.php', postData)
          .then(response => {
            console.log('Fetching contacts from ' + response.json + response.data)
            if ('error' in response.data) {
              console.log('A 200 Status Error Occured')
            } else {
              console.log('Successfully added a contact ' + response.json + response.data)
              this.items = response.data.results
              this.resetModal()
              this.fetchContacts()
            }
          })
          .catch((error) => {
            if (error) console.log('Error when adding ' + error)
          })
      }
      if (this.actionButton === 'Update') {
        axios
          .post('Search.php', {
            userId: this.userId,
            contactName: this.contactName,
            email: this.email,
            companyName: this.companyName
          })
          .then(response => {
            console.log('Successful updating a contact ' + response)
            this.fetchContacts()
            this.resetModal()
          })
          .catch((error) => {
            if (error) console.log('Error when adding ' + error)
          })
      }
    },
    deleteData (userId) {
      if (confirm('Are you sure you want to remove this contact?')) {
        if (this.userId === userId) {
          axios
            .post('Delete.php', {
              userId: this.userId
            })
            .then(response => {
              this.fetchContacts()
              console.log('Successful delete ' + response.json + response.data)
              console.log('Successful delete')
            })
            .catch((error) => {
              if (error) console.log('Error when deleting ' + error)
              this.error = true
            })
        }
      }
    },
    checkFormValidity () {
      return this.$refs.form.checkValidity()
    },
    resetModal () {
      this.contactName = ''
      this.nameState = null
      this.email = ''
      this.emailState = null
      this.companyName = ''
      this.companyNameState = null
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
        this.submitData()
        this.$bvModal.hide('modal-prevent-closing-add')
        this.$bvModal.hide('modal-prevent-closing-edit')
      })
    },
    openEditModal () {
      this.$bvModal.show('modal-prevent-closing-edit')
    },
    gomycell (key) {
      return `cell(${key})`
    },
    findContact (userId) {
      console.log('Before function')
      this.openEditModal()
      axios
        .post('Search', {
          userId: this.userId
        })
        .then((response) => {
          console.log('Successful searching ' + response.json + response.data)
          this.contactName = response.data.contactName
          this.email = response.data.email
          this.companyName = response.data.companyName
        })
        .catch(error => {
          if (error) console.log('Error searching for contact')
          this.error.push(error)
        })
    },
    logout () {
      this.$store.commit('user/setLoggedIn', false)
      this.$router.push('/login')
    }
  }
}
</script>