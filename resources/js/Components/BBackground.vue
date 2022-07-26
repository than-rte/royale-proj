<template>
  <div :class="classes">
    <slot></slot>
  </div>
</template>

<script>
export default {
  props: {
    color: {
      type: String,
      default: "primary",
    },
    light: {
      type: Boolean,
      default: false,
    },
    dark: {
      type: Boolean,
      default: false,
    },
  },
  data: function () {
    return {
      classes: [],
    };
  },
  computed: {
    colorClass: function () {
      if (this.color.length > 0 && this.dark) {
        return `has-background-${this.color}-dark`;
      }
      if (this.color.length > 0 && this.light) {
        return `has-background-${this.color}-light`;
      }
      if (this.color.length > 0) {
        return `has-background-${this.color}`;
      }
    },
  },
  mounted() {
    this.classes = [this.colorClass].filter((v) => v);
  },
};
</script>

<style lang="scss" scoped></style>
