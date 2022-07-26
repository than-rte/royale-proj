<template>
  <p :class="classes">
     <slot>
      {{ text }}
    </slot>
  </p>
</template>

<script>
import Typography from "@/Mixins/Typography.js";
export default {
  mixins: [Typography],
};
</script>
