<template>
  <fragment>
    <Header :brand-url="brand_url" />
    <div class="x-divider"></div>
    <Navbar />
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
          <li :class="{'is-active': route().current('verms.venues.details.index')}">
            <Link :href="route('verms.venues.details.index', $page.props.venue.id)" preserve-scroll>
              <BIcon pack="bi" icon="file-text"/>
              Details
            </Link>
          </li>
          <li :class="{'is-active': route().current('verms.venues.media.index')}">
            <Link :href="route('verms.venues.media.index', $page.props.venue.id)" preserve-scroll>
              <BIcon pack="bi" icon="images"/>
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
import Navbar from "@/Components/Navbar.vue";
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
