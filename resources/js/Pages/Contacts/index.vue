<script>
import axios from 'axios';

export default {
	data() {
		return {
            contacts : [],
			currentContact : {
                id : '',
                firstName : '',
                lastName : '',
                email : '',
                phone : '',
                birthday: '',
                addresses : [],
            },
            // for 'sortable' api
            contactTable: [
                {
                    title: 'First Name',
                    key: 'firstName',
                    sortable: true,
                },               {
                    title: 'Last Name',
                    key: 'lastName',
                    sortable: true,
                },                {
                    title: 'email',
                    key: 'email',
                    sortable: true,
                },                {
                    title: 'phone',
                    key: 'phone',
                    sortable: true,
                },                {
                    title: 'birthday',
                    key: 'birthday',
                    sortable: true,
                },
            ],

            ///////<--- Contact Create/Edit Modals --->///////
            formValidate: {
                id: '',
                firstName: '',
                lastName: '',
                email: '',
                phone: '',
                birthday: '',
            }, // may not need, just use currentContact?
            ruleValidate: {
                firstName: [
                    { required: true, message: 'The first name cannot be empty', trigger: 'blur' }
                ],
                lastName: [
                    { required: true, message: 'The last name cannot be empty', trigger: 'blur' }
                ],
                email: [
                    { required: true, message: 'Email cannot be empty', trigger: 'blur' },
                    { type: 'email', message: 'Incorrect email format', trigger: 'blur' }
                ],
                phone: [
                    { required: true, message: 'Please enter a phone number', trigger: 'change' }
                ],
                date: [
                    { required: true, type: 'date', message: 'Please select a birthday', trigger: 'change' }
                ],
            },
            modalContactAdd : false,
            modalContactEdit : false,
            modalContactDetails : false,
            ///////<--- Address Modals --->///////
            addresses : [],
            currentAddress: {
                id: '',
                number: '',
                street: '',
                city: '',
                state: '',
                zip: '',
                type: '',
                contact_id: '',
            },
            formValidateAddress: {
                id: '',
                number: '',
                street: '',
                city: '',
                state: '',
                zip: '',
                type: '',
                contact_id: '',
            },
            ruleValidateAddress: {
                number: [
                    { required: true, type: 'number', message: 'Please enter the house number', trigger: 'change' }
                ],
                street: [
                    { required: true, message: 'Please enter a street', trigger: 'change' }
                ],
                city: [
                    { required: true, message: 'Please enter a city', trigger: 'change' },
                ],
                state: [
                    { required: true, message: 'Please enter a state', trigger: 'change' }
                ],
                zip: [
                    { required: true, type: 'number', message: 'Please enter a zip code', trigger: 'change' }
                ],
                type: [
                    { required: true, message: 'Please select a type', trigger: 'change' }
                ],
            },
            modalAddressAdd : false,
            modalAddressEdit : false,
        }
    },

  mounted() {
    this.getContacts();
    this.initModals();
  },

methods: {
    initModals() {
        this.modalContactAdd = new bootstrap.Modal(document.getElementById('modalContactAdd'), {});
        this.modalContactEdit = new bootstrap.Modal(document.getElementById('modalContactEdit'), {});
        this.modalContactDetails = new bootstrap.Modal(document.getElementById('modalContactDetails'), {});
        this.modalAddressAdd = new bootstrap.Modal(document.getElementById('modalAddressAdd'), {});
        this.modalAddressEdit = new bootstrap.Modal(document.getElementById('modalAddressEdit'), {});
    },

////////////////////<--- Contact Functions --->////////////////////
    async getContacts() {
      try {
        const response = await axios.get('/api/contacts');
        this.contacts = response.data;
      } catch (err) {
        alert(err);
      }
    },
    btnCreateContact(){
        this.currentContact = {};
        this.modalContactAdd.show();
    },
    async btnEditContact(id) {
        try {
            const response = await axios.get(`/api/contacts/${id}`);
            this.currentContact = response.data;
            this.modalContactEdit.show();
        } catch (err) {
            alert(err);
        }
    },
    async btnDeleteContact(id) {
        if (confirm('Are you sure you want to delete this item?')) {
            try {
            await axios.delete(`/api/contacts/${id}`);
            this.getContacts();
            } catch (err) {
            alert(err);
            }
        }
    },
    async btnDetails(id) {
        try {
            const response = await axios.get(`/api/contacts/${id}`);
            this.currentContact = response.data;
            this.modalContactDetails.show();
        } catch (err) {
            alert(err);
        }
    },

    async modalAddSubmit() {
      try {
        const response = await axios.post(`/api/contacts`, this.currentContact);
        if (response.data.errors) {
          alert('All fields are required');
        } else {
          this.modalContactAdd.hide();
          this.getContacts();
        }
      } catch (err) {
        alert(err);
      }
    },
    // async createContact(formValidate) {
    //     if(this.currentContact.firstName.trim()=='') return this.e('First Name is required')
    //     if(this.currentContact.lastName.trim()=='') return this.e('Last Name is required')
    //     if(this.currentContact.email.trim()=='') return this.e('Email is required')
    //     if(this.currentContact.phone.trim()=='') return this.e('Phone is required')

    //     this.isCreatingContact = true
    //     const res = await this.callApi(
    //         'post',
    //         'app/createContact',
    //         this.currentContact)

    //     if(res.status===201){
    //         this.s('Contact has been edited successfully!')
    //         this.currentContact.firstName = ''
    //         this.currentContact.lastName = ''
    //         this.currentContact.email = ''
    //         this.currentContact.phone = ''
    //         this.currentContact.birthday = ''
    //         window.location.reload();
    //     } else {
    //         if(res.status==422) {
    //             if (this.res.errors.firstName){
    //                 this.i(res.formValidate.errors.firstName[0])
    //             }
    //             if (this.res.errors.lastName){
    //                 this.i(res.formValidate.errors.lastName[0])
    //             }
    //             if (this.res.errors.email){
    //                 this.i(res.formValidate.errors.email[0])
    //             }
    //             if (this.res.errors.phone){
    //                 this.i(res.formValidate.errors.phone[0])
    //             }
    //             if (this.res.errors.birthday){
    //                 this.i(res.formValidate.errors.birthday[0])
    //             }
    //         } else {
    //             this.swr()
    //         }
    //     }
    //     this.createContactModal = false
    //     this.isCreatingContact = false
    // },

    // async editContact(contact, index){

    //     if(this.formValidate.firstName.trim()=='') return this.e('First Name is required')
    //     if(this.formValidate.lastName.trim()=='') return this.e('Last Name is required')
    //     if(this.formValidate.email.trim()=='') return this.e('Email is required')
    //     if(this.formValidate.phone.trim()=='') return this.e('Phone is required')
    //     const res = await this.callApi('post', 'app/editContact', this.formValidate)
    //     if(res.status===200){
    //         this.s('Contact has been edited successfully!')
    //         this.formValidate.firstName = ''
    //         this.formValidate.lastName = ''
    //         this.formValidate.email = ''
    //         this.formValidate.phone = ''
    //         this.formValidate.birthday = ''
    //         this.editContactModal = false
    //         window.location.reload();
    //     } else {
    //         if(res.status==422) {
    //             if (this.res.errors.firstName){
    //                 this.i(res.formValidate.errors.firstName[0])
    //             }
    //             if (this.res.errors.lastName){
    //                 this.i(res.formValidate.errors.lastName[0])
    //             }
    //             if (this.res.errors.email){
    //                 this.i(res.formValidate.errors.email[0])
    //             }
    //             if (this.res.errors.phone){
    //                 this.i(res.formValidate.errors.phone[0])
    //             }
    //             if (this.res.errors.birthday){
    //                 this.i(res.formValidate.errors.birthday[0])
    //             }
    //             this.editContactModal = false;
    //         } else {
    //             this.swr()
    //             this.editContactModal = false;                }
    //     }
    // },

    async modalEditSubmit() {
      try {
        await axios.put(`/api/contacts/${this.currentContact.id}`, this.currentContact);
        this.modalContactEdit.hide();
        this.getContacts();
      } catch (err) {
        alert(err);
      }
    },
  },

////////////////////<--- Address Modals --->////////////////////

    btnCreateAddress(){
        this.currentAddress = {};
        this.modalAddressAdd.show();
    },
    async btnEditAddress(id) {
        try {
            const response = await axios.get(`/api/addreses/${id}`);
            this.currentAddress = response.data;
            this.modalEditAddress.show();
        } catch (err) {
            alert(err);
        }
    },
    async btnDeleteAddress(id) {
        if (confirm('Are you sure you want to delete this address?')) {
            try {
            await axios.delete(`/api/addresses/${id}`);
            this.btnDetails();
            } catch (err) {
            alert(err);
            }
        }
    },

    async modalAddAddressSubmit() {
      try {
        const response = await axios.post(`/api/addresses`, this.currentAddress);
        if (response.data.errors) {
          alert('All fields are required');
        } else {
          this.modalAddressAdd.hide();
          this.btnDetails();
        }
      } catch (err) {
        alert(err);
      }
    },
}
</script>

