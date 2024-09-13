<template>
    <div class="event-date">
      <div class="calendar">
        <div class="calendar-header">
          <span class="day">{{ formatDate(date, 'DD') }}</span>
        </div>
        <div class="calendar-body">
          <span class="month">{{ formatDate(date, 'MMM') }}</span><br>
          <span class="year">{{ formatDate(date, 'YYYY') }}</span>
        </div>
      </div>
    </div>
  </template>
<script>
export default {
  props: {
    date: {
      type: String, // or Date if you're passing Date objects
      required: true,
    },
  },
  setup() {
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

    return {
      formatDate,
    };
  },
};
</script>

  <style scoped>
  .event-date {
    display: inline-block;
  }
  
  .calendar {
    width: 70px;
    height: 80px;
    background-color: #f7f7f7;
    border: 2px solid #ccc;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    color: #ccc;
  }
  
  .calendar-header {
    background-color: #f0f0f0;
    padding: 2px 0;
    border-bottom: 1px solid #ccc;
    font-weight: bold;
  }
  
  .calendar-body {
    padding: 5px 0;
  }
  
  .calendar .month {
    font-size: 20px;

  }
  
  .calendar .day {
    font-size: 13px;
    font-weight: bold;
  }
  
  .calendar .year {
    font-size: 10px;
    color: #777;
  }
  </style>
  