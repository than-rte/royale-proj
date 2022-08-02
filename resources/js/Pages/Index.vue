<template>
  <fragment>
    <div class="container my-6" style="height: 600px">
      <vue-cal
        :selected-date="today"
        :time-from="8 * 60"
        :time-step="30"
        :disable-views="['years', 'year', 'month']"
        :events="events"
      >
      </vue-cal>
    </div>
  </fragment>
</template>

<script>
export default {
  components: { VueCal: vuecal },
  data() {
    return {
      today: this.$moment(),
      stickySplitLabels: false,
      minCellWidth: 400,
      minSplitWidth: 0,
      splitDays: [
        // The id property is added automatically if none (starting from 1), but you can set a custom one.
        // If you need to toggle the splits, you must set the id explicitly.
        { id: 1, class: "mom", label: "Mom" },
        { id: 2, class: "dad", label: "Dad", hide: false },
        { id: 3, class: "kid1", label: "Kid 1" },
        { id: 4, class: "kid2", label: "Kid 2" },
        { id: 5, class: "kid3", label: "Kid 3" },
        { id: 6, class: "kid3", label: "Kid 3" },
        { id: 7, class: "kid3", label: "Kid 3" },
        { id: 8, class: "kid3", label: "Kid 3" },
        { id: 9, class: "kid3", label: "Kid 3" },
      ],
      events: [
        {
          start: "2022-07-16 10:36",
          end: "2022-07-16 11:30",
          // You can also define event dates with Javascript Date objects:
          // start: new Date(2018, 11 - 1, 16, 10, 30),
          // end: new Date(2018, 11 - 1, 16, 11, 30),
          title: "Doctor appointment",
          content: '<i class="bi-hospital">local_hospital</i>',
          class: "health",
        },
      ],
    };
  },
  methods: {
    log: function (e) {
      console.log(e);
      console.log("was clicked");
    },
  },
};
</script>

<style scoped>
.navbar-item.is-active {
  color: #7957d5;
}
</style>
