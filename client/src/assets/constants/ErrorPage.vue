<template>
  <div class="error-page">
    <div class="icon">&#128543;</div>
    <div class="message">{{ message }}</div>
    <button @click="hidePage" class="ok-button">OK</button>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      required: true
    }
  },
  methods: {
    hidePage() {
      this.$emit('hide');
    }
  }
};
</script>

<style scoped>
.error-page {
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #ef9a9a; /* Light red */
  color: #333;
  padding: 20px;
}

.icon {
  font-size: 48px;
  margin-right: 20px;
}

.message {
  font-size: 20px;
}

.ok-button {
  background-color: #fff;
  color: #333;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
}
</style>
