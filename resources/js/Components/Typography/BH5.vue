<template>
  <h5 :class="classes">
     <slot>
      {{ text }}
    </slot>
  </h5>
</template>

<script>
import Typography from "@/Mixins/Typography.js";
export default {
  mixins: [Typography],
};
</script>
