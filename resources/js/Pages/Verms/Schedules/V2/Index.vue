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
                      <b-button
                        class="ml-2"
                        size="is-small"
                        type="is-light"
                        label="This week"
                        @click="clickSelectWeek"
                        :disabled="isThisWeek"
                      />
                    </div>
                  </div>
                  <div class="level-right">
                    <div class="level-item">
                      <span class="is-size-7 has-text-weight-semibold mr-2">Venues: </span>
                      <div class="control">
                        <b-select size="is-small" v-model="selected.venue">
                          <option value="all">All</option>
                          <option v-for="option in venues" :key="option.id" :value="option.id">
                            {{ option.name }}
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
                <div v-if="highlights.length > 0">
                  <event-view v-for="highlight in highlights" :key="highlight.id" :event="highlight" />
                </div>
                <div v-else>no events</div>
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
import { getMatchRange } from "@/Utils/common";
import EventView from "../components/EventView.vue";

export default {
  layout: Verms,
  props: ["venues", "schedules", "queries"],
  components: {
    ...GlobalComponents,
    CalendarView,
    EventView,
    VkCalendar,
  },
  data() {
    const today = this.$moment();
    let ddate = {
      month: parseInt(today.format("M")),
      year: parseInt(today.format("Y")),
    };
    return {
      selectedEvents: [],
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
      if (this.isThisWeek) {
        this.days.from = day;
        this.days.to = day;
        this.selectedDays = this.createSelectedDays(this.days.from, this.days.to);
      } else {
        const { from, to } = getMatchRange(this.days.from, this.days.to, day);
        this.days.from = from;
        this.days.to = to;
        this.selectedDays = this.createSelectedDays(from, to);
      }
    },

    clickSelectWeek() {
      const fromDate = this.$moment().startOf("week");
      this.days.from = parseInt(fromDate.format("D"));
      this.days.to = parseInt(this.$moment(fromDate).add(6, "days").format("D"));
      this.selectedDays = this.createSelectedDays(this.days.from, this.days.to);
    },
    createSelectedDays: function (from = 0, to) {
      return [...Array(from === to ? 1 : to - from + 1).keys()].map((i) => i + from);
    },
  },
  computed: {
    isThisWeek: {
      get() {
        const fromDate = this.$moment().startOf("week");
        const from = parseInt(fromDate.format("D"));
        const to = parseInt(this.$moment(fromDate).add(6, "days").format("D"));
        return from === this.days.from && to === this.days.to ? true : false;
      },
    },
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
    highlights: {
      get() {
        const filteredEvents = this.schedules.filter((item) => {
          const month = this.$moment({ month: this.calendar.date.month - 1, year: this.calendar.date.year });
          const startDay = parseInt(this.$moment(item.start_time).format("D"));
          const toDay = parseInt(this.$moment(item.end_time).format("D"));

          if (this.$moment(item.start_time).isSame(month, "month") && this.$moment(item.end_time).isSame(month, "month") ) {
            return this.selectedDays.includes(startDay) || this.selectedDays.includes(toDay);
          }

          if (this.$moment(item.start_time).isSame(month, "month")) {
            return this.selectedDays.includes(startDay);
          }

          if (this.$moment(item.end_time).isSame(month, "month")) {
            return this.selectedDays.includes(toDay);
          }
        });

        return filteredEvents.map((item) => {
          const from = this.$moment(item.start_time);
          const to = this.$moment(item.end_time);
          const duration = this.$moment.duration(to.diff(from));
          return {
            id: item.id,
            venue: item.venue.name,
            event: item.event_name,
            day: this.$moment(item.start_time).format("ll"),
            start: this.$moment(item.start_time).format("hh:mm:A"),
            end: this.$moment(item.end_time).format("hh:mm:A"),
            guest: item.guest_name,
            color: item.venue.legend,
            duration: `${duration.asMinutes()}mins`,
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
  },
  created() {
    console.log(this.$moment().startOf("week"));
  },
};
</script>
