<template>
  <div class="container">
    <div v-if="step === 1">
      <div class="row mb-3 d-flex align-items-center justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-5">
          <img :src="defaultImage" alt="Event Image" class="img-fluid rounded ticket-image" />
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12">
          <div class="ticket-details">
            <h1>{{ event.name }}</h1>
            <p><i class="fas fa-map-marker-alt"></i> <strong>Venue:</strong> {{ event.venue }}</p>
            <p><i class="fas fa-location-arrow"></i> <strong>Location:</strong> {{ event.location }}</p>
            <p><i class="fas fa-calendar-alt"></i> <strong>Date:</strong> {{ event.date }}</p>
            <p><i class="fas fa-clock"></i> <strong>Time:</strong> {{ event.time }}</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div v-for="ticket in event.tickets" :key="ticket.id" class="col-sm-6 col-md-4 ticket-type mb-3">
              <div class="ticket-info p-3 border rounded">
                <p><i class="fas fa-ticket-alt"></i> <strong>Type:</strong> {{ ticket.type }}</p>
                <p><i class="fas fa-dollar-sign"></i> <strong>Price:</strong> ${{ ticket.price }}</p>
                <p><i class="fas fa-box"></i> <strong>Available:</strong> {{ ticket.amount }}</p>
                <div class="form-group">
                  <label for="amount"><i class="fas fa-sort-numeric-up"></i> <strong>Amount:</strong></label>
                  <input type="number" v-model.number="ticket.selectedAmount" min="0" max="ticket.amount" class="form-control" />
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <h3>Total: ${{ calculateTotal() }}</h3>
              <button class="btn btn-primary btn-block buy-ticket-button" @click="goToStep(2)">Next</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else-if="step === 2">
      <div class="row mb-3">
        <div class="col-12">
          <h2>Confirm Your Tickets</h2>
          <div v-for="ticket in selectedTickets()" :key="ticket.id" class="ticket-info-confirm p-3 border rounded mb-3">
            <p><strong>Type:</strong> {{ ticket.type }}</p>
            <p><strong>Price:</strong> ${{ ticket.price }}</p>
            <p><strong>Amount:</strong> {{ ticket.selectedAmount }}</p>
            <p><strong>Total:</strong> ${{ ticket.selectedAmount * ticket.price }}</p>
          </div>
          <h3>Total Amount to Pay: ${{ calculateTotal() }}</h3>
          <button class="btn btn-secondary" @click="goToStep(1)">Back</button>
          <button class="btn btn-success" @click="confirmPurchase">Confirm</button>
        </div>
      </div>
    </div>
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
      defaultImage: '../assets/images/event poster.jpeg',
      step: 1,
      total:0,
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
        this.event.tickets.forEach(ticket => ticket.selectedAmount = 0);
      } catch (error) {
        console.error('Error fetching event details:', error);
      }
    },
    calculateTotal() {
      const totalPrice=this.event.tickets.reduce((total, ticket) => total + ticket.selectedAmount * ticket.price, 0)
      this.total=totalPrice;
      return totalPrice;
    },
    goToStep(step) {
    
      if(this.total==0){
        alert('To Proceed chose a ticket to buy.');
        this.step = step-1;
      }
      else
      this.step = step;
    },
    selectedTickets() {
      return this.event.tickets.filter(ticket => ticket.selectedAmount > 0);
    },
    confirmPurchase() {
      const phoneNumber = prompt("Enter your phone number");
      const amount = this.calculateTotal();

      axios.post('/payment/initiate', {
        phone_number: phoneNumber,
        amount: amount
      }).then(response => {
        alert('Payment initiated. Please check your phone to complete the payment.');
      }).catch(error => {
        console.error('Error initiating payment:', error);
      });
    }
  }
};
</script>

<style scoped>
.container {
  box-shadow: #2980b9;
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

.ticket-info-confirm {
  background: #f9f9f9;
  border-radius: 10px;
}
</style>
