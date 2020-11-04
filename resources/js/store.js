import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state : {
        contactsList : [],
        contactData : {
            id: '',
            firstName: '',
            lastName: '',
            email: '',
            phone: '',
            birthday: '',
            address: [],
        },
        deleteContactModalObj : {
            showDeleteModal: false,
            deleteUrl : '',
            data : null,
            deletingIndex: -1,
            isDeleted : false,
        },
        editContactModalObj : {
            showEditModal: false,
            editUrl : '',
            contactData : null,
            editingIndex: -1,
            isEdited : false,
        },
        detailsModalObj : {
            showEditModal: false,
            editUrl : '',
            contactData : null,
            editingIndex: -1,
            isEdited : false,
            addressListData : [],
        },
        deleteAddressModalObj : {
            showDeleteAddressModal: false,
            deleteUrl : '',
            addressData : null,
            deletingIndex: -1,
            isDeleted : false,
        },
        editAddressModalObj : {
            showEditModal: false,
            editUrl : '',
            contactData : null,
            editingIndex: -1,
            isEdited : false,
            addressListData: [],
        },
        user: false,
        userPermission: null
    },
    getters: {
        // Contact getters
        getContact(state){
           return state.data
        },
        getContactList(state){
            return state.contactsList
        },
        getDeleteModalObj(state){
            return state.deleteModalObj
        },
        getEditContactModalObj(state){
            return state.editContactModalObj
        },

        // Address getters
        getDetailsModalObj(state){
            return state.detailsModalObj
        },
        getAddressModalObj(state){
            return state.editAddressModalObj
        },
        getEditAddressModalObj(state){
            return state.editAddressModalObj
        },
        getEditAddressModalObj(state){
            return state.editAddressModalObj
        },
        getEditAddressModalObj(state){
            return state.editAddressModalObj
        },
        // getUserPermission(state){
        //     return state.userPermission
        // },
    },

    mutations: {
        // Contact Mutations
        setEditingContactModal(state, data){
            const deleteModalObj = {
                showDeleteModal: false,
                deleteUrl : '',
                data : null,
                deletingIndex: -1,
                isDeleted : data,
            }
            state.deleteModalObj = deleteModalObj
        },
        setEditingContactModalObj(state, contactData){
            state.editContactModalObj = contactData
        },
        setDeleteContactModal(state, contactData){
            const deleteContactModalObj = {
                showDeleteContactModal: false,
                deleteUrl : '',
                contactData : null,
                deletingIndex: -1,
                isDeleted : contactData,
            }
            state.deleteContactModalObj = deleteContactModalObj
        },
        setDeletingContactModalObj(state, contactData){
            state.deleteContactModalObj = contactData
        },
        // Address Mutations
        setContactData(state, contactData) {
            state.contactData = contactData
        },

        // Authentication
        setUpdateUser(state, data){
            state.user = data
        },
        setUserPermission(state, data){
            state.userPermission = data
        },

    },



    // actions :{
    //     changeCounterAction({commit}, data){
    //         commit('changeTheCounter', data)
    //     }
    // }


})
