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
                                    <Button type="primary" size="small" @click="showDetailsModal(contacts,i)">Details</Button>
									<Button type="warning" size="small" @click="showEditContactModal(contacts, i)">Edit</Button>
									<Button
                                        type="error"
                                        size="small"
                                        @click="showDeleteContactModal(contacts, i)"
                                        :loading="contacts.isDeleting">Delete
                                    </Button>
                                </td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
				</div>

                <!-- Create Contact Modal -->
                <Modal
                    v-model="createContactModal"
					title="Create New Contact"
					:mask-closable="false"
					:closable="false"
                    >
                    <Form  ref="contactData" :model="contactData" :rules="ruleValidate" :label-width="90">
                        <FormItem label="First Name" prop="firstName">
                            <Input v-model="contactData.firstName" placeholder="Enter the First Name"/>
                        </FormItem>
                        <FormItem label="Last Name" prop="lastName">
                            <Input v-model="contactData.lastName" placeholder="Enter the Last Name"/>
                        </FormItem>
                        <FormItem label="E-mail" prop="mail">
                            <Input v-model="contactData.email" placeholder="Enter their e-mail"/>
                        </FormItem>
                        <FormItem label="Phone" prop="phone">
                            <Input v-model="contactData.phone" placeholder="Enter their phone number"/>
                        </FormItem>
                        <FormItem label="Birthday">
                            <div class="row">
                                <div class="col">
                                    <DatePicker format="yyyy/MM/dd" type="date" placeholder="Select date" v-model="contactData.birthday"></DatePicker>
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
					:closable="false"
                >
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
                        <Button type="primary" @click="editContact('formValidate')">Submit</Button>
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
						<Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteContact(contact, i)" >Delete</Button>
					</div>
                </Modal>

<!--------------------------------------------- /Address Modals ----------------------------------------------->
                <!-- Details Modal-->
                <Modal
                    v-model="showingDetailsModal"
                    title="Contact Details"
					:mask-closable="false"
					:closable="false">
                                   <!--~~~~~~~ Addresses Table ~~~~~~~~~-->
                    <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                        <Button type="info" size="small" @click="$router.push({path:'createAddress', params: { id: $route.params.id },})">Add Address</Button>
                        <h4>{{this.contactData.firstName}} {{this.contactData.lastName}}</h4>

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
                                <tr v-for="(addresses, i) in addressLists" :key="i">
                                <!-- v-if="contactss.length" -->
                                    <td>{{addresses.number}}</td>
                                    <td>{{addresses.street}}</td>
                                    <td>{{addresses.city}}</td>
                                    <td>{{addresses.state}}</td>
                                    <td>{{addresses.zip}}</td>
                                    <td>{{addresses.type}}</td>
                                    <td>
                                        <Button type="warning" size="small" @click="showEditAddressModal(addresses, i)">Edit</Button>
                                        <Button type="error" size="small" @click="$router.push({path: 'deleteContact', params: { id: $route.params.id },})">Delete</Button>
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

<script>
// import contacts pages
// import createContactModal from './createContactModal.vue'
// import editContactModal from './editContactModal.vue'
// import deleteContactModal from './deleteContactModal.vue'

// import addresses pages
// import detailsModal from '../Addresses/detailsModal.vue'
// import createAddressModal from '../Addresses/createAddressModal.vue'
// import editAddressModal from '../Addresses/editAddressModal.vue'
// import deleteAddressModal from '../Addresses/deleteAddressModal.vue'

import  { mapGetters  } from 'vuex'

