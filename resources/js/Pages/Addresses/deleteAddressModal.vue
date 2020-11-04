<template>
    <div class="content">
        <Modal
        :value="deleteAddressModalObj.showDeleteAddressModal"
        :mask-closable="false"
        :closable="false"
        width="360">

            <h1>This is the deleteAddres Page</h1>
        <!-- <createAddressModal></createAddressModal>
        <editAddressModal></editAddressModal>
        <deleteAddressModal></deleteAddressModal> -->

        </Modal>

    </div>

</template>

<script>
    // import addresses pages
// import detailsModal from '../Addresses/details'
// import createAddressModal from '../Addresses/createAddress'
// import editAddressModal from '../Addresses/editAddress'
// import deleteAddressModal from '../Addresses/deleteAddress'

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
            contactLists : [],
            addressList : [],
            token: '',
            addContactModal : false,
			editContactModal : false,
			isAdding : false,
            addAddressModal : false,
			editAddressModal : false,
			isAddingAddress : false,
			editContactData : {
                id : '',
                firstName : '',
                lastName : '',
                email : '',
                phone : '',
                birthday: '',
                address : [],
			},
			index : -1,
			showDeleteModal: false,
			isDeleing : false,
			deleteItem: {},
            deletingIndex: -1,
            deletingAddressIndex: -1,
			websiteSettings: []
        }
    },

    async created() {
        this.token = window.Laravel.csrfToken
        const res = await this.callApi('get', '/app/index',)
        if(res.status===200){
            this.contactLists = res.data
        } else {
            this.swr(error)
        }
    },
    showCreateContactModal(){
        const showAddContactModalObj = {
            showAddContactModal: true,
            Url : 'app/addContact',
            isAdding : false,
        }
        this.addContactData = addContactModalObj
        this.addContactModal = true
        this.index = index
    },
    showEditContactModal(contact, index){
        const editContactModalObj = {
            showEditContactModal: true,
            deleteUrl : 'app/editContact',
            contactData : contact,
            deletingIndex: i,
            isDeleted : false,
        }
        this.editContactData = editContactModalObj
        this.editContactModal = true
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
    }
}
</script>
