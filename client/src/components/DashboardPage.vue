<template>
    <div class="container">
      <!-- Greeting and Profile Section -->
      <div class="row my-4">
        <div class="col-md-12 text-center">
          <p class="display-4">{{ greeting }}, {{ user.name }}!</p>
          <img :src="user.profilePicture" alt="User Image" class="rounded-circle" width="150">
        </div>
      </div>
  
      <!-- Trending Events Section -->
      <div class="row my-4">
        <div class="col-md-12">
          <h3>Trending Events</h3>
        </div>
        <div v-if="trendingEvents.length > 0">
          <div v-for="event in trendingEvents" :key="event.id" class="col-md-3 mb-4">
            <div class="card h-100" @click="viewEvent(event.id)">
              <img :src="event.image" class="card-img-top" alt="Event Image">
              <div class="card-body">
                <h5 class="card-title">{{ event.title }}</h5>
                <p class="card-text">{{ event.description }}</p>
              </div>
            </div>
          </div>
        </div>
        <div v-else>
          <p>No trending events available.</p>
        </div>
      </div>
  
      <!-- Recent Events Section -->
      <div class="row my-4">
        <div class="col-md-12">
          <h3>Recent Events</h3>
        </div>
        <div v-if="recentEvents.length > 0">
          <div v-for="event in recentEvents" :key="event.id" class="col-md-3 mb-4">
            <div class="card h-100" @click="viewEvent(event.id)">
              <img :src="event.image" class="card-img-top" alt="Event Image">
              <div class="card-body">
                <h5 class="card-title">{{ event.title }}</h5>
                <p class="card-text">{{ event.description }}</p>
              </div>
            </div>
          </div>
        </div>
        <div v-else>
          <p>No recent events available.</p>
        </div>
      </div>
    </div>
  </template>
<script>
import { computed, ref, onMounted } from 'vue';
import axios from 'axios';
import { useStore } from 'vuex';

export default {
  name: 'DashboardPage',
  methods:{
    async viewEvent(eventId) {
      await axios.post('http://127.0.0.1:8000/views/update', {
        event_id: eventId,
        user_id: this.$store.state.user.id // Assuming user ID is stored in Vuex
      })
      .then(response => {
        console.log('View count updated successfully:', response.data);
      })
      .catch(error => {
        console.error('Error updating view count:', error);
      });
    },
  },
  setup() {
    const store = useStore();
    const trendingEvents = ref([]);
    const recentEvents = ref([]);

    // Fetch events data on component mount
    onMounted(async () => {
      try {
        const response = await axios.get('http://127.0.0.1:8000/events/byIndex'); // Endpoint for fetching events
        trendingEvents.value = response.data.trending;
        recentEvents.value = response.data.recent;
      } catch (error) {
        console.error('Error fetching events:', error);
      }
    });

    // Compute the user from Vuex state
    const user = computed(() => store.state.user);

    // Compute the greeting based on the current time
    const greeting = computed(() => {
      const hour = new Date().getHours();
      if (hour >= 5 && hour < 12) {
        return 'Good morning';
      } else if (hour >= 12 && hour < 18) {
        return 'Good afternoon';
      } else {
        return 'Good evening';
      }
    });

    // // Method to increase view count when an event is clicked
    // const increaseView = async (eventId) => {
    //   try {
    //     await axios.post(`/api/events/${eventId}/view`, {
    //       user_id: user.value.id
    //     });
    //   } catch (error) {
    //     console.error('Error increasing view count:', error);
    //   }
    // };

    return {
      user,
      greeting,
      trendingEvents,
      recentEvents,
    
    };
  }
};
</script>
<style scoped>
/* Center the greeting text and image */
.text-center {
  text-align: center;
}

/* Style the cards */
.card {
  cursor: pointer;
  transition: transform 0.3s;
}

.card:hover {
  transform: scale(1.05);
}

/* Style the user image */
.user-image {
  border-radius: 50%;
  margin-top: 20px;
}
</style>
  