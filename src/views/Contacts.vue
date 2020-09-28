<template>
  <Header>
    <div>
      <h1>Contacts Under Construction</h1>
        <b-input-group class="mt-3">
          <b-form-input v-model="searchTerm"></b-form-input>
            <b-input-group-append >
              <b-button @click="search()" variant="info">Search</b-button>
            </b-input-group-append>
          </b-input-group>
        </div>
       
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
          <template> </template>
          <template v-slot:cell(actions)="row">
              <b-button size="sm" class="mr-1 edit" @click="startEdit(row)" v-b-modal.modal-prevent-closing-edit>Edit</b-button>
              <b-button size="sm" class="mr-1 delete"  @click="deleteData(row)" ok-title="Delete Contact">Delete</b-button>
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
      searchTerm: '',
      editId: 0,
      userId: 0,
      ID: 0,
      tableNum: 0,
      contactName: '',
      companyName: '',
      address: '',
      email: '',
      phone: '',
      nameState: null,
      emailState: null,
      companyNameState: null,
      sortBy: 'Name',
      sortDesc: false,
      actionButton: 'Insert',
      fields: [
        { key: 'ID', label: 'Contact ID', sortable: true },
        { key: 'ContactName', label: 'Contact Name', sortable: true },
        { key: 'CompanyName', label: 'Company Name', sortable: true },
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
    this.fetchContacts()
  },
  methods: {
    fetchContacts () { // fetch data and populate the contacts table
      var postData = {
        userId: this.$store.getters["user/user_log_id"],
        search: ''
      }
      axios
        .post('/api/Search.php', postData)
        .then(response => {
          console.log('Fetching contacts from ' + response.data + response.data.results)
          if ('error' in response.data) {
            console.log('A 200 Status Error Occured... This error could also be due to an empty results array')
          } else {
            this.items = response.data.results
            console.log('Successfully fetching contacts ' + this.items.values)
          }
        })
        .catch((error) => {
          if (error) console.log('Error fetching contacts ' + error)
          this.errors.push(error)
        })
    },
    submitData () {
      var postData = {
        userId: this.$store.getters["user/user_log_id"],
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
            if (response.data.results) {
              console.log('Successfully added a contact ' + response.data.results)
              this.items = response.data.results
              this.resetModal()
              this.fetchContacts()
            }
            else if ('error' in response.data) {
              console.log('A 200 Status Error Occured' + response.data.error)
            } 
          })
          .catch((error) => {
            if (error) console.log('Error when adding ' + error)
          })
      }
    },
    // TODO: When clicking on delete I need to know which contact ID I am deleting 
    // That need to get passed as a parameter
    // Change the entire built in logic for the post requests
    editData () {
      
      var postData = {
        ID: this.editId,
        CompanyName: this.companyName,
        ContactName:this.contactName,
        Email: this.email ,
        Phone: '',
        Address: ''
      }

      if (this.actionButton === 'Update') {
        // postData['contactId'] = row.contactId
        console.log('Editing Contact')
        axios
          .post('/api/updateContact', postData)
          .then(response => {
            if (response.data.results) { 
              console.log('Successful delete ' + response.data.results)
              this.items = response.data.results
              this.fetchContacts()
              this.resetModal()
            }
            else if ('error' in response.data) console.log('A 200 Status Error Occured' + response.data.error) 
          })
          .catch((error) => {
            if (error) console.log('Error when adding ' + error)
          })
      }
    },
    // TODO: When clicking on delete I need to know which contact ID I am deleting 
    // That need to get passed as a parameter
    // Change the entire built in logic for the post requests
    deleteData (row) {
      if (confirm('Are you sure you want to remove this contact?')) {
        // var postData['contactId'] = row.contactId   //< the row of the contactId I am trying to delete 
        var postData = { 
          idArr:[] 
        }
        postData.idArr.push(row.item.ID)       
        console.log('Deleting contact')
        axios
          .post('/api/Delete.php', postData)
          .then(response => {
            if (response.data.results) { 
              console.log('Successful delete ' + response.data.results)
              this.fetchContacts() 
            }
            else if ('error' in response.data) console.log('A 200 Status Error Occured' + response.data.error) 
          })
          .catch((error) => {
            if (error) console.log('Error when deleting ' + error)
          })
      }
    },
    checkFormValidity () {
      const valid = this.$refs.form.checkValidity()
      this.emailState = valid
      // return this.$refs.form.checkValidity()
      return valid
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
      this.$store.commit('user/setUserID', -1)
      this.$router.push('/login')
    },
    startEdit(row) {
      console.log(row)
      this.editId = row.item.ID
      this.contactName = row.item.ContactName
      this.email = row.item.Email  
      this.companyName = row.item.CompanyName 
    },
    search () { // fetch data and populate the contacts table
      var postData = {
        userId: this.$store.getters["user/user_log_id"],
        search: this.searchTerm
      }
      axios
        .post('/api/Search.php', postData)
        .then(response => {
          console.log('Fetching contacts from ' + response.data + response.data.results)
          if ('error' in response.data) {
            console.log('A 200 Status Error Occured... This error could also be due to an empty results array')
          } else {
            this.items = response.data.results
            console.log('Successfully fetching contacts ' + this.items.values)
          }
        })
        .catch((error) => {
          if (error) console.log('Error fetching contacts ' + error)
          this.errors.push(error)
        })
    }
  }
}
</script>