<template>
    <div>
        <!-- Greeting and Profile Section -->
        <div class="row mb-4">
            <div class="col-md-12 d-flex align-items-center justify-content-between">
                <div>
                    <p class="h4">{{ greeting }}, {{ user.name }}</p>
                </div>
                <div>
                    <img src="../assets/images/image.png" alt="User Image" class="rounded-circle user-image">
                </div>
            </div>
        </div>

        <!-- Recent Tickets Row -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h2>Recent Tickets</h2>
                <div class="row">
                    <div v-for="ticket in recentTickets" :key="ticket.id" class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ ticket.title }}</h5>
                                <p class="card-text">Status: {{ ticket.status }}</p>
                                <p class="card-text">Priority: {{ ticket.priority }}</p>
                                <p class="card-text">Created At: {{ new Date(ticket.created_at).toLocaleDateString() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trending Tickets Row -->
        <div class="row">
            <div class="col-md-12">
                <h2>Trending Tickets</h2>
                <div class="row">
                    <div v-for="ticket in trendingTickets" :key="ticket.id" class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ ticket.title }}</h5>
                                <p class="card-text">Status: {{ ticket.status }}</p>
                                <p class="card-text">Priority: {{ ticket.priority }}</p>
                                <p class="card-text">Created At: {{ new Date(ticket.created_at).toLocaleDateString() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { computed, ref, onMounted } from 'vue';
import { useStore } from 'vuex';

export default {
    name: 'DashboardComponent',
    setup() {
        const store = useStore();

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

        const recentTickets = ref([]);
        const trendingTickets = ref([]);

        onMounted(() => {
            fetchTickets();
        });

        const fetchTickets = async () => {
            try {
                const response = await fetch('/api/tickets'); // Adjust the endpoint as needed
                const data = await response.json();
                recentTickets.value = data.recent;
                trendingTickets.value = data.trending;
            } catch (error) {
                console.error('Error fetching tickets:', error);
            }
        };

        return {
            user,
            greeting,
            recentTickets,
            trendingTickets,
        };
    },
};
</script>
<style scoped>
/* Center and size the user image */
.user-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
}
</style>