<template>
    <div>
       <div class="content">
			<div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <h1 class="mt-0 pt-0 pb-2">Contacts</h1>
                <hr class="mb-3">
                <Button type="success" @click="btnCreate()">New Contact</Button>
                <div class="_overflow _table_div">
                    <table class="_table" :columns="contactTable" >
                            <!-- TABLE TITLE -->
                        <tr>
                            <th >First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Birthday</th>
                            <th>Action</th>
                        </tr>
                            <!-- ITEMS -->
                        <tr v-for="contact in contacts" :key="contact.id">
                        <!-- v-if="contactss.length" -->
                            <td>{{contacts.firstName}}</td>
                            <td>{{contacts.lastName}}</td>
                            <td>{{contacts.email}}</td>
                            <td>{{contacts.phone}}</td>
                            <td>{{contacts.birthday}}</td>
                            <td>
                                <Button type="primary" size="small" @click="btnDetails(contact.id)">Details</Button>
                                <Button type="warning" size="small" @click="btnEditContact(contact.id)">Edit</Button>
                                <button type="button" class="btn btn-sm btn-secondary" @click="btnDeleteContact(contact.id)">Delete</button>
                            </td>
                        </tr>
                            <!-- ITEMS -->
                    </table>
                    <!-- <div class="card-footer">
                        <pagination :data="contacts" @pagination-change-page="created"></pagination>
                    </div> -->
				</div>

                <!-- Add Contact Modal -->
                <div id="modalAdd" class="modal" tabindex="-1">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Add Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">First</label>
                            <input v-model="currentContact.firstName" type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last</label>
                            <input v-model="currentContact.lastName" type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input v-model="currentContact.email" type="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input v-model="currentContact.phone" type="tel" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Birthday</label>
                            <input v-model="currentContact.birthday" type="text" class="form-control" required>
                        </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-primary" @click="modalAddSubmit()">Save Changes</button>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Edit Contact Modal -->
                <div id="modalEdit" class="modal" tabindex="-1">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Edit Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">First</label>
                            <input v-model="currentContact.firstName" type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last</label>
                            <input v-model="currentContact.lastName" type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input v-model="currentContact.email" type="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input v-model="currentContact.phone" type="tel" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Birthday</label>
                            <input v-model="currentContact.birthday" type="text" class="form-control" required>
                        </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-primary" @click="modalEditSubmit()">Save Changes</button>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Details Modal-->
                <div id="modalDetails" class="modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title">Contact Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            Name: {{ currentContact.firstName }} {{ currentContact.lastName }} <br>
                            Email: {{ currentContact.email }} <br>
                            Phone: {{ currentContact.phone }} <br>
                            Birthday: {{ currentContact.birthday }}
                            <div class="mt-2">
                                <strong>Addresses</strong>
                                <hr class="mb-2">
                                <Button type="success" @click="btnCreateAddress()">New Address</Button>
                                <table class="_table mt-3">
                                    <tr>
                                        <th>ID</th>
                                        <th>Numnber</th>
                                        <th>Street</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Zip</th>
                                        <th>Actions</th>
                                    </tr>
                                    <tr v-for="address in addresses" :key="address.id">
                                        <td>{{ address.id }}</td>
                                        <td>{{ address.number }}</td>
                                        <td>{{ address.street }}</td>
                                        <td>{{ address.city }}</td>
                                        <td>{{ address.state }}</td>
                                        <td>{{ address.zip }}</td>
                                        <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-sm btn-secondary" @click="btnEdit(address.id)">Edit</button>
                                            <button type="button" class="btn btn-sm btn-secondary" @click="btnDelete(address.id)">Delete</button>
                                        </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </div>
                </div>
<!--------------------------------------------- /Address Modals ----------------------------------------------->
                <!-- Add Address Modal -->
                <div id="modalAddressAdd" class="modal" tabindex="-1">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Number</label>
                                <input v-model="currentAddress.number" type="number" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Street</label>
                                <input v-model="currentAddress.street" type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">City</label>
                                <input v-model="currentAddress.city" type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">State</label>
                                <input v-model="currentAddress.state" type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Zip</label>
                                <input v-model="currentAddress.zip" type="number" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-sm btn-primary" @click="modalAddressAddSubmit()">Save Changes</button>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Edit Address Modal -->
                <div id="modalAddressEdit" class="modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title">Edit Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Number</label>
                                <input v-model="currentAddress.number" type="number" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Street</label>
                                <input v-model="currentAddress.street" type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">City</label>
                                <input v-model="currentAddress.city" type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">State</label>
                                <input v-model="currentAddress.state" type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Zip</label>
                                <input v-model="currentAddress.zip" type="number" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-sm btn-primary" @click="modalAddressEditSubmit()">Save Changes</button>
                        </div>
                    </div>
                    </div>
                </div>

			</div>
		</div>
    </div>
</template>

