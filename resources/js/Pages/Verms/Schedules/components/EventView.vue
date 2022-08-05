<template>
  <div class="has-background-light p-2 mb-4">
    <div v-for="(item, i) in items">
      <p v-if="item.label === 'Time:'">
        <span class="has-text-weight-semibold">{{ item.label }} </span>
        {{ item.start }} - {{ item.end }}
      </p>
      <p v-else>
        <span class="has-text-weight-semibold">{{ item.label }} </span>
        {{ item.name }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  props: ["event"],
  computed: {
    items: {
      get() {
        return [
          {
            label: "Event:",
            name: this.event.event,
          },
          {
            label: "Venue:",
            name: this.event.venue,
          },
          {
            label: "Guest Name:",
            name: this.event.guest,
          },
          {
            label: "Time:",
            start: this.event.start,
            end: this.event.end,
          },
          {
            label: "Duration:",
            name: this.event.duration,
          },
        ];
      },
    },
  },
};
</script>

<style lang="scss" scoped></style>
