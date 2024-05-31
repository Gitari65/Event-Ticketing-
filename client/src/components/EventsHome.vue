<template>
    <div>
      <div class="row">
        <div v-for="(event, index) in events" :key="index" class="col-md-4">
          <div class="card">
            <img src='../assets/images/image.png' class="card-img-top" alt="Event Image">
            <div class="card-body">
              <h5 class="card-title">{{ event.name }}</h5>
              <p class="card-text">{{ event.venue }}</p>
              <p class="card-text">{{ event.location }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        events: [],
        successMessage: 'Events fetched successfully!',
        errorMessage: 'Error fetching events. Please try again.',
        loading: false
      };
    },
    mounted() {
      this.getAllEvents();
    },
    methods: {
      async getAllEvents() {
        this.loading = true;
        try {
          const eventResponse = await axios.post('http://127.0.0.1:8000/events');
          this.events = eventResponse.data.events;
          console.log("Event data:", eventResponse.data);
        } catch (error) {
          this.loading = false;
          this.errorMessage = 'Error fetching events';
          console.error('Error fetching events:', error);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .card {
    margin-bottom: 20px;
  }
  </style>
  