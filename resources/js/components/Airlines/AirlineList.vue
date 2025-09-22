<template>
  <div>
    <h3>Airlines</h3>
    <button class="btn btn-primary mb-2" @click="showModal=true">Add Airline</button>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Code</th>
          <th>Country</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="airline in airlines" :key="airline.id">
          <td>{{ airline.name }}</td>
          <td>{{ airline.code }}</td>
          <td>{{ airline.country }}</td>
          <td>{{ airline.contact_email }}</td>
          <td>{{ airline.contact_phone }}</td>
          <td>
            <button class="btn btn-sm btn-warning" @click="editAirline(airline)">Edit</button>
            <button class="btn btn-sm btn-danger" @click="deleteAirline(airline.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <AirlineForm v-if="showModal" :airline="selectedAirline" @close="showModal=false" @saved="fetchAirlines"/>
  </div>
</template>

<script>
import axios from 'axios';
import AirlineForm from './AirlineForm.vue';

export default {
  components: { AirlineForm },
  data() {
    return {
      airlines: [],
      showModal: false,
      selectedAirline: null,
    };
  },
  methods: {
    fetchAirlines() {
      axios.get('/api/airlines').then(res => this.airlines = res.data);
    },
    editAirline(airline) {
      this.selectedAirline = airline;
      this.showModal = true;
    },
    deleteAirline(id) {
      if(confirm('Delete this airline?')) {
        axios.delete(`/api/airlines/${id}`).then(() => this.fetchAirlines());
      }
    }
  },
  mounted() {
    this.fetchAirlines();
  }
};
</script>
