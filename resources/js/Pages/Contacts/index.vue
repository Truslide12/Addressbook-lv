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
            },
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
			editContactModal : false,
			index : -1,
			deleteItem: {},
            deletingIndex: -1,
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
            createAddressModal : false,
            editAddressModal : false,
            deleteAddressModal : false,
            deleteAddressItem : {},
            deletingAddressIndex: -1,
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

    async getContacts() {
        this.token = window.Laravel.csrfToken
        const res = await this.callApi('get', 'app/index',)
        if(res.status===200){
            this.contacts = res.data
        } else {
            this.swr(error)
        }
    },

    ////////////////////<--- Contact Modals --->////////////////////
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
        async createContact(formValidate) {
            if(this.currentContact.firstName.trim()=='') return this.e('First Name is required')
            if(this.currentContact.lastName.trim()=='') return this.e('Last Name is required')
            if(this.currentContact.email.trim()=='') return this.e('Email is required')
            if(this.currentContact.phone.trim()=='') return this.e('Phone is required')

            this.isCreatingContact = true
			const res = await this.callApi(
                'post',
                'app/createContact',
                this.currentContact)

			if(res.status===201){
				this.s('Contact has been edited successfully!')
				this.currentContact.firstName = ''
                this.currentContact.lastName = ''
                this.currentContact.email = ''
                this.currentContact.phone = ''
                this.currentContact.birthday = ''
                window.location.reload();
			} else {
				if(res.status==422) {
					if (this.res.errors.firstName){
						this.i(res.formValidate.errors.firstName[0])
                    }
                    if (this.res.errors.lastName){
						this.i(res.formValidate.errors.lastName[0])
                    }
                    if (this.res.errors.email){
						this.i(res.formValidate.errors.email[0])
                    }
                    if (this.res.errors.phone){
						this.i(res.formValidate.errors.phone[0])
                    }
                    if (this.res.errors.birthday){
						this.i(res.formValidate.errors.birthday[0])
					}
				} else {
					this.swr()
                }
            }
            this.createContactModal = false
            this.isCreatingContact = false
        },

        async editContact(contact, index){

            if(this.formValidate.firstName.trim()=='') return this.e('First Name is required')
            if(this.formValidate.lastName.trim()=='') return this.e('Last Name is required')
            if(this.formValidate.email.trim()=='') return this.e('Email is required')
            if(this.formValidate.phone.trim()=='') return this.e('Phone is required')
  			const res = await this.callApi('post', 'app/editContact', this.formValidate) //?id=' + contact.id
            // console.log(res)
			if(res.status===200){
                // this.contacts[this.index].firstName = this.formValidate.firstName
                // this.contacts[this.index].lastName = this.formValidate.lastName
                // this.contacts[this.index].email = this.formValidate.email
                // this.contacts[this.index].phone = this.formValidate.phone
                // this.contacts[this.index].birthday = this.formValidate.birthday
				this.s('Contact has been edited successfully!')
				this.formValidate.firstName = ''
                this.formValidate.lastName = ''
                this.formValidate.email = ''
                this.formValidate.phone = ''
                this.formValidate.birthday = ''
				this.editContactModal = false
                window.location.reload();
			} else {
				if(res.status==422) {
					if (this.res.errors.firstName){
						this.i(res.formValidate.errors.firstName[0])
                    }
                    if (this.res.errors.lastName){
						this.i(res.formValidate.errors.lastName[0])
                    }
                    if (this.res.errors.email){
						this.i(res.formValidate.errors.email[0])
                    }
                    if (this.res.errors.phone){
						this.i(res.formValidate.errors.phone[0])
                    }
                    if (this.res.errors.birthday){
						this.i(res.formValidate.errors.birthday[0])
					}
                    this.editContactModal = false;
                } else {
                    this.swr()
                    this.editContactModal = false;                }
            }
        },

        showDeleteContactModal(contact, i){
            // console.log(contact)
            this.currentContact = contact
            // console.log('delete method called')
			this.deletingIndex = i
            this.showDeletingContactModal = true
            // console.log(this.currentContact)
        },

        async deleteContact(){
            this.isDeleting = true
			const res = await this.callApi('post', 'app/deleteContact', this.currentContact)
			if(res.status===200){
				this.s('Tag has been deleted successfully!')
			}else{
				this.swr()
			}
			this.isDeleting = false
            this.showDeleteConactModal = false
            window.location.reload();
		},
