<template>
    <div>
       <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Contacts List <Button type="success" @click="$router.push('createContact')"><Icon type="md-add" />Add Contact</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>First Name</th>
                                <th>Last Name</th>
								<th>Email</th>
								<th>Phone</th>
                                <th>Birthday</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->

                                <!-- Test Items -->
                            <!-- <tr>
                                <td>John</td>
                                <td>Malcovich</td>
                                <td>jm@fake.com</td>
                                <td>229-555-5555</td>
                                <td>2001-05-28</td>
								<td>
                                    <Button type="info" size="small" @click="$router.push({path:'/details', params: { id: $route.params.id },})">Details</Button>
									<Button type="info" size="small" @click="$router.push({path: 'editContact', params: { id: $route.params.id },})">Edit</Button>
									<Button type="error" size="small" @click="$router.push({path: 'deleteContact', params: { id: $route.params.id },})">Delete</Button>
                                </td>
                            </tr> -->


								<!-- ITEMS -->
							<tr v-for="(contacts, i) in contactLists" :key="i">
                            <!-- v-if="contactss.length" -->
								<td>{{contacts.firstName}}</td>
								<td>{{contacts.lastName}}</td>
								<td>{{contacts.email}}</td>
                                <td>{{contacts.phone}}</td>
                                <td>{{contacts.birthday}}</td>
								<td>
                                    <Button type="info" size="small" @click="$router.push({path:'/details', params: { id: $route.params.id },})">Details</Button>
									<Button type="warning" size="small" @click="$router.push({path: 'editContact', params: { id: $route.params.id },})">Edit</Button>
									<Button type="error" size="small" @click="$router.push({path: 'deleteContact', params: { id: $route.params.id },})">Delete</Button>
                                </td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
				</div>
			</div>
		</div>
    </div>
</template>

<script>
export default {
	data() {
		return {
			data : {
                id: '',
                firstName: '',
                lastName: '',
                email: '',
                phone: '',
                birthday: '',
            },
            contactLists: [],
            token: '',
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
}
</script>
