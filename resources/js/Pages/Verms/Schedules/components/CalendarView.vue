<template>
  <div>
    <div>controls</div>
    <div class="columns">
      <!-- calendar panel -->
      <div class="column is-8">
        <vc-calendar
          ref="element"
          class="custom-calendar max-w-full"
          :masks="masks"
          :attributes="attrs"
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
              <span class="day-label text-sm text-gray-900">{{ day.day }}</span>

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
      <!-- end of calendar panel -->
      <!-- event display panel -->
      <div class="column is-4">
        <div class="has-background-light is-rounded p-4" style="height: 100%">
          <b-h5 light type="title" typeSize="5">
            {{ dateHighlighted }}
          </b-h5>
          <div v-if="highlights.length > 0">
            <div
              class="has-background-primary has-text-primary-light p-2"
              v-for="highlight in highlights"
              :key="highlight.customData.id"
            >
              <p>
                <span class="has-text-weight-semibold">Event: </span>
                {{ highlight.event }}
              </p>
              <p>
                <span class="has-text-weight-semibold">Venue: </span>
                {{ highlight.venue }}
              </p>
              <p>
                <span class="has-text-weight-semibold">Guest Name: </span>
                {{ highlight.guest }}
              </p>
              <p>
                <span class="has-text-weight-semibold">Time: </span>
                {{ highlight.start }} - {{ highlight.end }}
              </p>
              <p>
                <span class="has-text-weight-semibold">Duration: </span>
                {{ highlight.duration }}
              </p>
            </div>
          </div>
          <div v-else>no events</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["events"],
  data() {
    return {
      daySelected: null,
      dateHighlighted: null,
    }
  },
  computed: {
    highlights: {
      get() {
        return []; 
      }
    },
    attrs: {
      get() {
        return [];
      }
    }
  },
  methods: {
    dayClick: function(attrs, day, date) {

    } 
  }
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