////////////////////<--- Address Modals --->////////////////////
        btnCreateAddress(){
            this.currentContact = {};
            this.modalContactAdd.show();
        },
        async btnEditAddress(id) {
            try {
                const response = await axios.get(`/api/contacts/${id}`);
                this.currentContact = response.data;
                this.modalContactEdit.show();
            } catch (err) {
                alert(err);
            }
        },
        async btnDeleteAddress(id) {
            if (confirm('Are you sure you want to delete this item?')) {
                try {
                await axios.delete(`/api/contacts/${id}`);
                this.getContacts();
                } catch (err) {
                alert(err);
                }
            }
        },

        async createAddress(formValidateAddress) {
            if(this.AddressData.number.trim()=='') return this.e('Street Number is required')
            if(this.AddressData.street.trim()=='') return this.e('Street Name is required')
            if(this.AddressData.city.trim()=='') return this.e('City is required')
            if(this.AddressData.state.trim()=='') return this.e('State is required')
            if(this.AddressData.zip.trim()=='') return this.e('Zip code is required')
            if(this.AddressData.type.trim()=='') return this.e('Location Type is required')

            this.isCreatingAddress = true
			const res = await this.callApi(
                'post',
                'app/createAddress',
                this.AddressData)
            // console.log(res)
			if(res.status===201){
				this.s('Address has been created successfully!')
				this.AddressData.number = ''
                this.AddressData.street = ''
                this.AddressData.city = ''
                this.AddressData.state = ''
                this.AddressData.zip = ''
                this.AddressData.type = 'home'
                window.location.reload();
			} else {
				if(res.status==422) {
					if (this.res.errors.number){
						this.i(res.formValidateAddress.errors.number[0])
                    }
                    if (this.res.errors.street){
						this.i(res.formValidateAddress.errors.street[0])
                    }
                    if (this.res.errors.city){
						this.i(res.formValidateAddress.errors.city[0])
                    }
                    if (this.res.errors.state){
						this.i(res.formValidateAddress.errors.state[0])
                    }
                    if (this.res.errors.zip){
						this.i(res.formValidateAddress.errors.zip[0])
					}
				} else {
					this.swr()
                }
            }
            this.createAddressModal = false
            this.isCreatingAddress = false
        },

        async editAddress(){
            if(this.AddressData.number.trim()=='') return this.e('Street Number is required')
            if(this.AddressData.street.trim()=='') return this.e('Street Name is required')
            if(this.AddressData.city.trim()=='') return this.e('City is required')
            if(this.AddressData.state.trim()=='') return this.e('State is required')
            if(this.AddressData.zip.trim()=='') return this.e('Zip code is required')
            if(this.AddressData.type.trim()=='') return this.e('Location Type is required')

  			const res = await this.callApi('post', 'app/editAddress', this.formValidateAddress)
            // console.log(res)
			if(res.status===200){
				this.s('Address has been edited successfully!')
				this.formValidateAddress.number = ''
                this.formValidateAddress.street = ''
                this.formValidateAddress.city = ''
                this.formValidateAddress.state = ''
                this.formValidateAddress.zip = ''
				this.editAddressModal = false
                window.location.reload();
			} else {
				if(res.status==422) {
					if (this.res.errors.number){
						this.i(res.formValidateAddress.errors.number[0])
                    }
                    if (this.res.errors.street){
						this.i(res.formValidateAddress.errors.street[0])
                    }
                    if (this.res.errors.city){
						this.i(res.formValidateAddress.errors.city[0])
                    }
                    if (this.res.errors.state){
						this.i(res.formValidateAddress.errors.state[0])
                    }
                    if (this.res.errors.zip){
						this.i(res.formValidateAddress.errors.zip[0])
					}
                } else {
                    this.swr()
                }
            }
            this.editAddressModal = false;
        },

        async deleteAddress(){
            this.isDeletingAddress = true
            // console.log('This is the contact data to be deleted')
            // console.log(this.currentContact)
            const res = await this.callApi('post', 'app/deleteAddress', this.addressData)
            if(res.status===200){
                this.s('Tag has been deleted successfully!')
                //window.location.reload(); // need to reload the modal
                //showDeleteContactModal(this, i)
            }else{
                this.swr()
            }
            this.isDeletingAddress = false
            this.showDeleteAddressModal = false
        },
