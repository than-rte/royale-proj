export default {
  props: {
    type: {
      type: String,
      default: "",
    },
    typeSize: {
      type: String,
      default: "",
    },
    size: {
      type: String,
      default: "",
    },
    color: {
      type: String,
      default: "",
    },
    light: {
      type: Boolean,
      default: false,
    },
    dark: {
      type: Boolean,
      default: false,
    },
    text: {
      type: String,
      default: "",
    }
  },
  data: function () {
    return {
      classes: [],
    };
  },
  computed: {
    typeClass: function () {
      if (this.type.length > 0) return this.type;
    },
    typeSizeClass: function () {
      if (this.typeSize.length > 0) return `is-${this.typeSize}`;
    },
    sizeClass: function () {
      if (this.size.length > 0) return `is-size-${this.size}`;
    },
    colorClass: function () {
      if (this.color.length > 0 && this.dark) {
        return `has-text-${this.color}-dark`;
      }
      if (this.color.length > 0 && this.light) {
        return `has-text-${this.color}-light`;
      }
      if (this.color.length > 0) {
        return `has-text-${this.color}`;
      }
    },
  },
  mounted() {
    this.classes = [
      this.typeClass,
      this.typeSizeClass,
      this.sizeClass,
      this.colorClass,
    ].filter((v) => v);
  },
};
