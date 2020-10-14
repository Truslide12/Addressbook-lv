<template>

    <div class="contents">
        <h1>This is the editContact Page</h1>
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
        async edit() {
            if(this.data.firstName.trim()=='') return this.e('First Name is required')
            if(this.data.lastName.trim()=='') return this.e('Last Name is required')
            if(this.data.email.trim()=='') return this.e('Email is required')
            if(this.data.phone.trim()=='') return this.e('Phone is required')
            if(this.data.birthday.trim()=='') return this.e('Birthday is required')
			const res = await this.callApi(
				'post',
				'/Contacts/editContact',
				this.data
			);
			if(res.status===200){
                this.contactLists[this.index].firstName = this.data.firstName
                this.contactLists[this.index].lasstName = this.data.lastName
                this.contactLists[this.index].email = this.data.email
                this.contactLists[this.index].firstName = this.data.phone
                this.contactLists[this.index].birthday = this.data.birthday
				this.s('Contact has been updated successfully!')

			} else {
				if(res.status==422) {
					if (this.res.errors.firstName){
						this.i(res.data.errors.firstName[0])
                    }
                    if (this.res.errors.lastName){
						this.i(res.data.errors.lastName[0])
                    }
                    if (this.res.errors.email){
						this.i(res.data.errors.email[0])
                    }
                    if (this.res.errors.phone){
						this.i(res.data.errors.phone[0])
                    }
                    if (this.res.errors.birthday){
						this.i(res.data.errors.birthday[0])
					}
				}
				else {
					this.swr()
				}
			}
        },
    }
}
</script>
