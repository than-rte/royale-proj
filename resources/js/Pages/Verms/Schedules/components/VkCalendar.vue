<template>
  <vue-cal class="vuecal--blue-theme" :events="ev" style="height: 600px">
    <template #cell-content="{ cell, view, goNarrower, events }">
      <div :class="[view.id, 'vuecal__cell-date']" @click="goNarrower">
        <span class="clickable">
          {{ cell.content }}
        </span>
      </div>
      <span :class="['vuecal-events-count']" v-if="view.id === 'month' && events.length">
        {{ events.length }}
      </span>
      <span class="vuecal__no-event" v-if="['week', 'day'].includes(view.id) && !events.length"> Nothing here </span>
    </template>
  </vue-cal>
</template>

<script>
import VueCal from "vue-cal";
import "vue-cal/dist/vuecal.css";
export default {
  components: { VueCal },
  props: {
    events: {
      type: Array,
      default: [],
    },
  },
  data() {
    return {
      ev: [
        {
          start: "2022-08-12 10:35",
          end: "2022-08-12 11:30",
          title: "Doctor appointment",
        },
        {
          start: "2022-08-12 18:30",
          end: "2022-08-12 19:15",
          title: "Dentist appointment",
        },
        {
          start: "2022-08-13 18:30",
          end: "2022-08-13 20:30",
          title: "Crossfit",
        },
        {
          start: "2022-08-14 08:00",
          end: "2022-08-14 13:00",
          title: "Brunch with Jane",
        },
        {
          start: "2022-08-14 19:30",
          end: "2022-08-14 23:00",
          title: "Swimming lesson",
        },
      ],
    };
  },
};
</script>

<style lang="scss" scoped></style>
