<template>
  <h6 :class="classes">
     <slot>
      {{ text }}
    </slot>
  </h6>
</template>

<script>
import Typography from "@/Mixins/Typography.js";
export default {
  mixins: [Typography],
};
</script>
