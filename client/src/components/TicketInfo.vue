<template>
    <div class="ticket-info-container">
      <img src="../assets/images/image.png" alt="Event Image" class="ticket-image" />
      <div class="ticket-details">
        <h1>{{ event.name }}</h1>
        <p><strong>Venue:</strong> {{ event.venue }}</p>
        <p><strong>Location:</strong> {{ event.location }}</p>
        <p><strong>Date:</strong> {{ event.date }}</p>
        <p><strong>Time:</strong> {{ event.time }}</p>
        <div v-for="ticket in event.tickets" :key="ticket.id" class="ticket-type">
          <p><strong>Type:</strong> {{ ticket.type }}</p>
          <p><strong>Price:</strong> ${{ ticket.price }}</p>
          <p><strong>Available:</strong> {{ ticket.amount }}</p>
        </div>
      </div>
      <button class="buy-ticket-button" @click="buyTicket">Buy Ticket</button>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    props: ['eventId'],
    data() {
      return {
        event: {
          name: '',
          venue: '',
          location: '',
          date: '',
          time: '',
          tickets: []
        },
        defaultImage: '../assets/images/default-image.png'
      };
    },
    mounted() {
      this.fetchEventDetails();
    },
    methods: {
      async fetchEventDetails() {
        try {
          const response = await axios.get(`http://127.0.0.1:8000/event/${this.eventId}`);
          this.event = response.data;
        } catch (error) {
          console.error('Error fetching event details:', error);
        }
      },
      buyTicket() {
        // Implement ticket purchase logic here
        alert('Ticket purchase functionality to be implemented.');
      }
    }
  };
  </script>
  
  <style scoped>
  .ticket-info-container {
    max-width: 800px;
    margin: auto;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .ticket-image {
    width: 100%;
    height: auto;
    border-radius: 10px;
  }
  
  .ticket-details {
    margin-top: 20px;
  }
  
  .ticket-type {
    margin-top: 10px;
  }
  
  .buy-ticket-button {
    display: block;
    width: 100%;
    padding: 15px;
    margin-top: 20px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
  }
  
  .buy-ticket-button:hover {
    background-color: #2980b9;
  }
  </style>
  