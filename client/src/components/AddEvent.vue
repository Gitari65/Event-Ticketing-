<template>
  <div class="container">
    <SuccessPage v-if="successMessage" :message="successMessage" />
    <ErrorPage v-if="errorMessage" :message="errorMessage" />
    <div v-if="loading" class="overlay">
      <SpinnerPage />
    </div>
    
    <!-- Progress bar -->
    <div class="progress-container">
      <div class="progress" :style="{ width: progressPercentage + '%' }"></div>
      <div class="circle" :class="{ active: step >= 1 }">1</div>
      <div class="circle" :class="{ active: step >= 2 }">2</div>
      <div class="circle" :class="{ active: step >= 3 }">3</div>
    </div>

    <!-- Form steps -->
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
        <p>Ticket {{ index + 1 }}: {{ ticket.type }} - ${{ ticket.price }}</p>
      </div>
      <button type="submit">Submit</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import SuccessPage from '../assets/constants/SuccessPage.vue';
import ErrorPage from '../assets/constants/ErrorPage.vue';
import SpinnerPage from '../assets/constants/SpinnerPage.vue';

export default {
  data() {
    return {
      step: 1,
      eventId: null,
      event: {
        name: '',
        venue: '',
        location: '',
        successMessage: 'Event created successfully!',
      errorMessage: 'Error creating event. Please try again.',
        user_id: ''
      },
      tickets: [{ type: '', price: 0 }],
      loading: false,
      errorMessage: '',
      successMessage: ''
    };
  },
  components: {
    SuccessPage,
    ErrorPage,
    SpinnerPage
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
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
      this.tickets.push({ type: '', price: 0 });
    },
    removeTicket(index) {
      this.tickets.splice(index, 1);
    },
    async submitForm() {
      this.loading = true;
      this.errorMessage = '';
      this.successMessage = '';
      
      this.event.user_id = this.user.id;

      if (!this.event.user_id) {
        this.loading = false;
        this.errorMessage = 'User not logged in';
        return;
      }

      try {
        const eventResponse = await axios.post('http://127.0.0.1:8000/event/create', this.event);

        if (!eventResponse.data || !eventResponse.data.eventId) {
          throw new Error('Invalid event response structure');
        }

        this.eventId = eventResponse.data.eventId;

        await axios.post('http://127.0.0.1:8000/ticket/create', {
          tickets: this.tickets,
          eventId: this.eventId
        });

        this.loading = false;
        this.successMessage = 'Event and tickets created successfully!';
      } catch (error) {
        this.loading = false;
        this.errorMessage = 'Error creating event and tickets';
        console.error('Error creating event and tickets:', error);
      }
    }
  }
};
</script>
<style scoped>
.container {
  position: relative;
  max-width: 800px;
  margin: auto;
  padding: 20px;
}

.progress-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
  position: relative;
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

.form-group {
  margin-bottom: 15px;
}

.align-items-center {
  display: flex;
  justify-content: center;
  align-items: center;
}

.align-text-center {
  text-align: center;
}

.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background: rgba(0, 0, 0, 0.5);
  z-index: 1000;
}

.overlay > * {
  background: white;
  padding: 20px;
  border-radius: 10px;
  text-align: center;
}
</style>
