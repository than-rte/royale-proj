<template>
  <fragment>
    <Head>
      <title>VERMS | Schedules</title>
      <meta name="description" content="manage schedules..." />
    </Head>
    <b-background class="container is-fluid py-5 mb-5" color="info">
      <b-h3 color="info" light type="title" text="Schedules" />
      <b-h4 color="info" light type="subtitle" text="Manage your schedules here..." />
    </b-background>
    <div class="container my-6">
      <div class="mb-5">
        <b-h5 light size="4" class="mb-2"> Pending events this week </b-h5>
        <b-h6 light size="5" class="mb-4"> From "date" to "date"</b-h6>
        <b-table :data="false ? [] : data" striped hoverable>
          <b-table-column field="event" label="Event" v-slot="props"> </b-table-column>
          <b-table-column field="venue" label="Venue" v-slot="props"> </b-table-column>
          <b-table-column field="from" label="From" v-slot="props"> </b-table-column>
          <b-table-column field="to" label="To" v-slot="props"> </b-table-column>
          <b-table-column field="duration" label="Duration" v-slot="props"> </b-table-column>
          <template #empty>
            <div class="has-text-centered">No pending events this week</div>
          </template>
        </b-table>
      </div>
      <div class="is-flex mb-5 is-align-items-center">
        <b-h5 light size="4" class="mr-4">Schedules</b-h5>
        <b-button size="is-normal" type="is-primary" icon-pack="bi" icon-right="plus-lg" @click="toCreate">
          Add Event
        </b-button>
        <div class="ml-auto is-flex">
          <div class="is-flex is-align-items-center">
            <span class="has-text-weight-semibold mr-2">
              <b-icon pack="bi" icon="view-list"></b-icon>
              View:
            </span>
            <b-field grouped group-multiline>
              <b-select size="is-normal" v-model="view" type="is-primary">
                <option v-for="(option, i) in viewOptions" v-bind:value="option.value" :key="i">
                  {{ option.text }}
                </option>
              </b-select>
            </b-field>
          </div>
        </div>
      </div>

      <!-- calendar -->
      <div v-if="view === 'calendar'">
        <div class="columns">
          <!-- calendar panel -->
          <div class="column is-7">
            <b-card>
              <b-card-content>
                <div class="level" style="width: 100%">
                  <div class="level-left">
                    <div class="level-item">
                      <div class="control">
                        <b-button type="is-light" size="is-small" @click="toToday" :disabled="isMonthToday"
                          >Today</b-button
                        >
                      </div>
                    </div>
                    <div class="level-item">
                      <form>
                        <b-field label-position="on-border" label="Select date from">
                          <b-datepicker
                            v-model="toDate"
                            placeholder="Click to select..."
                            icon="calendar"
                            icon-right-clickable
                            trap-focus
                            size="is-small"
                          >
                          </b-datepicker>
                        </b-field>
                      </form>
                    </div>
                    <div class="level-item">
                      <form>
                        <b-field label-position="on-border" label="Select date to">
                          <b-datepicker
                            v-model="toDate"
                            placeholder="Click to select..."
                            icon="calendar"
                            icon-right-clickable
                            trap-focus
                            size="is-small"
                          >
                          </b-datepicker>
                        </b-field>
                      </form>
                    </div>
                  </div>
                  <div class="level-right">
                    <div class="level-item">
                      <b-text class="mr-2" size="7" text="Show:" />
                      <b-field grouped group-multiline>
                        <div class="control">
                          <b-select size="is-small" v-model="filter" type="is-primary">
                            <option v-for="(option, i) in filterOptions" v-bind:value="option.value" :key="i">
                              {{ option.text }}
                            </option>
                          </b-select>
                        </div>
                      </b-field>
                    </div>
                  </div>
                </div>
                <vc-calendar
                  ref="element"
                  class="custom-calendar max-w-full"
                  :masks="masks"
                  :attributes="vcAttributes"
                  disable-page-swipe
                  is-expanded
                  :from-page.sync="date"
                >
                  <template v-slot:day-content="{ day, attributes }">
                    <div
                      class="p-1 is-flex is-flex-direction-column h-full z-10 overflow-hidden is-clickable"
                      style="height: 100%; z-index: 10; overflow: hidden"
                      :class="[isSelected === day.day && 'is-vc-selected', isToday(day.date) && 'is-vc-today']"
                      @click="dayClick(attributes, day.day, day.date)"
                    >
                      <span class="day-label text-sm text-gray-900">{{ day.day }}</span>

                      <div
                        v-if="attributes !== undefined && Object.entries(attributes).length !== 0"
                        class="pt-2 is-flex is-flex-grow-1 overflow-y-auto overflow-x-auto"
                        style="overflow: auto"
                      >
                        <div
                          v-for="attr in attributes"
                          :key="attr.key"
                          class="text-xs leading-tight rounded-sm p-1 mt-0 mb-1 xcircle"
                          :style="{ backgroundColor: attr.customData.color }"
                        ></div>
                      </div>
                    </div>
                  </template>
                </vc-calendar>
              </b-card-content>
            </b-card>
          </div>
          <!-- end of calendar panel -->
          <!-- event display panel -->
          <div class="column is-5">
            <b-card style="height: 100%">
              <b-card-header>
                <b-h5 light class="card-header-title">
                  <b-icon icon="calendar" class="mr-1"></b-icon>
                  {{ highlightedDay }}
                </b-h5>
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
      <!-- end of calendar -->

      <div v-if="view === 'table'"></div>
    </div>
  </fragment>
