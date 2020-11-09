<template>

    <div class="content">
        <!-- <Modal
        :value="detailsModalObj.showDetailsModal"
        :mask-closable="false"
        :closable="false"
        width="360"> -->

        <h1>This is the Contact Details Page</h1>
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Contact Details <Button type="info" size="small" @click="$router.push({path:'createAddress', params: { id: $route.params.id },})">Add Address</Button></p>

                    <div class="_overflow _table_div">
                        <table class="_table"> -->
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
                            <!-- <tr v-for="(addresses, i) in addressLists" :key="i"> -->
                            <!-- v-if="contactss.length" -->
                                <!-- <td>{{addresses.firstName}}</td>
                                <td>{{addresses.lastName}}</td>
                                <td>{{addresses.email}}</td>
                                <td>{{addresses.phone}}</td>
                                <td>{{addresses.birthday}}</td>
                                <td>

                                    <Button type="warning" size="small" @click="$router.push({path: 'editAddress', params: { id: $route.params.id },})">Edit</Button>
                                    <Button type="error" size="small" @click="$router.push({path: 'deleteAddress', params: { id: $route.params.id },})">Delete</Button>
                                </td>
                            </tr> -->
                                <!-- ITEMS -->
                        </table>
                    </div>
                </div>

                <!-- <createAddressModal></createAddressModal>
                <editContactModal></editContactModal>
                <deleteContactModal></deleteContactModal> -->

            </div>
        <!-- </Modal> -->
    </div>

</template>

<script>
// import addresses pages
// import createAddressModal from './createAddressModal'
// import editAddressModal from './editAddressModal'
// import deleteAddressModal from './deleteAddressModal'

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
                address : [],
            },
            addressList : [],
            token: '',
			isAdding : false,
            createAddressModal : false,
			editAddressModal : false,
			isCreatingAddress : false,
			index : -1,
			showDeleteModal: false,
			isDeleing : false,
			deleteItem: {},
            deletingIndex: -1,
            deletingAddressIndex: -1,
			websiteSettings: []
        }
    },

    mounted(){
        this.contactData = this.$store.getters.getContactData
    },

    async created() {
        this.token = window.Laravel.csrfToken
        let i = contactData.id
        const res = await this.callApi('get', '/app/details', i)
        if(res.status===200){
            this.addressLists = res.data
        } else {
            this.swr(error)
        }
    },
    showCreateAddressModal(address, index){
        const createAddressModalObj = {
            showCreateAddressModal: true,
            createUrl : 'app/createAddress',
            addressData : address,
            deletingAddressIndex: i,
            isAddressDeleted : false,
        }
        this.editAddressData = editAddressModalObj
        this.editModal = true
        this.index = index
    },
    showEditAddressModal(address, index){
        const editAddressModalObj = {
            showEditAddressModal: true,
            deleteUrl : 'app/editAddress',
            addressData : address,
            deletingAddressIndex: i,
            isAddressDeleted : false,
        }
        this.editData = editContactModalObj
        this.editModal = true
        this.index = index
    },
    showDeletingModal(contact, i){
        const deleteContactModalObj  =  {
            showDeleteModal: true,
            deleteUrl : 'app/deleteContact',
            contactData : contact,
            deletingIndex: i,
            isDeleted : false,
        }
        this.$store.commit('setDeletingModalObj', deleteContactModalObj)
        console.log('delete method called')
        this.deleteItem = contact
        this.deletingIndex = i
        this.showDeleteModal = true
    },
}
</script>

