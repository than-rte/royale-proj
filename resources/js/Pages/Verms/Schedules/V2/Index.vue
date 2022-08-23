<template>
  <fragment>
    <b-background class="container is-fluid py-5 mb-5" color="info">
      <b-h3 color="info" light type="title" text="Schedules" />
      <b-h4 color="info" light type="subtitle" text="Manage your schedules here..." />
    </b-background>
    <div class="container my-6">
      <div class="mb-5">
        <div class="is-flex is-justify-content-flex-start is-align-items-center">
          <b-h5 light size="4" text="Scheduled Events" class="mr-4" />
          <b-button type="is-primary" icon-right="plus-lg" label="Add Event" />
          <div class="ml-auto is-flex is-justify-content-flex-start is-align-items-center">
            <span class="is-size-6 has-text-weight-semibold mr-2">View: </span>
            <div class="control">
              <b-select v-model="selected.view">
                <option value="all">All</option>
                <option v-for="(option, i) in options.views" :key="i" :value="option.value">
                  {{ option.text }}
                </option>
              </b-select>
            </div>
          </div>
        </div>
      </div>
      <div class="mb-5">
        <div class="columns">
          <div class="column is-7">
            <b-card>
              <b-card-content class="w-full">
                <div class="level">
                  <div class="level-left">
                    <div class="level-item">
                      <span class="is-size-7 has-text-weight-semibold mr-2">Show: </span>
                      <div class="control">
                        <b-select size="is-small" v-model="selected.show">
                          <option v-for="(option, i) in options.show" :key="i" :value="option.value">
                            {{ option.text }}
                          </option>
                        </b-select>
                      </div>
                    </div>
                  </div>
                  <div class="level-right">
                    <div class="level-item">
                      <span class="is-size-7 has-text-weight-semibold mr-2">Venues: </span>
                      <div class="control">
                        <b-select size="is-small" v-model="selected.venue">
                          <option value="all">All</option>
                          <option v-for="(option, i) in options.venues" :key="i" :value="option.value">
                            {{ option.text }}
                          </option>
                        </b-select>
                      </div>
                    </div>
                  </div>
                </div>
                <calendar-view
                  :events="events"
                  :selected-days="selectedDays"
                  :date.sync="calendar.date"
                  @dayClick="clickSelectDay"
                />
              </b-card-content>
            </b-card>
          </div>
          <div class="column is-5">
            <b-card>
              <b-card-header>
                <h5 class="card-header-title">
                  <b-icon icon="calendar" />
                  Selected Date
                </h5>
              </b-card-header>
              <b-card-content>
                <div>no event</div>
              </b-card-content>
            </b-card>
          </div>
        </div>
      </div>
    </div>
  </fragment>
</template>

<script>
import CalendarView from "../components/CalendarView.vue";
import Verms from "@/Layouts/Verms.vue";
import GlobalComponents from "@/Components/Global";
import VkCalendar from "../components/VkCalendar.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
  layout: Verms,
  props: ["schedules", "queries"],
  components: {
    CalendarView,
    ...GlobalComponents,
    VkCalendar,
  },
  data() {
    const today = this.$moment();
    let ddate = {
      month: parseInt(today.format("M")),
      year: parseInt(today.format("Y")),
    };
    return {
      selectedDays: [],
      days: {
        from: null,
        to: null,
      },
      selected: {
        date: null,
        show: "all",
        venue: "all",
        view: "calendar",
        day: null,
      },
      calendar: {
        date: ddate,
      },
      options: {
        show: [
          { text: "All", value: "all" },
          { text: "Pending", value: "pending" },
          { text: "Finished", value: "finished" },
          { text: "Canceled", value: "canceled" },
        ],
        venues: [],
        views: [
          { text: "Calendar", value: "calendar" },
          { text: "List", value: "list" },
        ],
      },
    };
  },
  methods: {
    clickSelectDay: function (day, date, attrs) {
      if (this.days.from === null && this.days.to === null) {
        // console.log('null');
        this.days.from = day;
        this.days.to = day;
        this.selectedDays = this.createSelectedDays(this.days.from, this.days.to);
      }

      if (this.days.to === day) {
        // console.log('to = day');
        this.days.from = day;
        this.days.to = day;
        this.selectedDays = this.createSelectedDays(this.days.from, this.days.to);
      } else if (this.days.from < day) {
        // console.log('from < day');
        this.days.to = day;
        this.selectedDays = this.createSelectedDays(this.days.from, this.days.to);
      } else {
        // console.log('last else');
        if (this.days.from === day) {
          this.days.to = day;
        }
        this.days.from = day;
        this.selectedDays = this.createSelectedDays(this.days.from, this.days.to);
      }
    },
    createSelectedDays: function (from = 0, to) {
      return [...Array(from === to ? 1 : to - from + 1).keys()].map((i) => i + from);
    },
  },
  computed: {
    events: {
      get() {
        return this.schedules.map((item) => {
          const from = this.$moment(item.start_time);
          const to = this.$moment(item.end_time);
          const duration = this.$moment.duration(to.diff(from));
          return {
            key: item.id,
            customData: {
              id: item.id,
              venue: item.venue.name,
              event: item.event_name,
              start_date: item.start_time,
              end_date: item.end_time,
              start: this.$moment(item.start_time).format("hh:mm:A"),
              end: this.$moment(item.end_time).format("hh:mm:A"),
              guest: item.guest_name,
              color: item.venue.legend,
              duration: `${duration.asMinutes()}mins`,
            },
            dates: {
              start: item.start_time,
              end: item.end_time,
            },
          };
        });
      },
    },
  },
  watch: {
    calendar: {
      handler(n) {
        console.log(n);
      },
      deep: true,
    },
    days: {
      handler(n) {
        console.log("days: ", n);
      },
      deep: true,
    },
    selectedDays(n) {
      console.log(n);
    },
  },
  created() {},
};
</script>
