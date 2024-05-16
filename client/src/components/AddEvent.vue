<template>
  <div>
    <h2>Create Event</h2>
    <form @submit.prevent="createEvent">
      <div class="form-group">
        <label for="name">Event Name:</label>
        <input type="text" id="name" v-model="eventName" required>
      </div>
      <div class="form-group">
        <label for="venue">Venue:</label>
        <input type="text" id="venue" v-model="venue" required>
      </div>
      <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" id="location" v-model="location" required>
      </div>
      <button type="submit">Create Event</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      eventName: '',
      venue: '',
      location: ''
    };
  },
  methods: {
    createEvent() {
      axios.post('/api/events', {
          name: this.eventName,
          venue: this.venue,
          location: this.location
        })
        .then(response => {
          console.log('Event created:', response.data);
          // Optionally, redirect to another page or perform other actions upon successful creation
        })
        .catch(error => {
          console.error('Error creating event:', error);
        });
    }
  }
};
</script>

<style scoped>
/* Add your component styles here */
</style>
