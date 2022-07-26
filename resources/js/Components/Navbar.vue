<template>
  <div class="container is-fluid py-2">
    <nav class="navbar" role="navigation" aria-label="main navigation">
      <div class="navbar-start">
        <Link
          :href="route('verms.dashboard.index')"
          :class="[
            'navbar-item',
            route().current('verms.dashboard.*') && 'is-active',
          ]"
        >
          <BIcon pack="bi" icon="kanban" class="mr-1" />
          Dashboard
        </Link>
        <Link
          :href="route('verms.schedules.index')"
          :class="[
            'navbar-item',
            route().current('verms.schedules.*') && 'is-active',
          ]"
        >
          <BIcon pack="bi" icon="calendar" class="mr-1" />
          Schedules
        </Link>
        <Link
          :href="route('verms.venues.index')"
          :class="[
            'navbar-item',
            route().current('verms.venues.*') && 'is-active',
          ]"
        >
          <BIcon pack="bi" icon="building" class="mr-1" />
          Venues
        </Link>
        <Link
          :href="route('verms.events.index')"
          :class="[
            'navbar-item',
            route().current('verms.events.*') && 'is-active',
          ]"
        >
          <BIcon pack="bi" icon="book" class="mr-1" />
          Events
        </Link>
        <Link
          :href="route('verms.media.index')"
          :class="[
            'navbar-item',
            route().current('verms.media.*') && 'is-active',
          ]"
        >
          <BIcon pack="bi" icon="images" class="mr-1" />
          Media
        </Link>
      </div>
    </nav>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
export default {
  components: {
    Link,
  },
};
</script>

<style scoped>
.navbar-item.is-active {
  color: #7957d5;
}
</style>
