<template>
  <div class="container">
    <!-- Greeting and Profile Section -->
    <div class="row my-4">
      <div class="col-12 text-center">
        <p class="display-4">{{ greeting }}, {{ user.name }}!</p>
        <div v-if="user.profilePicture">
          <img :src="user.profilePicture" alt="User Image" class="rounded-circle" width="100">
        </div>
        <div v-else>
          <img src="../assets/images/user.png" alt="User Image" class="rounded-circle" width="100">
        </div>
      </div>
    </div>

    <!-- Filters Section -->
    <div class="row mt-4">
      <div class="col-md-4">
        <label for="eventFilter">Filter by:</label>
        <select v-model="filterType" id="eventFilter" class="form-select" @change="applyFilters">
          <option value="all">All Events</option>
          <option value="my">My Events</option>
          <option value="today">Today's Events</option>
          <!-- Add more filter options as needed -->
        </select>
      </div>
    </div>

    <!-- Events Listing -->
    <div class="row mt-4">
      <div v-for="(event, index) in filteredEvents" :key="index" class="col-sm-6 col-md-4 col-lg-3 mb-4">
        <div class="card h-100" @click="goToTicketInfo(event.id); viewEvent(event.id)">
          <div v-if="event.image">
            <img :src="event.image" class="card-img-top" alt="Event Image">
          </div>
          <div v-else>
            <img src="../assets/images/event poster.jpeg" class="card-img-top" alt="Event Image">
          </div>
          <div class="card-body">
            <h5 class="card-title">{{ event.name }}</h5>
            <DatePage :date="event.date"/>
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
import DatePage from '../assets/constants/DatePage.vue'

export default {
  data() {
    return {
      events: [],
      filteredEvents: [],
      filterType: 'all', // Default filter
      successMessage: 'Events fetched successfully!',
      errorMessage: 'Error fetching events. Please try again.',
      loading: false,
    };
  },
  computed: {
    ...mapState(['user']),
    greeting() {
      const hour = new Date().getHours();
      if (hour >= 5 && hour < 12) {
        return 'Good morning';
      } else if (hour >= 12 && hour < 18) {
        return 'Good afternoon';
      } else {
        return 'Good evening';
      }
    }
  },
  mounted() {
    this.getAllEvents();
  },
  methods: {
    async getAllEvents() {
      this.loading = true;
      try {
        const eventResponse = await axios.get('http://127.0.0.1:8000/events/byIndex');
        this.events = eventResponse.data.recent.concat(eventResponse.data.trending);
        this.applyFilters(); // Apply initial filters
        console.log("Event data:", eventResponse.data);
        this.loading = false; // Set loading to false after fetching events
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
      return event.user_id === this.user.userId; // Ensure userId exists in Vuex state
    },
    goToTicketInfo(eventId) {
      this.$router.push({ name: 'TicketInfo', params: { eventId } });
    },
    async viewEvent(eventId) {
      try {
        const response = await axios.post('http://127.0.0.1:8000/views/update', {
          event_id: eventId,
          user_id: this.user.id // Using Vuex state for user ID
        });
        console.log('View count updated successfully:', response.data);
      } catch (error) {
        console.error('Error updating view count:', error);
      }
    }
  },
  components: {
    DatePage
  }
};
</script>

<style scoped>
.text-center {
  text-align: center;
}

.card {
  position: relative;
  width: 100%;
  height: 100%;
  background-color: #000;
  display: flex;
  flex-direction: column;
  justify-content: end;
  padding: 12px;
  gap: 12px;
  border-radius: 8px;
  cursor: pointer;
  color: white;
  transition: transform 0.3s;
}

.card:hover {
  transform: scale(1.05);
}

.card::before {
  content: '';
  position: absolute;
  inset: 0;
  left: -5px;
  margin: auto;
  width: 100%;
  height: 100%;
  border-radius: 10px;
  background: linear-gradient(-45deg, #f6a926 0%, #07407b 100%);
  z-index: -10;
  pointer-events: none;
  transition: all 0.9s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.card::after {
  content: "";
  z-index: -1;
  position: absolute;
  inset: 0;
  background-color: #000;
  transform: translate3d(0, 0, 0) scale(0.95);
  filter: blur(20px);
}

.card:hover::after {
  filter: blur(30px);
}

.card:hover::before {
  transform: rotate(-90deg) scaleX(1.34) scaleY(0.77);
}

.heading {
  font-size: 20px;
  text-transform: capitalize;
  font-weight: 700;
}

.card p:not(.heading) {
  font-size: 14px;
}

.card p:last-child {
  color: #f6a926;
  font-weight: 600;
}


.event-date {
  font-size: 12px;
  color: #ccc;
  position: absolute;
  color:#f6a926 ;
  font-weight: 700;
  bottom: 8px;
  right: 12px;
}

.arrow-icon {
  font-size: 24px;
  cursor: pointer;
  transition: transform 0.3s;
}

.arrow-icon:hover {
  transform: scale(1.2);
}



</style>
