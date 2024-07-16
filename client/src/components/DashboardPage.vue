<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <p>{{ greeting }}, {{ user.name }}</p>
                <img src="../assets/images/image.png" alt="User Image" class="user-image">
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue';
import { useStore } from 'vuex';

export default {
    name: 'GreetingsComponent',
    setup() {
        const store = useStore();

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

        return {
            user,
            greeting,
        };
    },
};
</script>

<style scoped>
/* Add your component-specific styles here */
</style>
