<template>
  <fragment>
    <Header :brand-url="brand_url" />
    <div class="x-divider"></div>
    <Navbar />
    <div class="x-divider"></div>
    <main class="mb-4">
      <slot></slot>
    </main>
  </fragment>
</template>

<script>
import Navbar from "@/Components/Navbar.vue";
import Header from "@/Components/Header.vue";
export default {
  props: {
    brand_url: {
      type: String,
    },
  },
  components: {
    Navbar,
    Header,
  },
};
</script>

<style scoped>
.navbar-item.is-active {
  color: #7957d5;
}
</style>
