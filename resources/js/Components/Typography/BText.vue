<template>
  <span :class="classes">
     <slot>
      {{ text }}
    </slot>
  </span>
</template>

<script>
import Typography from "@/Mixins/Typography.js";
export default {
  mixins: [Typography],
};
</script>
