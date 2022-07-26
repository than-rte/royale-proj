<template>
  <h4 :class="classes">
     <slot>
      {{ text }}
    </slot>
  </h4>
</template>

<script>
import Typography from "@/Mixins/Typography.js";
export default {
  mixins: [Typography],
};
</script>