////////////////////<--- Shared Modals --->////////////////////
        handleReset (name) {
            this.$refs[name].resetFields();
        },
    },
}
</script>


<template>
    <div>
       <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Contacts List <Button type="success" @click="createContactModal=true"><Icon type="md-add" />Add Contact</Button></p>

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
							<tr v-for="(contacts, i) in contactLists" :key="i">
                            <!-- v-if="contactss.length" -->
								<td>{{contacts.firstName}}</td>
								<td>{{contacts.lastName}}</td>
								<td>{{contacts.email}}</td>
                                <td>{{contacts.phone}}</td>
                                <td>{{contacts.birthday}}</td>
								<td>
                                <!-- <Button
                                    type="info"
                                    size="small"
                                    @click="$router.push({path: '/details/{id}', params: { id: $route.params.id },})"
                                    >Details</Button> -->
                                    <Button type="primary" size="small" @click="btnDetails(contact.id)">Details</Button>
									<Button type="warning" size="small" @click="btnEdit(contact.id)">Edit</Button>
	                                <button type="button" class="btn btn-sm btn-secondary" @click="btnDelete(contact.id)">Delete</button>
                                </td>
							</tr>
								<!-- ITEMS -->
						</table>

                        <!-- <div class="card-footer">
                            <pagination :data="contacts" @pagination-change-page="created"></pagination>
                        </div> -->
					</div>
				</div>

                <!-- Create Contact Modal -->
                <Modal
                    v-model="createContactModal"
					title="Create New Contact"
					:mask-closable="false"
					:closable="false"
                    >
                    <Form  ref="currentContact" :model="currentContact" :rules="ruleValidate" :label-width="90">
                        <FormItem label="First Name" prop="firstName">
                            <Input v-model="currentContact.firstName" placeholder="Enter the First Name"/>
                        </FormItem>
                        <FormItem label="Last Name" prop="lastName">
                            <Input v-model="currentContact.lastName" placeholder="Enter the Last Name"/>
                        </FormItem>
                        <FormItem label="E-mail" prop="mail">
                            <Input v-model="currentContact.email" placeholder="Enter their e-mail"/>
                        </FormItem>
                        <FormItem label="Phone" prop="phone">
                            <Input v-model="currentContact.phone" placeholder="Enter their phone number"/>
                        </FormItem>
                        <FormItem label="Birthday">
                            <div class="row">
                                <div class="col">
                                    <DatePicker format="yyyy/MM/dd" type="date" placeholder="Select date" v-model="currentContact.birthday"></DatePicker>
                                </div>
                            </div>
                        </FormItem>
                    </Form>
                    <div slot="footer">
                        <Button
                            type="default"
                            @click="closeCreateContactModal(formValidate)"
                            :disabled="isCreatingAddress"
                            :loading="isCreatingAddress"
                            style="margin-left: 8px">Cancel</Button>
                        <Button type="primary" @click="createContact('formValidate')" :disabled="isCreatingContact" :loading="isCreatingContact">{{isCreatingContact ? 'Creating..' : 'Add Contact'}}</Button>
                    </div>
                </Modal>

                <!-- Edit Contact Modal -->
				<Modal
					v-model="editContactModal"
					title="Edit Contact"
					:mask-closable="false"
					:closable="false">
                    <Form  ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="90">
                        <FormItem label="First Name" prop="firstName">
                            <Input v-model="formValidate.firstName" placeholder="Enter the First Name"/>
                        </FormItem>
                        <FormItem label="Last Name" prop="lastName">
                            <Input v-model="formValidate.lastName" placeholder="Enter the Last Name"/>
                        </FormItem>
                        <FormItem label="E-mail" prop="mail">
                            <Input v-model="formValidate.email" placeholder="Enter their e-mail"/>
                        </FormItem>
                        <FormItem label="Phone" prop="phone">
                            <Input v-model="formValidate.phone" placeholder="Enter their phone number"/>
                        </FormItem>
                        <FormItem label="Birthday">
                            <div class="row">
                                <div class="col">
                                    <DatePicker format="yyyy/MM/dd" type="date" placeholder="Select date" v-model="formValidate.birthday"></DatePicker>
                                </div>
                            </div>
                        </FormItem>
                    </Form>
                    <div slot="footer">
                        <Button @click="closeEditContactModal" style="margin-left: 8px">Cancel</Button>
                        <Button type="primary" @click="editContact('formValidate', 'index')">Submit</Button>
                    </div>
				</Modal>

                <!-- Delete Contact Warning Modal -->
                <Modal v-model="showDeletingContactModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure you want to delete this Contact?</p>

					</div>
					<div slot="footer">
						<Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteContact(currentContact, i)" >Delete</Button>
					</div>
                </Modal>

