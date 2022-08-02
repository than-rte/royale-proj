<template>
  <div class="is-flex is-justify-content-center">
    <form @submit.prevent="createFormSubmit">
      <b-card style="width: 600px; margin-bottom: 200px" class="mt-6">
        <b-card-header class="py-2">
          <b-h5 class="card-header-title" type="title" type-size="5">
            <b-icon icon="calendar" pack="bi" class="mr-2"></b-icon>
            Create Schedule
          </b-h5>
        </b-card-header>
        <b-card-content>
          <div class="mb-6">
            <b-h6 class="mb-2" text="Guest's Details" />
            <b-field label="Full name">
              <b-input
                v-model="form.guest_name"
                name="guest_name"
                placeholder="Guest's name"
              ></b-input>
            </b-field>
            <b-field label="Phone number">
              <b-input
                style="width: 50%"
                v-model="form.phone_number"
                type="text"
                validation-message="Invalid phone number"
                pattern="^(09|\+639)\d{9}$"
              />
            </b-field>
          </div>
          <div class="mb-4">
            <b-h6 class="mb-2" text="Event's Details" />
            <b-field label="Event name">
              <b-input
                v-model="form.event_name"
                name="event_name"
                placeholder="Event's name"
              ></b-input>
            </b-field>
            <b-field label="Venue name">
              <b-select v-model="form.venue_id">
                <option
                  v-for="venue in venueOptions"
                  :key="venue.id"
                  :value="venue.id"
                >
                  {{ venue.name }}
                </option>
              </b-select>
            </b-field>
            <b-field
              label="Start time"
              :type="isDateError ? 'is-danger' : null"
            >
              <b-datetimepicker
                v-model="form.start_time"
                style="width: 70%"
                hour-format="12"
                locale="en-PH"
                placeholder="From"
                icon="calendar"
                editable
                position="is-top-right"
                :datetime-formatter="(time) => $moment(time).format('LLL')"
              >
              </b-datetimepicker>
            </b-field>
            <b-field
              label="End time"
              :type="isDateError ? 'is-danger' : null"
              :message="isDateError ? 'Time overlapped!' : null"
            >
              <b-datetimepicker
                v-model="form.end_time"
                style="width: 70%"
                hour-format="12"
                locale="en-PH"
                placeholder="To"
                icon="calendar"
                editable
                position="is-top-right"
                :datetime-formatter="(time) => $moment(time).format('LLL')"
              >
              </b-datetimepicker>
            </b-field>
            <b-field v-if="duration !== null" label="Duration">
              <b-text> {{ duration }} minutes</b-text>
            </b-field>
          </div>
        </b-card-content>
        <b-card-footer class="px-5 py-4">
          <b-button
            native-type="submit"
            class="has-text-weight-bold"
            label="Submit"
            type="button is-primary"
            icon-right="box-arrow-right"
          />
        </b-card-footer>
      </b-card>
    </form>
  </div>
</template>

<script>
import Verms from "@/Layouts/Verms.vue";
import GlobalComponents from "@/Components/Global";
import { Inertia } from "@inertiajs/inertia";
export default {
  layout: Verms,
  props: ["venues"],
  components: {
    ...GlobalComponents,
  },
  data() {
    return {
      form: {
        guest_name: "",
        phone_number: "",
        event_name: "",
        venue_id: "",
        start_time: null,
        end_time: null,
      },
      duration: null,
      isDateError: false,
    };
  },
  computed: {
    venueOptions: function () {
      return this.venues;
    },
    time: function () {
      return {
        start: this.form.start_time,
        end: this.form.end_time,
      };
    },
  },
  watch: {
    time: {
      handler(n) {
        if (n.start !== null && n.end !== null) {
          const from = this.$moment(n.start);
          const to = this.$moment(n.end);
          const duration = this.$moment.duration(to.diff(from));
          const hours = duration.asHours();
          if (hours < 1) {
            this.isDateError = true;
            this.duration = null;
          } else {
            this.duration = duration.asMinutes();
            this.isDateError = false;
          }
        }
      },
      deep: true,
    },
  },
  methods: {
    createFormSubmit: function () {
      const formToSubmit = {
        guest_name: this.form.guest_name,
        event_name: this.form.event_name,
        phone_number: this.form.phone_number,
        venue_id: this.form.venue_id,
        start_time: this.$moment(this.form.start_time).format(
          "YYYY-MM-DD HH:mm:ss"
        ),
        end_time: this.$moment(this.form.end_time).format(
          "YYYY-MM-DD HH:mm:ss"
        ),
      };
      Inertia.post(route("verms.schedules.store"), formToSubmit);
    },
  },
  mounted() {
    this.form.venue_id = this.venueOptions[0].id;
  },
};
</script>
