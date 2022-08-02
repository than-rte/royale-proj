<template>
  <b-card style="width: 600px">
    <b-card-header class="py-2">
      <b-h5 type="title" type-size="4" class="card-header-title">Create Schedule</b-h5>
    </b-card-header>
    <b-card-content>
      <b-steps
        @input="log"
        v-model="activeStep"
        :animated="isAnimated"
        :rounded="isRounded"
        :has-navigation="hasNavigation"
        :icon-prev="prevIcon"
        :icon-next="nextIcon"
        :label-position="labelPosition"
        :mobile-mode="mobileMode"
      >
        <b-step-item step="1" label="Guest's Detail" class="my-5">
          <b-field label="Full name">
            <b-input></b-input>
          </b-field>
          <b-field label="Phone number">
            <b-input></b-input>
          </b-field>
        </b-step-item>

        <b-step-item step="2" label="Event's Details"> </b-step-item>

        <b-step-item :step="3" label="Finish" disabled> </b-step-item>

        <template v-if="customNavigation" #navigation="{ previous, next }">
          <div class="is-flex is-justify-content-flex-end">
            <b-button
              class="mr-2"
              type="is-danger"
              icon-pack="bi"
              icon-left="chevron-left"
              :disabled="previous.disabled"
              @click.prevent="previous.action"
            >
              Back
            </b-button>
            <b-button
              type="is-success"
              icon-pack="bi"
              icon-right="chevron-right"
              :disabled="next.disabled"
              @click.prevent="check(next.action)"
            >
              Next
            </b-button>
          </div>
        </template>
      </b-steps>
    </b-card-content>
  </b-card>
</template>

<script>
import GlobalComponents from "@/Components/Global";
export default {
  components: {
    ...GlobalComponents,
  },
  data() {
    return {
      activeStep: 0,

      showSocial: false,
      isAnimated: true,
      isRounded: true,
      isStepsClickable: false,

      hasNavigation: true,
      customNavigation: true,
      isProfileSuccess: false,

      prevIcon: "chevron-left",
      nextIcon: "chevron-right",
      labelPosition: "bottom",
      mobileMode: "minimalist",
    };
  },
  methods: {
    log: function (value) {
      console.log(value);
    },
    check: function (callback) {
      callback();
    },
  },
};
</script>

<style lang="scss" scoped></style>