<!--------------------------------------------- /Address Modals ----------------------------------------------->
                <!-- Details Modal-->
                <Modal
                    v-model="detailsModal"
                    title="Contact Details"
					:mask-closable="false"
					:closable="false"
                     width=80%>
                    <!--~~~~~~~ Addresses Table ~~~~~~~~~-->
                    <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                        <div class="row">
                            <div class="col-6">
                                <h2>{{this.contactDetailsData.firstName}} {{this.contactDetailsData.lastName}}</h2>
                                <h4>Phone: {{this.contactDetailsData.phone}}</h4>
                                <h4>Email: {{this.contactDetailsData.email}}</h4>
                            </div>
                            <div class="col-6">
                                <Button type="success" class="float:right" @click="createAddressModal=true"><Icon type="md-add" />Add Contact</Button>
                            </div>
                        </div>
                        <div class="_overflow _table_div">
                            <table class="_table">
                                    <!-- TABLE TITLE -->
                                <tr>
                                    <th>Number</th>
                                    <th>Street</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Zip</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                                    <!-- TABLE TITLE --><!-- ITEMS -->
                                <tr v-for="(addresses, i) in addressList" :key="i">
                                <!-- v-if="contactss.length" -->
                                    <td>{{addresses.number}}</td>
                                    <td>{{addresses.street}}</td>
                                    <td>{{addresses.city}}</td>
                                    <td>{{addresses.state}}</td>
                                    <td>{{addresses.zip}}</td>
                                    <td>{{addresses.type}}</td>
                                    <td>
                                        <Button type="warning" size="small" @click="showEditAddressModal(addresses, i)">Edit</Button>
                                        <Button type="error" size="small" @click="$router.push({path: 'deleteAddress', params: { id: $route.params.id },})">Delete</Button>
                                        <Button
                                            type="error"
                                            size="small"
                                            @click="showDeleteAddressModal(addresses, i)"
                                            :loading="addresses.isDeleting">Delete
                                        </Button>
                                    </td>
                                </tr>
                                    <!-- ITEMS -->
                            </table>
                        </div>
                    </div>
                </Modal>

			</div>
		</div>
    </div>
</template>

