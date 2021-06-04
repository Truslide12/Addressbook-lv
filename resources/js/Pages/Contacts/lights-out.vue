<script>
import axios from 'axios';

export default {
	data() {
		return {
      contacts: [],
    }
  },
  mounted() {
    this.getContacts();
  },
  methods: {
    async getContacts() {
      try {
        const response = await axios.get('/api/contacts');
        this.contacts = response.data;
      } catch (err) {
        alert(err);
      }
    }
  },
}
</script>
<style>
</style>
<template>
<div>
  <div class="content">
    <div class="container-fluid">
      <h1 class="mt-0 pt-0 pb-2">Contacts</h1>
      <hr class="mb-3">
      <Button type="success" @click="btnCreate()">New Contact</Button>
      <table class="_table mt-3">
      <tr>
        <th>ID</th>
        <th>First</th>
        <th>Last</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Birthday</th>
        <th>Actions</th>
      </tr>
      <tr v-for="contact in contacts" :key="contact.id">
        <td>{{ contact.id }}</td>
        <td>{{ contact.firstName }}</td>
        <td>{{ contact.lastName }}</td>
        <td>{{ contact.email }}</td>
        <td>{{ contact.phone }}</td>
        <td>{{ contact.birthday }}</td>
        <td>
            <Button type="button" size="small" @click="btnDetails(contact.id)">Details</Button>
            <Button type="button" size="small" @click="btnEdit(contact.id)">Edit</Button>
            <Button type="button" size="small" @click="btnDelete(contact.id)">Delete</Button>
        </td>
      </tr>
      </table>
      


    </div>
  </div>
</div>
</template>