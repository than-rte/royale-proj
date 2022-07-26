<template>
  <h3 :class="classes">
     <slot>
      {{ text }}
    </slot>
  </h3>
</template>

<script>
import Typography from "@/Mixins/Typography.js";
export default {
  mixins: [Typography],
};
</script>
