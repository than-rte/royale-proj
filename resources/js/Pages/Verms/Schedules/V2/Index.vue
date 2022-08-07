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
              <b-card-content>
                <div class="level" style="width: 100%">
                  <div class="level-left">
                    <div class="level-item">
                      <b-button type="is-light" size="is-small" label="Today" :disabled="isToday" @click="toToday" />
                    </div>
                  </div>
                  <div class="level-right">
                    <div class="level-item">
                      <b-text class="mr-2" size="7" text="Venue:" />
                      <b-field grouped group-multiline>
                        <div class="control">
                          <b-select v-model="show" size="is-small" type="is-primary">
                            <option v-for="(option, i) in showOptions" :key="i" :value="option.value">
                              {{ option.text }}
                            </option>
                          </b-select>
                        </div>
                      </b-field>
                    </div>
                    <div class="level-item">
                      <b-text class="mr-2" size="7" text="Show:" />
                      <b-field grouped group-multiline>
                        <div class="control">
                          <b-select v-model="show" size="is-small" type="is-primary">
                            <option v-for="(option, i) in showOptions" :key="i" :value="option.value">
                              {{ option.text }}
                            </option>
                          </b-select>
                        </div>
                      </b-field>
                    </div>
                  </div>
                </div>
                <vc-calendar
                  ref="calendar"
                  :from-page.sync="date"
                  :attributes="attrs"
                  :masks="masks"
                  class="custom-calendar"
                  disable-page-swipe
                  is-expanded
                >
                  <template #day-content="{ day, attributes }">
                    <div class="vc-day-panel">
                      <span>{{ day.day }}</span>
                      <div v-if="hasAttrs(attributes)" class="vc-day-events">
                        <div
                          class="vc-day-event"
                          v-for="attr in attributes"
                          :key="attr.key"
                          :style="{ backgroundColor: attr.customData.color }"
                        >
                          <div class="has-text-left">
                            <div class="mb-1">
                              <p class="text-bold font-small">VENUE</p>
                              <p class="">{{ attr.customData.venue }}</p>
                            </div>
                            <div class="mb-1">
                              <p class="text-bold font-small">EVENT</p>
                              <p class="">{{ attr.customData.event }}</p>
                            </div>
                            <div class="mb-1">
                              <p class="text-bold font-small">TIME</p>
                              <p class="">
                                {{ attr.customData.start }} - {{ attr.customData.end }}
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </template>
                </vc-calendar>
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
import { Inertia } from "@inertiajs/inertia";
import EventView from "../components/EventView.vue";

export default {
  layout: Verms,
  props: ["schedules", "queries"],
  components: {
    ...GlobalComponents,
    EventView,
  },
  data() {
    return {
      // loaders
      isFullPage: false,
      // show filter
      show: "all",
      showOptions: [
        { text: "All", value: "all" },
        { text: "Pending", value: "pending" },
        { text: "Finished", value: "finished" },
        { text: "Cancelled", value: "cancelled" },
      ],
      // calendar
      masks: {
        weekdays: "WWW",
      },
      date: null,
    };
  },
  methods: {
    hasAttrs(attrs) {
      return attrs !== undefined && Object.entries(attrs).length > 0;
    },
    toToday() {
      const date = this.$moment().format("MM-YYYY");
      Inertia.visit(route("verms.v2.schedules.index", { date }), { preserveScroll: true });
    },
  },
  computed: {
    attrs: {
      get() {
        return this.schedules.length > 0
          ? this.schedules.map((schedule) => {
              const from = this.$moment(schedule.start_time);
              const to = this.$moment(schedule.end_time);
              const duration = this.$moment.duration(to.diff(from));
              return {
                key: schedule.id,
                customData: {
                  id: schedule.id,
                  venue: schedule.venue.name,
                  event: schedule.event_name,
                  start_date: schedule.start_time,
                  end_date: schedule.end_time,
                  start: this.$moment(schedule.start_time).format("hh:mmA"),
                  end: this.$moment(schedule.end_time).format("hh:mmA"),
                  guest: schedule.guest_name,
                  color: schedule.venue.legend,
                  duration: `${duration.asMinutes()}mins`,
                },
                dates: {
                  start: schedule.start_time,
                  end: schedule.end_time,
                },
              };
            })
          : [];
      },
    },
    isToday: {
      get() {
        return this.$moment({ month: this.date.month - 1, year: this.date.year }).isSame(this.$moment(), "month");
      },
    },
  },
  created() {
    const dates = this.queries.date.split("-").map((item) => {
      return parseInt(item);
    });
    this.date = {
      month: dates[0],
      year: dates[1],
    };
  },
  mounted() {
    this.$watch("date", {
      handler(n) {
        const loader = this.$buefy.loading.open({
          container: this.isFullPage ? null : this.$refs.calendar.$el,
        });
        const date = this.$moment({ month: n.month - 1, year: n.year }).format("MM-YYYY");
        Inertia.visit(route("verms.v2.schedules.index", { date }), {
          preserveScroll: true,
          onFinish: () => {
            loader.close();
          },
        });
      },
      deep: true,
    });
  },
};
</script>

<style lang="scss" scoped>
.text-bold {
  font-weight: 700;
}

.font-small {
  font-size: 0.75rem;
}

.font-x-small {
  font-size: 0.5rem;
}

::-webkit-scrollbar {
  width: 0px;
}
::-webkit-scrollbar-track {
  display: none;
}
::v-deep .custom-calendar.vc-container {
  --day-border: 1px solid #b8c2cc;
  --day-border-highlight: 1px solid #b8c2cc;
  --day-width: 148px;
  --day-height: 148px;
  --weekday-bg: #f8fafc;
  --weekday-border: 1px solid #eaeaea;
  border-radius: 0;
  width: 100%;
  & .vc-header {
    background-color: #f1f5f8;
    padding: 10px 0;
  }
  & .vc-weeks {
    padding: 0;
  }
  & .vc-weekday {
    background-color: var(--weekday-bg);
    border-bottom: var(--weekday-border);
    border-top: var(--weekday-border);
    padding: 5px 0;
  }

  & .vc-day {
    // padding: 0 5px 3px 5px;
    text-align: left;
    height: var(--day-height);
    min-width: var(--day-width);
    background-color: white;
    &.weekday-1,
    &.weekday-7 {
      background-color: #eff8ff;
    }
    &:not(.on-bottom) {
      border-bottom: var(--day-border);
      &.weekday-1 {
        border-bottom: var(--day-border-highlight);
      }
    }
    &:not(.on-right) {
      border-right: var(--day-border);
    }
  }
  & .vc-day-dots {
    margin-bottom: 5px;
  }

  & .vc-day-panel {
    padding: 0.25rem;
    display: flex;
    flex-direction: column;
    height: 100%;
    z-index: 10;
    overflow: hidden;
    cursor: pointer;
  }
  & .vc-day-events {
    padding-top: 0.5rem;
    display: flex;
    flex-grow: 1;
    overflow: auto;
    flex-direction: column;
  }

  & .vc-event-dot {
    margin: 0 2px;
    height: 12px;
    width: 12px;
    border-radius: 50%;
  }

  & .vc-day-event {
    margin-bottom: 0.25rem;
    padding: 4px;
    border-radius: 2px;
  }
}
</style>
