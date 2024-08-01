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
          <button class="btn btn-success" @click="showPaymentModal">Confirm</button>
        </div>
      </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true" ref="paymentModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="paymentModalLabel">Confirm Payment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" @click="hidePaymentModal">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="payWithMpesa" v-model="payWithMpesa">
              <label class="form-check-label" for="payWithMpesa">
                Pay with Mpesa
              </label>
            </div>
            <div v-if="payWithMpesa" class="form-group mt-3">
              <label for="phoneNumber">Phone Number</label>
              <input type="text" class="form-control" id="phoneNumber" v-model="phoneNumber">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="hidePaymentModal">Cancel</button>
            <button type="button" class="btn btn-primary" @click="confirmPurchase">Pay</button>
          </div>
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
      payWithMpesa: false,
      phoneNumber: '',
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
    showPaymentModal() {
      const modalElement = this.$refs.paymentModal;
      modalElement.classList.add('show');
      modalElement.style.display = 'block';
      modalElement.setAttribute('aria-modal', 'true');
      modalElement.removeAttribute('aria-hidden');
    },
    hidePaymentModal() {
      const modalElement = this.$refs.paymentModal;
      modalElement.classList.remove('show');
      modalElement.style.display = 'none';
      modalElement.removeAttribute('aria-modal');
      modalElement.setAttribute('aria-hidden', 'true');
    },
    async confirmPurchase() {
      if (this.payWithMpesa && !this.phoneNumber) {
        alert('Please enter your phone number.');
        return;
      }

      const amount = this.calculateTotal();

      if (this.payWithMpesa) {
        try {
          await axios.post('http://127.0.0.1:8000/payment/initiate', {
            phone_number: this.phoneNumber,
            amount: amount
          });
          alert('Payment initiated. Please check your phone to complete the payment.');
        } catch (error) {
          console.error('Error initiating payment:', error);
        }
      }

      this.hidePaymentModal();
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
