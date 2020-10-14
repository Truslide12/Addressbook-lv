<template>

    <div class="contents">
        <h1>Are you sure you want to </h1>
    </div>

</template>

<script>
export default {
    data() {
		return {
			data : {
                id: this.contactLists[this.index].id,
                firstName: this.contactLists[this.index].firstName,
                lastName: this.contactLists[this.index].lastName,
                email: this.contactLists[this.index].email,
                phone: this.contactLists[this.index].phone,
                birthday: this.contactLists[this.index].birthday,
            },
            token: '',
        }
    },
    methods : {
        async deleteImage() {
            const res = await this.callApi('post', 'Contacts/deleteContact', {id: this.data.id})
            if(res.status != 200) {
                this.swr()
            }
		},
    }
}
</script>
