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
      <div class="circle" :class="{ active: step >= 4 }">4</div>
    </div>

    <!-- Form steps -->
    <!-- Step 1: Event Details -->
    <form v-if="step === 1" @submit.prevent="nextStep">
      <h2>Create Event</h2>
      <div class="mb-3">
        <label for="name" class="form-label">Event Name:</label>
        <input type="text" id="name" v-model="event.name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="venue" class="form-label">Venue:</label>
        <input type="text" id="venue" v-model="event.venue" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="location" class="form-label">Location:</label>
        <input type="text" id="location" v-model="event.location" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="date">Date</label>
        <input v-model="event.date" type="date" class="form-control" id="date" required>
      </div>
      <div class="form-group">
        <label for="time">Time</label>
        <input v-model="event.time" type="time" class="form-control" id="time" required>
      </div>
      <button type="submit" class="btn btn-primary">Next</button>
    </form>

    <!-- Step 2: Ticket Details -->
    <form v-if="step === 2" @submit.prevent="nextStep">
      <h2>Ticket Details</h2>
      <div v-for="(ticket, index) in tickets" :key="index" class="mb-3 p-3 border rounded">
        <div class="mb-3">
          <label class="form-label">Type:</label>
          <input type="text" v-model="ticket.type" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Price:</label>
          <input type="number" v-model="ticket.price" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">No. of Tickets:</label>
          <input type="number" v-model="ticket.amount" class="form-control" required>
        </div>
        <button @click.prevent="removeTicket(index)" class="btn btn-danger btn-sm">Remove Ticket</button>
      </div>
      <button @click.prevent="addTicket" class="btn btn-secondary btn-sm mb-3">Add Ticket</button>
      <button type="submit" class="btn btn-primary">Next</button>
    </form>

    <!-- Step 3: Review & Submit -->
    <div v-if="step === 3">
      <h2>Review & Submit</h2>
      <div class="mb-3 p-3 border rounded">
        <h3>Event Details</h3>
        <p><strong>Name:</strong> {{ event.name }}</p>
        <p><strong>Venue:</strong> {{ event.venue }}</p>
        <p><strong>Location:</strong> {{ event.location }}</p>
      </div>
      <div class="mb-3 p-3 border rounded">
        <h3>Tickets</h3>
        <div v-for="(ticket, index) in tickets" :key="index">
          <p><strong>Ticket {{ index + 1 }}:</strong> {{ ticket.type }} - ${{ ticket.price }} ({{ ticket.amount }} available)</p>
        </div>
      </div>
      <button @click.prevent="editForm(2)" class="btn btn-warning me-2">Edit Tickets</button>
      <button @click.prevent="submitForm" class="btn btn-primary">Next</button>
    </div>

    <!-- Step 4: Upload Image -->
    <form v-if="step === 4" @submit.prevent="submitForm">
      <h2>Upload Event Image</h2>
      <div class="mb-3">
        <label for="image" class="form-label">Select Image:</label>
        <input type="file" id="image" @change="onFileChange" class="form-control" required>
      </div>
      <button @click.prevent="editForm(3)" class="btn btn-warning me-2">Edit Event Details</button>
      <button type="submit" class="btn btn-success">Submit</button>
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
        user_id: '',
        date: '',
        time: ''
      },
      tickets: [{ type: '', price: 0, amount: 0 }],
      image: null,
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
      return (this.step / 4) * 100;
    }
  },
  methods: {
    nextStep() {
      if (this.step < 4) {
        this.step++;
      }
    },
    addTicket() {
      this.tickets.push({ type: '', price: 0, amount: 0 });
    },
    removeTicket(index) {
      this.tickets.splice(index, 1);
    },
    editForm(step) {
      this.step = step;
    },
    onFileChange(e) {
      const file = e.target.files[0];
      this.image = file;
    },
    async submitForm() {
      this.loading = true;
      this.errorMessage = '';
      this.successMessage = '';

      try {
        if (!this.user || !this.user.id) {
          this.loading = false;
          this.errorMessage = 'User not logged in';
          throw new Error('User not logged in');
        }

        this.event.user_id = this.user.id;

        // Handle event and ticket creation only at Step 3
        if (this.step === 3) {
          const eventResponse = await axios.post('http://127.0.0.1:8000/event/create', this.event);

          if (!eventResponse.data || !eventResponse.data.eventId) {
            this.loading = false;
            throw new Error('Invalid event response structure');
          }

          this.eventId = eventResponse.data.eventId;

          await axios.post('http://127.0.0.1:8000/ticket/create', {
            tickets: this.tickets,
            eventId: this.eventId
          });

          this.step = 4; // Move to Step 4 for image upload
          this.loading = false;
        } else if (this.step === 4) {
          // Handle image upload on Step 4
          const formData = new FormData();
          formData.append('event_id', this.eventId);
          formData.append('image', this.image);

          const response = await axios.post('http://127.0.0.1:8000/image/upload', formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          });

          this.successMessage = response.data.success;
          this.loading = false;
          this.step = 1; // Reset to Step 1 or move to a success page as needed
        }
      } catch (error) {
        this.loading = false;
        this.errorMessage = error.message || 'Error during submission process';
        console.error('Error during submission process:', error);
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
  background: #f9f9f9;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
  height: 4px;
  background: #4caf50;
  transition: width 0.4s ease;
  z-index: -1;
}

.circle {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background: #ddd;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1;
}

.circle.active {
  background: #4caf50;
  color: #fff;
}

.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.btn {
  margin-right: 10px;
}
</style>