</template>

<script>
import VueCal from "vue-cal";
import "vue-cal/dist/drag-and-drop";
import { Head, Link } from "@inertiajs/inertia-vue";
import Verms from "@/Layouts/Verms.vue";
import GlobalComponents from "@/Components/Global";
import CreateModal from "./CreateModal.vue";
import { Inertia } from "@inertiajs/inertia";
import EventView from "./components/EventView.vue";
import { isObjEmpty, hasProp } from "@/Utils/common";
// import { isObjEmpty, hasProp } from "@/Utils/schedules";
export default {
  layout: Verms,
  props: ["schedules", "month", "year"],
  components: {
    EventView,
    VueCal,
    ...GlobalComponents,
    Head,
    Link,
  },
  data() {
    const today = this.$moment();
    let ddate = {
      month: parseInt(today.format("M")),
      year: parseInt(today.format("Y")),
    };
    if (!isObjEmpty(route().params)) {
      const q = route().params;
      const fulldate = hasProp(q, "date") ? this.$moment(q.date, "MM-DD-YYYY") : today;
      ddate.month = parseInt(fulldate.format("M"));
      ddate.year = parseInt(fulldate.format("Y"));
    }
    const queries = route().params;
    let dfromDate = null;
    let dmonth = parseInt(this.$moment().format("M"));
    let dyear = parseInt(this.$moment().format("Y"));
    let dview = route().params.view ? route().params.view : "calendar";
    if (queries.hasOwnProperty("view")) {
      const view = queries.view;
      switch (view) {
        case "calendar":
          const hasMonthYear = queries.hasOwnProperty("month") && queries.hasOwnProperty("year");
          if (hasMonthYear) {
            dmonth = parseInt(route().params.month);
            dyear = parseInt(route().params.year);
          }
          const hasToDate = route().params.to_date !== undefined ? route().params.to_date : false;
          if (hasToDate) {
            dfromDate = this.$moment({
              month: parseInt(route().params.month) - 1,
              year: parseInt(route().params.year),
              day: parseInt(route().params.day),
            }).toDate();
          }
          break;
        case "table":
          break;
        default:
          Inertia.visit(route("verms.schedules.index", { view: "calendar" }));
      }
    }

    return {
      date: ddate,
      data: [],
      toDate: dfromDate,
      isLoading: false,
      from: {
        month: dmonth,
        year: dyear,
      },
      highlightedDay: this.$moment().format("MMMM Do YYYY, dddd"),
      highlights: [],
      isSelected: null,
      masks: {
        weekdays: "WWW",
      },

      view: dview,
      viewOptions: [
        {
          text: "Calender",
          value: "calendar",
        },
        {
          text: "Table",
          value: "table",
        },
      ],
      filter: "all",
      filterOptions: [
        {
          text: "All",
          value: "all",
        },
        {
          text: "Pending",
          value: "pending",
        },
        {
          text: "Canceled",
          value: "canceled",
        },
        {
          text: "Finished",
          value: "finished",
        },
      ],
      today: this.$moment().toString(),
    };
  },
  computed: {
    isMonthToday: function () {
      return this.$moment({ month: this.from.month - 1, year: this.from.year }).isSame(this.$moment(), "month");
    },
    vcAttributes: function () {
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
    tableEvents: function () {
      return this.schedules.map((item) => {
        const from = this.$moment(item.start_time);
        const to = this.$moment(item.end_time);
        const duration = this.$moment.duration(to.diff(from));
        return {
          id: item.id,
          created_at: this.$moment(item.creatad_at).format("L"),
          event_name: item.event_name,
          venue_name: item.venue.name,
          start_time: this.$moment(item.start_time).format("LLL"),
          end_time: this.$moment(item.end_time).format("LLL"),
          duration: `${duration.asMinutes()}mins`,
          status: item.status,
        };
      });
    },
  },
  methods: {
    toToday: function () {
      const month = parseInt(this.$moment().format("M"));
      const year = parseInt(this.$moment().format("Y"));
      const loadingComponent = this.$buefy.loading.open({
        container: this.isFullPage ? null : this.$refs.element.$el,
      });
      Inertia.visit(route("verms.schedules.index", { view: "calendar", month, year }), {
        preserveScroll: true,

        onFinish: () => {
          loadingComponent.close();
        },
      });
    },
    isToday: function (date) {
      if (this.$moment(date).isSame(this.$moment(), "day")) {
        return true;
      }
      return false;
    },
    dayClick: function (events, day, date) {
      this.highlightedDay = this.$moment(date).format("MMMM Do YYYY, dddd");
      this.isSelected = day;
      if (events.length > 0) {
        this.highlights = events.map((item) => {
          return item.customData;
        });
      } else {
        this.highlights.length = 0;
      }
    },
    openCreateModal() {
      this.$buefy.modal.open({
        parent: this,
        component: CreateModal,
        hasModalCard: true,
        trapfocus: true,
      });
    },
    toCreate: function () {
      Inertia.visit(route("verms.schedules.create"));
    },
  },
  watch: {
    view: function (n) {
      Inertia.visit(route("verms.schedules.index", { view: n }), {
        preserveScroll: true,
      });
    },
    // from: function (n) {
    //   const loadingComponent = this.$buefy.loading.open({
    //     container: this.isFullPage ? null : this.$refs.element.$el,
    //   });
    //   Inertia.visit(route("verms.schedules.index", { view: "calendar", ...n }), {
    //     preserveScroll: true,

    //     onFinish: () => {
    //       loadingComponent.close();
    //     },
    //   });
    // },
    date: {
      handler(n) {
        const loadingComponent = this.$buefy.loading.open({
          container: this.isFullPage ? null : this.$refs.element.$el,
        });

        const date = this.$moment({ month: n.month - 1, year: n.year }).format("MM-DD-YYYY");
        Inertia.visit(route("verms.schedules.index", { date }), {
          preserveScroll: true,

          onFinish: () => {
            loadingComponent.close();
          },
        });
      },
      deep: true,
    },
    toDate: function (n) {
      const from = this.$moment(n).format("MM-DD-YYYY").toString();
      const month = parseInt(this.$moment(n).format("M"));
      const year = parseInt(this.$moment(n).format("Y"));
      const day = parseInt(this.$moment(n).format("D"));
      const loadingComponent = this.$buefy.loading.open({
        container: this.isFullPage ? null : this.$refs.element.$el,
      });
      Inertia.visit(route("verms.schedules.index", { from, view: "calendar", month, year, day, to_date: true }), {
        preserveScroll: true,

        onFinish: () => {
          loadingComponent.close();
        },
      });
    },
  },
  mounted() {
    const date = this.$moment({ month: this.date.month - 1, year: this.date.year }).format("MM-DD-YYYY");
    Inertia.get(route("verms.schedules.index", { date }), { preserveScroll: true });
    if (this.view === "calendar") {
      const from = this.$moment({
        month: this.from.month - 1,
        year: this.from.year,
      });
      const day =
        from.isSame(this.$moment(), "month") && from.isSame(this.$moment(), "year")
          ? parseInt(this.$moment().format("d"))
          : 1;
      const date = from.isSame(this.$moment(), "month") && from.isSame(this.$moment(), "year") ? this.$moment() : from;

      let events = this.vcAttributes.filter((item) => {
        const today = this.$moment(date);
        const end = this.$moment(item.customData.end_date);
        const start = this.$moment(item.customData.start_date);
        const checkEnd = today.isSame(end, "d");
        const checkStart = today.isSame(start, "d");
        if (checkEnd || checkStart) {
          return item;
        }
      });

      const hasToDate = route().params.to_date !== undefined ? route().params.to_date : false;
      if (hasToDate) {
        let events = this.vcAttributes.filter((item) => {
          const today = this.$moment(this.toDate);
          const end = this.$moment(item.customData.end_date);
          const start = this.$moment(item.customData.start_date);
          const checkEnd = today.isSame(end, "d");
          const checkStart = today.isSame(start, "d");
          if (checkEnd || checkStart) {
            return item;
          }
        });
        this.dayClick(events, parseInt(route().params.day), this.toDate);
      } else {
        this.dayClick(events, day, date);
      }
    }
  },
};
</script>
<!-- 
<style lang="scss" scoped>
::-webkit-scrollbar {
  width: 0px;
}
::-webkit-scrollbar-track {
  display: none;
}
::v-deep .custom-calendar.vc-container {
  --day-border: 1px solid #b8c2cc;
  --day-border-highlight: 1px solid #b8c2cc;
  --day-width: 80px;
  --day-height: 80px;
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

  .is-vc-selected {
    background-color: #eef0f193;
  }

  .is-vc-today {
    background-color: #f7840079;
  }

  .xcircle {
    margin: 0 2px;
    height: 12px;
    width: 12px;
    border-radius: 50%;
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
}
</style> -->
