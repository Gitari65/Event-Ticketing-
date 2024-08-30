<template>
  <div class="container">
    <!-- Greeting and Profile Section -->
    <div class="row my-4">
      <div class="col-md-12 text-center">
        <p class="display-4">{{ greeting }}, {{ user.name }}!</p>
        <div v-if="user.profilePicture">
          <img :src="user.profilePicture" alt="User Image" class="rounded-circle" width="100">
        </div>
      
        <div v-else>
          <img src="../assets/images/user.png" alt="User Image" class="rounded-circle" width="100">
        </div>
      </div>
    </div>

    <!-- Trending Events Section -->
    <div class="row my-4">
      <div class="col-md-12">
        <h3>Trending Events</h3>
      </div>
      <div v-if="trendingEvents.length > 0" class="d-flex flex-row flex-nowrap overflow-hidden">
        <div v-for="event in trendingEvents" :key="event.id" class="col-sm-6 col-md-4 col-lg-2 mb-4">
          <div class="card h-100" @click="viewEvent(event.id)">
            <div v-if="event.image">
              <img :src="event.image" class="card-img-top" alt="Event Image">
            </div>
            <div v-else>
              <img src="../assets/images/eventposter.jpeg" class="card-img-top" alt="Event Image">
            </div>
            <div class="card-body">
              <h5 class="card-title">{{ event.title }}</h5>
              <div class="event-date">
                <span class="day">{{ formatDate(event.date, 'DD') }}</span>
                <span class="month">{{ formatDate(event.date, 'MMM') }}</span>
                <span class="year">{{ formatDate(event.date, 'YYYY') }}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-auto align-self-center">
          <FontAwesomeIcon 
            icon="fa-solid fa-arrow-right"
            class="arrow-icon"
            @click="goToEvents"
          />
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
      <div v-if="recentEvents.length > 0" class="d-flex flex-row flex-nowrap overflow-hidden">
        <div v-for="event in recentEvents" :key="event.id" class="col-sm-6 col-md-4 col-lg-2 mb-4">
          <div class="card h-100" @click="viewEvent(event.id)">
            <div v-if="event.image">
              <img :src="event.image" class="card-img-top" alt="Event Image">
            </div>
            <div v-else>
              <img src="../assets/images/eventposter.jpeg" class="card-img-top" alt="Event Image">
            </div>
            <div class="card-body">
              <h5 class="card-title">{{ event.title }}</h5>
              <p class="card-text">{{ event.description }}</p>
              <div class="event-date">
                <span class="day">{{ formatDate(event.date, 'DD') }}</span>
                <span class="month">{{ formatDate(event.date, 'MMM') }}</span>
                <span class="year">{{ formatDate(event.date, 'YYYY') }}</span>
              </div>

            </div>
          </div>
        </div>
        <div class="col-auto align-self-center">
          <FontAwesomeIcon 
            icon="fa-solid fa-arrow-right"
            class="arrow-icon"
            @click="goToEvents"
          />
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
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faArrowRight } from '@fortawesome/free-solid-svg-icons';

library.add(faArrowRight);
import axios from 'axios';
import { useStore } from 'vuex';

export default {
  name: 'DashboardPage',
  components: {
    FontAwesomeIcon,
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
        console.log('Trending events:', trendingEvents.value);
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

    const viewEvent = async (eventId) => {
      await axios.post('http://127.0.0.1:8000/views/update', {
        event_id: eventId,
        user_id: store.state.user.id
      })
      .then(response => {
        console.log('View count updated successfully:', response.data);
      })
      .catch(error => {
        console.error('Error updating view count:', error);
      });
    };

    const formatDate = (date, format) => {
         const newDate = new Date(date);

          switch (format) {
            case 'DD': {
              return newDate.getDate().toString().padStart(2, '0'); // Day of the month with leading zero
            }
            case 'MMM': {
              return newDate.toLocaleString('default', { month: 'short' }); // Short month name (e.g., Jan, Feb)
            }
            case 'YYYY': {
              return newDate.getFullYear(); // Full year
            }
            default: {
              const options = { year: 'numeric', month: 'long', day: 'numeric' };
              return newDate.toLocaleDateString(undefined, options); // Default format
            }
          }
    };



    const goToEvents = () => {
      this.$router.push('/events');
    };

    return {
      user,
      greeting,
      trendingEvents,
      recentEvents,
      viewEvent,
      formatDate,
      goToEvents
    };
  }
};
</script>

<style scoped>
.text-center {
  text-align: center;
}

.card {
  position: relative;
  width: 190px;
  height: 254px;
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
.event-date {
  text-align: center;
  background: linear-gradient(-45deg, #f7f5f5 0%, #07407b 100%);
  border-radius: 50%;
  color:#f6a926 ;

  width: 60%;

}

.event-date .day {
  font-size: 2rem; /* Larger font for the day */
  display: block;
}

.event-date .month {
  font-size: 1.2rem; /* Smaller font for the month */
  display: block;
}

.event-date .year {
  font-size: 0.8rem; /* Smallest font for the year */
  display: block;
}

</style>
