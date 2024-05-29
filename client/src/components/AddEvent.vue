<template>
  <div class="container">
    <!-- Progress bar -->
    <div class="progress_container">
      <div class="progress" :style="{ width: progressPercentage + '%' }"></div>
      <div class="circle" :class="{ active: step >= 1 }">1</div>
      <div class="circle" :class="{ active: step >= 2 }">2</div>
      <div class="circle" :class="{ active: step >= 3 }">3</div>
    </div>

    <!-- Step 1: Event Details -->
    <form v-if="step === 1" @submit.prevent="nextStep">
      <h2>Create Event</h2>
      <div class="form-group">
        <label for="name">Event Name:</label>
        <input type="text" id="name" v-model="event.name" required>
      </div>
      <div class="form-group">
        <label for="venue">Venue:</label>
        <input type="text" id="venue" v-model="event.venue" required>
      </div>
      <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" id="location" v-model="event.location" required>
      </div>
      <button type="submit">Next</button>
    </form>

    <!-- Step 2: Ticket Details -->
    <form v-if="step === 2" @submit.prevent="nextStep">
      <h2>Ticket Details</h2>
      <div v-for="(ticket, index) in tickets" :key="index" class="form-group">
       
        <label>Type:</label>
        <input type="text" v-model="ticket.type" required>
        <label>Price:</label>
        <input type="number" v-model="ticket.price" required>
        <button @click.prevent="removeTicket(index)">Remove Ticket</button>
      </div>
      <button @click.prevent="addTicket">Add Ticket</button>
      <button type="submit">Next</button>
    </form>

    <!-- Step 3: Review & Submit -->
    <form v-if="step === 3" @submit.prevent="submitForm">
      <h2>Review & Submit</h2>
      <h3>Event Details</h3>
      <p>Name: {{ event.name }}</p>
      <p>Venue: {{ event.venue }}</p>
      <p>Location: {{ event.location }}</p>
      <h3>Tickets</h3>
      <div v-for="(ticket, index) in tickets" :key="index">
        <p>Ticket {{ index + 1 }}:   {{ ticket.type }} - ${{ ticket.price }}</p>
      </div>
      <button type="submit">Submit</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      step: 1,
      event: {
        name: '',
        venue: '',
        location: ''
      },
      tickets: [
        { type: '', price: 0 }
      ]
    };
  },
  computed: {
    progressPercentage() {
      return (this.step / 3) * 100;
    }
  },
  methods: {
    nextStep() {
      if (this.step < 3) {
        this.step++;
      }
    },
    addTicket() {
      this.tickets.push({  type: '', price: 0 });
    },
    removeTicket(index) {
      this.tickets.splice(index, 1);
    },
    submitForm() {
      axios.post('/api/events', {
        event: this.event,
        tickets: this.tickets
      })
      .then(response => {
        console.log('Event and tickets created:', response.data);
        // Redirect or perform other actions upon successful creation
      })
      .catch(error => {
        console.error('Error creating event and tickets:', error);
      });
    }
  }
};
</script>

<style scoped>
/* Add your styles here */
.progress_container {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}

.progress {
  position: absolute;
  top: 50%;
  left: 0;
  height: 5px;
  background: #3498db;
  z-index: -1;
  transition: width 0.3s;
}

.circle {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background: #e0e0e0;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: bold;
}

.circle.active {
  background: #3498db;
  color: #fff;
}
</style>
