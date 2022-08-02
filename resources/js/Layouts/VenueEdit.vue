<template>
  <fragment>
    <Header :brand-url="brand_url" />
    <div class="x-divider"></div>
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
    <div class="x-divider"></div>
    <main class="mb-4">
      <div class="has-text-centered my-5">
        <Link :href="route('verms.venues.index')">
          <BH3 size="5">
            <BIcon pack="bi" icon="arrow-left" />
            Back to venue's list
          </BH3>
        </Link>
      </div>
      <div class="tabs is-toggle is-centered">
        <ul>
          <li
            :class="{
              'is-active': route().current('verms.venues.details.index'),
            }"
          >
            <Link
              :href="route('verms.venues.details.index', $page.props.venue.id)"
              preserve-scroll
            >
              <BIcon pack="bi" icon="file-text" />
              Details
            </Link>
          </li>
          <li
            :class="{
              'is-active': route().current('verms.venues.media.index'),
            }"
          >
            <Link
              :href="route('verms.venues.media.index', $page.props.venue.id)"
              preserve-scroll
            >
              <BIcon pack="bi" icon="images" />
              Media
            </Link>
          </li>
        </ul>
      </div>
      <slot></slot>
    </main>
  </fragment>
</template>

<script>
import Header from "@/Components/Header.vue";
import { Link } from "@inertiajs/inertia-vue";
import GlobalComponents from "@/Components/Global";
export default {
  props: {
    brand_url: {
      type: String,
    },
  },
  components: {
    ...GlobalComponents,
    Link,
    Header,
  },
};
</script>

<style scoped>
.navbar-item.is-active {
  color: #7957d5;
}
</style>
