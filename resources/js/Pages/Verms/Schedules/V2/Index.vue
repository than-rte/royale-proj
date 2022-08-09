<template>
  <fragment>
    <b-background class="container is-fluid py-5 mb-5" color="info">
      <b-h3 color="info" light type="title" text="Schedules" />
      <b-h4 color="info" light type="subtitle" text="Manage your schedules here..." />
    </b-background>
    <div class="container my-6 is-fluid">
      <div class="mb-5">
        <div class="is-flex is-justify-content-flex-start is-align-items-center">
          <b-h5 light size="4" text="Scheduled Events" class="mr-4" />
          <b-button type="is-primary" icon-right="plus-lg" label="Add Event" />
        </div>
      </div>
      <div class="mb-5">
        <div class="columns">
          <div class="column is-12">
            <b-card>
              <b-card-content :style="{ width: '100%' }">
                <vk-calendar :events="events"></vk-calendar>
              </b-card-content>
            </b-card>
          </div>
        </div>
      </div>
    </div>
  </fragment>
</template>

<script>
import Verms from "@/Layouts/Verms.vue";
import GlobalComponents from "@/Components/Global";
import VkCalendar from "../components/VkCalendar.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
  layout: Verms,
  props: ["schedules", "queries"],
  components: {
    ...GlobalComponents,
    VkCalendar,
  },
  data() {
    return {};
  },
  methods: {},
  computed: {
    events: {
      get() {
        return this.schedules.length > 0
          ? this.schedules.map((schedule) => {
              const from = this.$moment(schedule.start_time);
              const to = this.$moment(schedule.end_time);
              const duration = this.$moment.duration(to.diff(from));

              return {
                extendedProps: {
                  id: schedule.id,
                  venue: schedule.venue.name,
                  event: schedule.event_name,
                  guest: schedule.guest_name,
                  duration: `${duration.asMinutes()}mins`,
                },
                start: schedule.start_time,
                end: schedule.end_time,
                color: schedule.venue.legend,
              };
            })
          : [];
      },
    },
  },
  created() {},
  mounted() {},
};
</script>

<style lang="scss" scoped></style>
