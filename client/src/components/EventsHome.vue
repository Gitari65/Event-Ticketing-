<template>
  <div>
    <div class="row">
      <div class="col-md-4">
        <router-link to="/event/create" class="btn btn-primary">Create Event</router-link>
      </div>
    </div>

    <!-- Filters -->
    <div class="row mt-4">
      <div class="col-md-4">
        <label for="eventFilter">Filter by:</label>
        <select v-model="filterType" id="eventFilter" @change="applyFilters">
          <option value="all">All Events</option>
          <option value="my">My Events</option>
          <option value="today">Today's Events</option>
          <!-- Add more filter options as needed -->
        </select>
      </div>
    </div>

    <!-- Events Listing -->
    <div class="row mt-4">
      <div v-for="(event, index) in filteredEvents" :key="index" class="col-sm-4 col-md-4 col-lg-3 ">
        <div class="card" @click="goToTicketInfo(event.id)">
          <img src="../assets/images/event poster.jpeg" class="card-img-top" alt="Event Image">
          <div class="card-body">
            <h5 class="card-title">{{ event.name }}</h5>
            <p class="card-text">{{ event.venue }}</p>
            <p class="card-text">{{ event.location }}</p>
            <!-- Show edit icon if user is creator -->
            <router-link v-if="isUserCreator(event)" :to="`/edit/event/${event.id}`" class="btn btn-sm btn-outline-primary">Edit</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { mapState } from 'vuex';
import { useRouter } from 'vue-router';

export default {
  data() {
    return {
      events: [],
      filteredEvents: [],
      filterType: 'all', // Default filter
      successMessage: 'Events fetched successfully!',
      errorMessage: 'Error fetching events. Please try again.',
      loading: false
    };
  },
  setup(){
    const router=useRouter();
    return{
      router,
    }
  },
  computed: {
    ...mapState(['user'])
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
        this.applyFilters(); // Apply initial filters
        console.log("Event data:", eventResponse.data);
      } catch (error) {
        this.loading = false;
        this.errorMessage = 'Error fetching events';
        console.error('Error fetching events:', error);
      }
    },
    applyFilters() {
      let filteredEvents = [];
      switch (this.filterType) {
        case 'my': {
          console.log("Filtering 'My Events'");
          console.log("Stored user ID:", this.user.userId);
          filteredEvents = this.events.filter(event => this.isUserCreator(event));
           // Sort the filtered events by date
  filteredEvents.sort((b, a) => new Date(a.date) - new Date(b.date));
          break;
        }
        case 'today': {
          const today = new Date().toISOString().split('T')[0];
          filteredEvents = this.events.filter(event => event.date.startsWith(today));
          break;
        }
        default:
          filteredEvents = this.events;
      }
      console.log("Filtered events:", filteredEvents);
      this.filteredEvents = filteredEvents;
    },
    isUserCreator(event) {
      // Ensure this function is correctly checking the user ID
      console.log("Checking event:", event);
      console.log("Event user ID:", event.user_id, "Current user ID:", this.user.userId);
      return event.user_id === this.user.userId;
    },  goToTicketInfo(eventId){
      this.router.push({name:'TicketInfo',params:{eventId}})
    },
  }
};
</script>

<style scoped>
.card {
  margin-bottom: 20px;
 
}

</style>
