<template>
  <fragment>
    <Head>
      <title>VERMS | Venues - List</title>
      <meta name="description" content="manage venues..." />
    </Head>
    <BBackground class="container is-fluid py-5 mb-5" color="info">
      <BH3 color="info" light type="title" text="Venues" />
      <BH4
        color="info"
        light
        type="subtitle"
        text="Manage all your venues here..."
      />
    </BBackground>
    <div class="container is-fluid">
      <div class="columns">
        <!-- main -->
        <div class="column is-8">
          <!-- venue table -->
          <BCard>
            <BCardHeader class="has-background-link-light">
              <h5 class="card-header-title">
                <BIcon pack="bi" icon="list" class="mr-2" />
                Venue List
              </h5>
            </BCardHeader>
            <BCardContent>
              <div class="level" style="width: 100%">
                <div class="level-left">
                  <div class="level-item">
                    <BField>
                      <BInput
                        size="is-small"
                        pack="bi"
                        icon="search"
                        :icon-right="
                          searchInput.length > 0 ? 'x-circle-fill' : ''
                        "
                        :icon-right-clickable="searchInput.length > 0"
                        @icon-right-click="clearSearch"
                        v-model="searchInput"
                        expanded
                        placeholder="Search name..."
                      />
                      <div class="control">
                        <BButton
                          size="is-small"
                          type="is-primary"
                          outlined
                          label="Search"
                          icon-left="search"
                          @click="venueSearch()"
                        />
                      </div>
                    </BField>
                  </div>
                </div>
                <div class="level-right">
                  <div class="level-item">
                    <BText class="mr-2" size="7" text="Sort By:" />
                    <BField grouped group-multiline>
                      <BSelect size="is-small" v-model="sort" type="is-primary">
                        <option
                          v-for="(option, i) in sortOptions"
                          v-bind:value="option.value"
                          :key="i"
                        >
                          {{ option.text }}
                        </option>
                      </BSelect>
                      <BSelect
                        size="is-small"
                        v-model="status"
                        type="is-primary"
                      >
                        <option
                          v-for="(option, i) in statusOptions"
                          v-bind:value="option.value"
                          :key="i"
                        >
                          {{ option.text }}
                        </option>
                      </BSelect>
                    </BField>
                  </div>
                </div>
              </div>
              <BTable :data="getVenues" striped hoverable>
                <BTableColumn
                  field="name"
                  label="Name"
                  cell-class=""
                  v-slot="props"
                >
                  <Link
                    :href="
                      route('verms.venues.details.index', { id: props.row.id })
                    "
                    >{{ props.row.name }}</Link
                  >
                </BTableColumn>
                <BTableColumn
                  field="created_at"
                  label="Date Added"
                  cell-class="has-text-centered"
                  v-slot="props"
                  centered
                >
                  <BTag :type="props.row.created_at.color">
                    {{ props.row.created_at.date }}
                  </BTag>
                  <BTag class="ml-2">
                    {{ props.row.created_at.humanDate }}
                  </BTag>
                </BTableColumn>
                <BTableColumn
                  field="updated_at"
                  label="Date Updated"
                  cell-class=""
                  v-slot="props"
                  centered
                >
                  <BTag type="is-primary">{{ props.row.updated_at }}</BTag>
                </BTableColumn>
                <BTableColumn
                  field="status"
                  label="Status"
                  cell-class=""
                  v-slot="props"
                  centered
                >
                  <BTag :type="props.row.status.color">
                    {{ props.row.status.name }}
                  </BTag>
                </BTableColumn>
                <BTableColumn
                  label="Actions"
                  cell-class="has-text-centered"
                  centered
                >
                  <BButton
                    size="is-small"
                    icon-pack="bi"
                    type="is-info"
                    icon-right="pencil-square"
                    class="mr-2"
                  />
                  <BButton
                    size="is-small"
                    icon-pack="bi"
                    type="is-danger"
                    icon-right="trash"
                  />
                </BTableColumn>
              </BTable>
            </BCardContent>
            <BCardFooter
              class="px-5 py-4 is-flex is-justify-content-flex-end is-align-items-center"
            >
              <BPagination
                :total="venues.total"
                v-model="current_page"
                :per-page="venues.per_page"
                icon-pack="bi"
                icon-prev="chevron-left"
                icon-next="chevron-right"
                aria-next-label="Next page"
                aria-previous-label="Previous page"
                aria-page-label="Page"
                aria-current-label="Current page"
              >
                <template #default="props">
                  <Link
                    preserve-scroll
                    :href="
                      route('verms.venues.index', {
                        ...route().params,
                        page: props.page.number,
                      })
                    "
                    :class="[
                      'pagination-link',
                      props.page.isCurrent && 'is-current',
                    ]"
                    :role="props.page['aria-label']"
                  >
                    {{ props.page.number }}
                  </Link>
                </template>
                <template #previous="props">
                  <Link
                    preserve-scroll
                    :href="
                      route('verms.venues.index', {
                        ...route().params,
                        page: props.page.number,
                      })
                    "
                    :class="[
                      'pagination-link',
                      props.page.isCurrent && 'is-current',
                    ]"
                    :role="props.page['aria-label']"
                    :disabled="props.page.disabled && 'disabled'"
                  >
                    <BIcon pack="bi" icon="chevron-left" />
                  </Link>
                </template>
                <template #next="props">
                  <Link
                    preserve-scroll
                    style="order: 2"
                    :href="
                      route('verms.venues.index', {
                        ...route().params,
                        page: props.page.number,
                      })
                    "
                    :class="[
                      'pagination-link',
                      props.page.isCurrent && 'is-current',
                    ]"
                    :role="props.page['aria-label']"
                    :disabled="props.page.disabled && 'disabled'"
                  >
                    <BIcon pack="bi" icon="chevron-right" />
                  </Link>
                </template>
              </BPagination>
            </BCardFooter>
          </BCard>
        </div>
        <!-- end of main -->
        <!-- add card-->
        <div class="column is-4">
          <form @submit.prevent="venueFormSubmit()">
            <BCard>
              <BCardHeader class="has-background-link-light">
                <h5 class="card-header-title">
                  <BIcon pack="bi" icon="plus-lg" class="mr-2" />
                  Add Venue
                </h5>
              </BCardHeader>
              <BCardContent>
                <BField label="Venue name">
                  <BInput
                    v-model="venue.name"
                    name="name"
                    placeholder="Venue name"
                    type="search"
                    icon-pack="bi"
                    icon="building"
                  />
                </BField>
                <!-- <BField label="Color" grouped group-multiline>
                <BInput name="color" expanded readonly v-model="color" />
                <VSwatches
                  v-model="color"
                  show-fallback
                  fallback-input-type="color"
                  popover-x="left"
                />
              </BField> -->
                <!-- <BField label="Capacity">
                <input name="capacity" type="hidden" />
                <BNumberinput type="is-dark" icon-pack="bi" min="0" />
              </BField> -->
              </BCardContent>
              <BCardFooter class="px-5 py-4">
                <BButton
                  native-type="submit"
                  class="has-text-weight-bold"
                  label="Add Venue"
                  type="button is-primary"
                  icon-left="plus-lg"
                />
              </BCardFooter>
            </BCard>
          </form>
        </div>
        <!-- end of add card-->
      </div>
    </div>
  </fragment>
