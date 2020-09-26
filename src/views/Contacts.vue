<template>
  <Header>
    <div>
      <h1>Contacts Under Construction</h1>
        <b-table-simple class="panel-body table-responsive table-bordered table-striped">
        <b-tbody class="panel-body">
          <b-thead>
            <b-tr>
              <b-th>User ID</b-th>
              <b-th>Contact Name</b-th>
              <b-th>Email</b-th>
              <b-th>Edit</b-th>
              <b-th>Delete</b-th>
            </b-tr>
            <b-tr v-for="contact in contacts" v-bind="contacts" :key="contact">
              <b-td> {{contact.name}} </b-td>
              <b-td> {{contact.email}} </b-td>
              <b-td> {{contact.position}} </b-td>
              <b-td><b-button size="sm" name="edit" @click="fetchContacts(row.userId)">Edit</b-button></b-td>
              <b-td><b-button size="sm" class="delete" @click="deleteData(row.userId)">Delete</b-button></b-td>
            </b-tr>
          </b-thead>
        </b-tbody>
        </b-table-simple>
        <!-- <b-table
        show-empty
        small
        striped hover
        :items="data"
        :fields="fields"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        sort-icon-left
        responsive="sm"
        >
          <template v-for="contact in contancts">
            <template v-slot:cell[gomycell(key)]="row" >
            {{ row.contact.contactName }} {{ row.contact.email }} {{ row.contact.positions }}
            </template>
            <template v-slot:cell(actions)>
              <b-button size="sm" class="mr-1 edit" v-b-modal.modal-prevent-closing-edit>Edit</b-button>
              <b-button size="sm" class="mr-1 delete" @click="deleteData" ok-title="Delete Contact">Delete</b-button>
            </template>
          </template>
      </b-table> -->
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
      userId: 0,
      contactName: '',
      email: '',
      position: '',
      nameState: null,
      emailState: null,
      positionState: null,
      // contacts: [],
      errors: [],
      sortBy: 'name',
      sortDesc: false,
      actionButton: 'Insert',
      fields: [
        { key: 'userId', label: 'ID', sortable: true },
        { key: 'name', label: 'Full name', sortable: true },
        { key: 'email', label: 'Email', sortable: true },
        { key: 'position', label: 'Position', sortable: true },
        { key: 'actions', label: 'Actions' }
      ],
      contacts: [
        { contactName: '', email: '', position: '' }
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
    fetchContacts () { // fetch data and populate the contacts table
      axios
        .post('Search.php')
        .then(response => {
          console.log('Fetching contacts from database')
          this.contacts = response.data
        })
        .catch((error) => {
          if (error) console.log('Error fetching contacts' + error)
          this.errors.push(error)
        })
    },
    submitData () {
      if (this.actionButton === 'Insert') {
        console.log('Inserting contact')
        axios
          .post('addContact.php', {
            userId: this.userId++,
            contactName: this.contactName,
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
          })
      }
      if (this.actionButton === 'Update') {
        axios
          .post('Search.php', {
            userId: this.userId,
            contactName: this.contactName,
            email: this.email,
            position: this.position
          })
          .then(response => {
            console.log('Successful updating a contact' + response)
            this.fetchContacts()
            this.resetModal()
          })
          .catch((error) => {
            if (error) console.log('Error when adding' + error)
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
              console.log('Successful delete')
            })
            .catch((error) => {
              if (error) console.log('Error when deleting' + error)
              this.error = true
            })
        }
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
      this.contactName = ''
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
      this.openEditModal()
      axios
        .post('Search', {
          userId: this.userId
        })
        .then((response) => {
          this.contactName = response.data.contactName
          this.email = response.data.email
          this.position = response.data.position
        })

        .catch(error => {
          if (error) console.log('Error searching for contact')
          this.error.push(error)
        })
    }
  }
}
</script>
