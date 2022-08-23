<template>
  <vc-calendar
    class="custom-calendar max-w-full"
    :masks="masks"
    :attributes="attrs"
    disable-page-swipe
    is-expanded
    :from-page.sync="from"
  >
    <template v-slot:day-content="props">
      <div
        :class="['vc-day__content', isSelected(props.day.day) && 'vc-day--selected']"
        style="z-index: 10"
        @click="$emit('dayClick', props.day.day, props.day.date, attrs)"
      >
        <span class="vc-day__number">{{ props.day.day }}</span>
        <div v-if="props.attributes !== undefined" class="vc-day__events">
          <div
            v-for="attr in props.attributes"
            :key="attr.key"
            class="vc-day__event-dot"
            :style="{ backgroundColor: attr.customData.color }"
          ></div>
        </div>
      </div>
    </template>
  </vc-calendar>
</template>

<script>
export default {
  event: ["dayClick"],
  props: {
    events: {
      type: Array,
      default: () => {
        return [];
      },
    },
    date: {},
    selectedDays: {},
  },
  data() {
    return {
      masks: {
        weekdays: "WWW",
      },
    };
  },
  methods: {
    dump(val) {
      console.log(val);
    },
    isSelected(day) {
      return this.selectedDays.includes(day);
    },
  },
  computed: {
    attrs: {
      get() {
        return this.events.length > 0 ? this.events : [];
      },
    },
    from: {
      get() {
        return this.date ? this.date : null;
      },
      set(value) {
        this.$emit("update:date", value);
      },
    },
  },
};
</script>