</template>

<script>
import VSwatches from "vue-swatches";
import { Head, Link } from "@inertiajs/inertia-vue";
import BTitle from "@/Components/BTitle.vue";
import BCard from "@/Components/BCard/BCard.vue";
import BCardHeader from "@/Components/BCard/BCardHeader.vue";
import BCardContent from "@/Components/BCard/BCardContent.vue";
import BCardFooter from "@/Components/BCard/BCardFooter.vue";
import BBackground from "@/Components/BBackground.vue";
import Verms from "@/Layouts/Verms.vue";
import GlobalComponents from "@/Components/Global";
import { Inertia } from "@inertiajs/inertia";
import { getFilter, getSort } from "@/Utils/venues";
export default {
  layout: Verms,
  props: {
    venues: {
      type: Object,
      default: {},
    },
  },
  components: {
    Head,
    Link,
    ...GlobalComponents,
    BTitle,
    BBackground,
    BCard,
    BCardHeader,
    BCardContent,
    BCardFooter,
    VSwatches,
  },
  data() {
    let dsort = "";
    switch (route().params.sort) {
      case "-created_at":
        dsort = "new";
        break;
      case "created_at":
        dsort = "oldest";
        break;
      case "name":
        dsort = "name";
        break;
      default:
        dsort = "new";
    }

    let dfilter = "";
    let f = parseInt(
      route().params.filter !== undefined && route().params.filter.is_publish
    );

    if (f === 0) {
      dfilter = "unpublished";
    } else if (f === 1) {
      dfilter = "published";
    } else {
      dfilter = "all";
    }
    let dsearch =
      route().params.filter !== undefined
        ? route().params.filter.name !== undefined
          ? route().params.filter.name
          : ""
        : "";

    return {
      current_page: 1,
      venue: {
        name: "",
      },
      color: "#BDC3C8",
      sort: dsort,
      sortOptions: [
        { text: "Newest", value: "new" },
        { text: "Oldest", value: "oldest" },
        { text: "Name", value: "name" },
      ],
      status: dfilter,
      statusOptions: [
        { text: "All", value: "all" },
        { text: "Published", value: "published" },
        { text: "Unpublished", value: "unpublished" },
      ],
      searchInput: dsearch,
    };
  },
  computed: {
    getVenues: function () {
      return this.venues.data.map((venue) => {
        const today = this.$moment().format("L");
        const created_at = this.$moment(venue.created_at).format("L");
        return {
          id: venue.id,
          name: venue.name,
          created_at: {
            date: today === created_at ? "new" : created_at,
            humanDate: this.$moment(venue.created_at).fromNow(),
            color: today === created_at ? "is-success" : "is-primary",
          },
          updated_at: this.$moment(venue.updated_at).format("L"),
          status: {
            name: venue.is_publish ? "published" : "unpublished",
            color: venue.is_publish ? "is-success" : "is-danger",
          },
        };
      });
    },
  },
  methods: {
    venueFormSubmit: function () {
      Inertia.post(route("verms.venues.store"), this.venue, {
        preserveScroll: true,
      });
    },
    venueSearch: function () {
      let sort = getSort(this.sort);
      let filter = getFilter(this.status, this.searchInput);
      let params = { sort, filter };
      Inertia.visit(route("verms.venues.index", { sort, filter }), {
        preserveScroll: true,
      });
    },
    clearSearch: function () {
      this.searchInput = "";
      Inertia.visit(route("verms.venues.index"), {
        preserveScroll: true,
      });
    },
  },
  watch: {
    sort: function (n) {
      // let nsort = getSort(n);
      // let nfilter = getFilter(this.status);
      // let params = getParams(nsort, nfilter);
      let sort = getSort(n);
      let filter = getFilter(this.status);
      let params = { sort, filter };

      Inertia.visit(route("verms.venues.index", { sort, filter }), {
        preserveScroll: true,
      });
    },
    status: function (n) {
      // let nsort = getSort(this.sort);
      // let nfilter = getFilter(n);
      // let params = getParams(nsort, nfilter);

      let sort = getSort(this.sort);
      let filter = getFilter(n);
      let params = { sort, filter };

      Inertia.visit(route("verms.venues.index", { sort, filter }), {
        preserveScroll: true,
      });
    },
  },
  mounted() {
    this.current_page = this.venues.current_page;
  },
};
</script>

<style scoped></style>