export default {
	data() {
		return {
			contactData : {
                id : '',
                firstName : '',
                lastName : '',
                email : '',
                phone : '',
                birthday: '',
                addressLists : [],
            },
            contactTable: [
                {
                    title: 'First Name',
                    key: 'firstName',
                    sortable: true,
                },
            ],
            contactLists : [],
            addressLists : [],
            token: '',
            createContactModal : false,
            isCreatingContact : false,
            formValidate: {
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
            isEditingContact : false,
            createAddressModal : false,
			editAddressModal : false,
            isCreatingAddress : false,
            isEditingAddress : false,
			index : -1,
			showDeletingContactModal: false,
			isDeleting : false,
			deleteItem: {},
            deletingIndex: -1,
            showingDetailsModal: false,
            deletingAddressIndex: -1,
			websiteSettings: [],
            token: '',
        }
    },

    // mounted(){
    //     this.contactData = this.$store.getter.getContactData;
    // },

    async created() {
        this.token = window.Laravel.csrfToken
        const res = await this.callApi('get', 'app/index',)
        // console.log(res)
        if(res.status===200){
            this.contactLists = res.data
        } else {
            this.swr(error)
        }
    },

    methods : {
        async createContact(formValidate) {
            if(this.contactData.firstName.trim()=='') return this.e('First Name is required')
            if(this.contactData.lastName.trim()=='') return this.e('Last Name is required')
            if(this.contactData.email.trim()=='') return this.e('Email is required')
            if(this.contactData.phone.trim()=='') return this.e('Phone is required')
            // if(this.formValidate.birthday.trim()=='') return this.e('Birthday is required')

            this.isCreatingContact = true
			const res = await this.callApi(
                'post',
                'app/createContact',
                this.contactData)
            console.log(res)
			if(res.status===201){
				this.contactLists.unshift(res.data) // need to add this to vue
				this.s('Contact has been edited successfully!')
				this.contactData.firstName = ''
                this.contactData.lastName = ''
                this.contactData.email = ''
                this.contactData.phone = ''
                this.contactData.birthday = ''
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

        closeCreateContactModal(formValidate) {
            // handleReset (formValidate);
            this.isCreatingContact = false;
            this.createContactModal = false;
        },

        showEditContactModal(contact, index){
            let obj = {
                id : contact.id,
                firstName : contact.firstName,
                lastName : contact.lastName,
                email : contact.email,
                phone : contact.phone,
                birthday : contact.birthday,
            }
            this.formValidate = obj
            this.editContactModal = true
            this.index = index
        },
        closeEditContactModal() {
            this.isEditingContact = false;
            this.editContactModal = false;
        },

        async editContact(){
            console.log(this.formValidate)
            if(this.formValidate.firstName.trim()=='') return this.e('First Name is required')
            if(this.formValidate.lastName.trim()=='') return this.e('Last Name is required')
            if(this.formValidate.email.trim()=='') return this.e('Email is required')
            if(this.formValidate.phone.trim()=='') return this.e('Phone is required')
            // if(this.formValidate.birthday.trim()=='') return this.e('Birthday is required')
  			const res = await this.callApi('post', 'app/editContact', this.formValidate)
            console.log(res)
			if(res.status===200){
                this.contacts[this.index].firstName = this.formValidate.firstName
                this.contacts[this.index].lastName = this.formValidate.lastName
                this.contacts[this.index].email = this.formValidate.email
                this.contacts[this.index].phone = this.formValidate.phone
                this.contacts[this.index].birthday = this.formValidate.birthday
				this.s('Contact has been edited successfully!')
				// this.contactLists.unshift(res.formValidate) // need to add this to vue
				// this.s('Contact has been edited successfully!')
				this.formValidate.firstName = ''
                this.formValidate.lastName = ''
                this.formValidate.email = ''
                this.formValidate.phone = ''
                this.formValidate.birthday = ''
				this.editContactModal = false
                // need to reload the context/index.vue
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
            this.editContactModal = false;
        },

        async showDetailsModal(contact, index){
            this.token = window.Laravel.csrfToken
            // set the contactDetails info to the current contact
            // this.$store.commit("setContactData", contact);
            const res = await this.callApi('get', 'app/details', contact)
            console.log(res)
            const addresses = await this.callApi('get', 'app/showDetails', contact)
            console.log(addresses)
            // this.addressLists = res.addressLists
            // console.log(res)
            // if(res.status===200){
            //     this.addressLists = res.data
            //     this.showingDetailsModal = true
            // } else {
            //     this.swr(error)
            // }
        },

        handleReset (name) {
            this.$refs[name].resetFields();
        },

        // showDeletingModal(contact, i){
        //     const deleteContactModalObj  =  {
        //         showDeleteContactModal: true,
        //         deleteUrl : 'app/deleteContact',
        //         contactData : contact,
        //         deletingIndex: i,
        //         isDeleted : false,
        //     }
        //     this.$store.commit('setDeletingModalObj', deleteContactModalObj)
        //     console.log('delete method called')
        //     this.deleteItem = contact
        //     this.deletingIndex = i
        //     this.showDeleteContactModal = true
        // },
        showDeleteContactModal(contact, i){
            console.log(contact)
            this.contactData = contact
            console.log('delete method called')
			this.deletingIndex = i
            this.showDeletingContactModal = true
            console.log(this.contactData)
        },
        async deleteContact(){
            this.isDeleting = true
            console.log('This is the contact data to be deleted')
            console.log(this.contactData)
			const res = await this.callApi('post', 'app/deleteContact', this.contactData)
			if(res.status===200){
				this.tags.splice(this.deletingIndex , 1)
				this.s('Tag has been deleted successfully!')
			}else{
				this.swr()
			}
			this.isDeleting = false
			this.showDeleteConactModal = false
		},
    },
    getters: {
        // getContactData(state){

        //    return state.contactData
        // },
        // getContactLists(state){

        // },
        // getDeleteModalObj(state){
        //     return state.deleteModalObj
        // },

        // getUserPermission(state){
        //     return state.userPermission
        // },
    },
    // components : {
	// 	deleteModal
	// },
	// computed : {
	// 	...mapGetters(['getDeleteModalObj'])
	// },
	// watch : {
	// 	getDeleteModalObj(obj){
	// 		if(obj.isDeleted){
	// 			this.tags.splice(obj.deletingIndex,1)
	// 		}
	// 	}
	// },
}

</script>
