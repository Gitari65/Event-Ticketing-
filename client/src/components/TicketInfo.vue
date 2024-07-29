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
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Type of Ticket</th>
                <th>Price</th>
                <th>Amount</th>
                <th>Unit Total</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="ticket in event.tickets" :key="ticket.id">
                <td>{{ ticket.type }}</td>
                <td>${{ ticket.price }}</td>
                <td>
                  <select v-model.number="ticket.selectedAmount" class="form-control">
                    <option v-for="n in 11" :key="n" :value="n - 1">{{ n - 1 }}</option>
                  </select>
                </td>
                <td>${{ ticket.price }}</td>
                <td>${{ ticket.selectedAmount * ticket.price }}</td>
              </tr>
            </tbody>
          </table>
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
          <div class="receipt p-3 border rounded mb-3">
            <h3>Receipt</h3>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Type</th>
                  <th>Price</th>
                  <th>Amount</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="ticket in selectedTickets()" :key="ticket.id">
                  <td>{{ ticket.type }}</td>
                  <td>${{ ticket.price }}</td>
                  <td>{{ ticket.selectedAmount }}</td>
                  <td>${{ ticket.selectedAmount * ticket.price }}</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3" class="text-right"><strong>Total:</strong></td>
                  <td>${{ calculateTotal() }}</td>
                </tr>
              </tfoot>
            </table>
          </div>
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
      total: 0,
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
        this.event.tickets.forEach(ticket => (ticket.selectedAmount = 0));
      } catch (error) {
        console.error('Error fetching event details:', error);
      }
    },
    calculateTotal() {
      const totalPrice = this.event.tickets.reduce((total, ticket) => total + ticket.selectedAmount * ticket.price, 0);
      this.total = totalPrice;
      return totalPrice;
    },
    goToStep(step) {
      if (this.total === 0) {
        alert('To proceed, choose a ticket to buy.');
        this.step = step - 1;
      } else {
        this.step = step;
      }
    },
    selectedTickets() {
      return this.event.tickets.filter(ticket => ticket.selectedAmount > 0);
    },
    async confirmPurchase() {
      const phoneNumber = prompt("Enter your phone number");
      const amount = this.calculateTotal();
      try {
        await axios.post('/payment/initiate', {
          phone_number: phoneNumber,
          amount: amount
        });
        alert('Payment initiated. Please check your phone to complete the payment.');
      } catch (error) {
        console.error('Error initiating payment:', error);
      }
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

.receipt {
  background: #f9f9f9;
  border-radius: 10px;
}

h3 {
  margin-bottom: 20px;
}
</style>
