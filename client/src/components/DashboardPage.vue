<script setup lang="ts">
import { computed, ref, onMounted } from 'vue';
import { useStore } from 'vuex';
import axios from 'axios';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
  <div class="container">
    <!-- Greeting and Profile Section -->
    <div class="row my-4">
      <div class="col-md-12 text-center">
        <p class="display-4 animate__animated animate__fadeInDown">{{ greeting }}, {{ user.name }}!</p>
        <img :src="user.profilePicture" alt="User Image" class="rounded-circle animate__animated animate__fadeInUp" width="150">
      </div>
    </div>

    <!-- Trending Events Section -->
    <div class="row my-4">
      <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h3 class="animate__animated animate__fadeInLeft">Trending Events</h3>
        <div @click="redirectToEvents" class="arrow-container animate__animated animate__bounceInRight">
          <FontAwesomeIcon icon="fa-sharp fa-solid fa-arrow-right" />
        </div>
      </div>
      <div v-if="trendingEvents.length > 0" class="row">
        <div v-for="event in trendingEvents" :key="event.id" class="col-sm-2 col-md-5 col-lg-6 mb-4">
          <div class="card h-100 animate__animated animate__fadeInUp" @click="viewEvent(event.id)">
            <img :src="event.image" class="card-img-top" alt="Event Image">
            <div class="card-body">
              <h5 class="card-title">{{ event.title }}</h5>
              <p class="card-text">{{ event.description }}</p>
              <p class="event-date">{{ formatDate(event.date) }}</p>
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
      <div class="col-md-12 d-flex justify-content-between align-items-center">
        <h3 class="animate__animated animate__fadeInLeft">Recent Events</h3>
        <div @click="redirectToEvents" class="arrow-container animate__animated animate__bounceInRight">
          <FontAwesomeIcon icon="fa-sharp fa-solid fa-arrow-right" />
        </div>
      </div>
      <div v-if="recentEvents.length > 0" class="row">
        <div v-for="event in recentEvents" :key="event.id" class="col-sm-2 col-md-5 col-lg-6 mb-4">
          <div class="card h-100 animate__animated animate__fadeInUp" @click="viewEvent(event.id)">
            <img :src="event.image" class="card-img-top" alt="Event Image">
            <div class="card-body">
              <h5 class="card-title">{{ event.title }}</h5>
              <p class="card-text">{{ event.description }}</p>
              <p class="event-date">{{ formatDate(event.date) }}</p>
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
export default {
  name: 'DashboardPage',
  methods: {
    async viewEvent(eventId) {
      try {
        await axios.post('http://127.0.0.1:8000/views/update', {
          event_id: eventId,
          user_id: this.$store.state.user.id
        });
        console.log('View count updated successfully');
      } catch (error) {
        console.error('Error updating view count:', error);
      }
    },
    formatDate(date) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(date).toLocaleDateString(undefined, options);
    },
    redirectToEvents() {
      this.$router.push('/events');
    }
  },
  setup() {
    const store = useStore();
    const trendingEvents = ref([]);
    const recentEvents = ref([]);

    onMounted(async () => {
      try {
        const response = await axios.get('http://127.0.0.1:8000/events/byIndex');
        trendingEvents.value = response.data.trending;
        recentEvents.value = response.data.recent;
      } catch (error) {
        console.error('Error fetching events:', error);
      }
    });

    const user = computed(() => store.state.user);

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
@import 'animate.css';

.text-center {
  text-align: center;
}

.card {
  position: relative;
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
  transform: scale(1.05) rotate(3deg);
}

.card::before {
  content: '';
  position: absolute;
  inset: 0;
  left: -5px;
  margin: auto;
  width: 200px;
  height: 264px;
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
  background: linear-gradient(-45deg, #f6a926 0%, #07407b 100%);
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
  bottom: 8px;
  right: 12px;
}

.arrow-container {
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.arrow-container:hover {
  transform: translateX(5px) scale(1.1);
}

.arrow-container .fa-arrow-right {
  font-size: 1.5rem;
  color: #007bff;
  transition: transform 0.3s ease, color 0.3s ease;
}

.arrow-container:hover .fa-arrow-right {
  color: #0056b3;
}
</style>
