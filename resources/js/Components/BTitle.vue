<template>
  <div class="has-background-info py-5 container is-fluid">
    <div>
      <h3 class="has-text-info-light title mb-3">{{ title }}</h3>
      <h4 class="has-text-info-light subtitle">
        {{ subtitle }}
      </h4>
    </div>
  </div>
</template>

<script>
export default {
  props: ["title", "subtitle"],
};
</script>