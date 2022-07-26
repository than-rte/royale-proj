<template>
  <header class="py-4">
    <div class="container is-fluid is-flex">
      <div>
        <img :src="brandUrl" alt="Royale Emelina Logo" />
      </div>
      <div
        class="is-flex is-flex-direction-column is-justify-content-center ml-4"
      >
        <BH1 type="title" text="Royale Emelina Events & Venues"/>
        <BH2 type="subtitle" text="Lorem ipsum dolor sit amet consectetur,"/>
        <!-- <h1 class="title">Royale Emelina Events & Venues</h1> -->
        <!-- <h2 class="subtitle">Lorem ipsum dolor sit amet consectetur,</h2> -->
      </div>
    </div>
  </header>
</template>

<script>
import GlobalComponents from "@/Components/Global";
export default {
  props: {
    brandUrl: {
      type: String,
    },
  },
  components: {
    ...GlobalComponents,
  }
};
</script>