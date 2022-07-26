<template>
  <h2 :class="classes">
     <slot>
      {{ text }}
    </slot>
  </h2>
</template>

<script>
import Typography from "@/Mixins/Typography.js";
export default {
  mixins: [Typography],
};
</script>
