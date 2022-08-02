<template>
  <fragment>
    <Head>
      <title>VERMS | Schedules</title>
      <meta name="description" content="manage schedules..." />
    </Head>
    <b-background class="container is-fluid py-5 mb-5" color="info">
      <b-h3 color="info" light type="title" text="Schedules" />
      <b-h4
        color="info"
        light
        type="subtitle"
        text="Manage your schedules here..."
      />
    </b-background>
    <div class="container my-6">
      <b-h5 light type="title" type-size="4">Reservations</b-h5>
      <div class="is-flex mb-5 is-align-items-center">
       
        <b-button
          type="is-primary"
          icon-pack="bi"
          icon-right="plus-lg"
          @click="toCreate"
        >
          Add Event
        </b-button>
        <div class="ml-auto is-flex">
          <div class="is-flex is-align-items-center mr-4">
            <span class="has-text-weight-semibold mr-2">
              <b-icon pack="bi" icon="filter"></b-icon>
              Filter:
            </span>
            <b-field grouped group-multiline>
              <b-select size="is-normal" v-model="filter" type="is-primary">
                <option
                  v-for="(option, i) in filterOptions"
                  v-bind:value="option.value"
                  :key="i"
                >
                  {{ option.text }}
                </option>
              </b-select>
            </b-field>
          </div>
          <div class="is-flex is-align-items-center">
            <span class="has-text-weight-semibold mr-2">
              <b-icon pack="bi" icon="view-list"></b-icon>
              View:
            </span>
            <b-field grouped group-multiline>
              <b-select size="is-normal" v-model="view" type="is-primary">
                <option
                  v-for="(option, i) in viewOptions"
                  v-bind:value="option.value"
                  :key="i"
                >
                  {{ option.text }}
                </option>
              </b-select>
            </b-field>
          </div>
        </div>
      </div>

      <div class="columns">
        <div v-if="view === 'calendar'" class="column is-8">
          <vc-calendar
            class="custom-calendar max-w-full"
            :masks="masks"
            :attributes="vcAttributes"
            disable-page-swipe
            is-expanded
            :from-page.sync="from"
          >
            <template v-slot:day-content="{ day, attributes }">
              <div
                class="p-1 is-flex is-flex-direction-column h-full z-10 overflow-hidden is-clickable"
                style="height: 100%; z-index: 10; overflow: hidden"
                :class="[isSelected === day.day && 'is-vc-selected']"
                @click="dayClick(attributes, day.day, day.date)"
              >
                <span class="day-label text-sm text-gray-900">{{
                  day.day
                }}</span>

                <div
                  v-if="
                    attributes !== undefined &&
                    Object.entries(attributes).length !== 0
                  "
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
        </div>
        <div v-if="view === 'calendar'" class="column is-4">
          <div class="has-background-light is-rounded p-4" style="height: 100%">
            <b-h5 light type="title" typeSize="5">
              {{ dateTracked }}
            </b-h5>
            <div v-if="eventsDisplay.length > 0">
              <div
                class="has-background-primary has-text-primary-light p-2"
                v-for="event in eventsDisplay"
                :key="event.customData.id"
              >
                <p>
                  <span class="has-text-weight-semibold">Event: </span>
                  {{ event.customData.event }}
                </p>
                <p>
                  <span class="has-text-weight-semibold">Venue: </span>
                  {{ event.customData.venue }}
                </p>
                <p>
                  <span class="has-text-weight-semibold">Guest Name: </span>
                  {{ event.customData.guest }}
                </p>
                <p>
                  <span class="has-text-weight-semibold">Time: </span>
                  {{ event.customData.start }} - {{ event.customData.end }}
                </p>
                <p>
                  <span class="has-text-weight-semibold">Duration: </span>
                  {{ event.customData.duration }}
                </p>
              </div>
            </div>
            <div v-else>no events</div>
          </div>
        </div>
        <div v-if="view === 'table'" class="column is-12">
          <b-table :data="tableEvents" striped hoverable>
            <b-table-column
              label="Date Added"
              field="created_at"
              v-slot="props"
            >
              {{ props.row.created_at }}
            </b-table-column>
            <b-table-column label="Event" field="event_name" v-slot="props">
              {{ props.row.event_name }}
            </b-table-column>
            <b-table-column label="Venue" field="venue_name" v-slot="props">
              {{ props.row.venue_name }}
            </b-table-column>
            <b-table-column label="From" field="start_time" v-slot="props">
              {{ props.row.start_time }}
            </b-table-column>
            <b-table-column label="To" field="end_time" v-slot="props">
              {{ props.row.end_time }}
            </b-table-column>
            <b-table-column label="Duration" field="duration" v-slot="props">
              {{ props.row.duration }}
            </b-table-column>
            <b-table-column label="Status" field="status" v-slot="props">
              {{ props.row.status }}
            </b-table-column>
          </b-table>
        </div>
      </div>
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
export default {
  layout: Verms,
  props: ["schedules", "month", "year"],
  components: {
    VueCal,
    ...GlobalComponents,
    Head,
    Link,
  },
  data() {
    const queries = route().params;

    let dfrom = {
      month: route().params.month
        ? parseInt(route().params.month)
        : parseInt(this.$moment(new Date()).format("M")),
      year: route().params.year
        ? parseInt(route().params.year)
        : new Date().getFullYear(),
    };

    const month = new Date().getMonth();
    const year = new Date().getFullYear();
    const day = new Date().getDay();

    let dview = route().params.view ? route().params.view : "calendar";
    return {
      from: dfrom,
      dateTracked: this.$moment().format("MMMM Do YYYY, dddd"),
      eventsDisplay: [],
      isSelected: day,
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
    log: function (e) {
      console.log(e);
    },
    event_click: function (event, e) {
      console.log("event", event);
      console.log("e", e);
    },
    dayClick: function (events, day, date) {
      this.dateTracked = this.$moment(date).format("MMMM Do YYYY, dddd");
      this.isSelected = day;
      if (events.length > 0) {
        this.eventsDisplay = events;
      } else {
        this.eventsDisplay.length = 0;
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
    from: function (n) {
      Inertia.visit(
        route("verms.schedules.index", { view: "calendar", ...n }),
        { preserveScroll: true }
      );
    },
  },
  mounted() {
    if (route().params.view === undefined) {
      let date = new Date();
      let day = new Date().getDay();
      if (route().params.view === "calendar") {
        date = this.$moment({
          month: this.from.month - 1,
          year: this.from.year,
        });
        day = 1;
      }
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

      this.dayClick(events, day, date);
    }
  },
};
</script>

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
  --day-width: 90px;
  --day-height: 90px;
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
</style>
