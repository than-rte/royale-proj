<template>
  <fragment>
    <Head>
      <title>VERMS | Venues - List</title>
      <meta name="description" content="manage venues..." />
    </Head>
    <!-- section -->
    <b-background class="container is-fluid py-5 mb-5" color="info">
      <b-h3 color="info" light type="title" text="Venues" />
      <b-h4
        color="info"
        light
        type="subtitle"
        text="Manage all your venues here..."
      />
    </b-background>
    <!-- main content-->
    <div class="container is-fluid">
      <div class="columns">
        <!-- add card-->
        <div class="column is-4">
          <form @submit.prevent="venueFormSubmit">
            <b-card>
              <b-card-header class="has-background-link-light">
                <h5 class="card-header-title">
                  <b-icon pack="bi" icon="plus-lg" class="mr-2" />
                  Add Venue
                </h5>
              </b-card-header>
              <b-card-content>
                <b-field
                  label="Venue name"
                  :type="errors && 'is-danger'"
                  :message="errors && errors.name"
                >
                  <b-input
                    v-model="venue.name"
                    name="name"
                    placeholder="Venue name"
                    type="search"
                    icon-pack="bi"
                    icon="building"
                    @input="errors = null"
                  />
                </b-field>
                <b-field label="Legend" grouped>
                  <b-input name="legend" expanded readonly v-model="venue.legend" />
                  <v-swatches
                    v-model="venue.legend"
                    show-fallback
                    fallback-input-type="color"
                    popover-x="left"
                  />
                </b-field>
              </b-card-content>
              <b-card-footer class="px-5 py-4">
                <b-button
                  native-type="submit"
                  class="has-text-weight-bold"
                  label="Add Venue"
                  type="button is-primary"
                  icon-left="plus-lg"
                  :disabled="isSubmitting"
                />
              </b-card-footer>
            </b-card>
          </form>
        </div>
        <!-- end of add card-->
        <!-- table card -->
        <div class="column is-8">
          <!-- venue table -->
          <b-card>
            <b-card-header class="has-background-link-light">
              <h5 class="card-header-title">
                <b-icon pack="bi" icon="list" class="mr-2" />
                Venue List
              </h5>
            </b-card-header>
            <b-card-content>
              <div class="level" style="width: 100%">
                <div class="level-left">
                  <div class="level-item">
                    <form @submit.prevent="searchFormSubmit">
                      <b-field>
                        <b-input
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
                          <b-button
                            native-type="submit"
                            size="is-small"
                            type="is-primary"
                            outlined
                            label="Search"
                            icon-left="search"
                          />
                        </div>
                      </b-field>
                    </form>
                  </div>
                </div>
                <div class="level-right">
                  <div class="level-item">
                    <b-text class="mr-2" size="7" text="Sort By:" />
                    <b-field grouped group-multiline>
                      <div class="control">
                        <b-select
                          size="is-small"
                          v-model="sort"
                          type="is-primary"
                        >
                          <option
                            v-for="(option, i) in sortOptions"
                            v-bind:value="option.value"
                            :key="i"
                          >
                            {{ option.text }}
                          </option>
                        </b-select>
                      </div>
                      <div class="control">
                        <b-select
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
                        </b-select>
                      </div>
                    </b-field>
                  </div>
                </div>
              </div>
              <b-table :data="getVenues" striped hoverable>
                <b-table-column
                  field="name"
                  label="Name"
                  cell-class=""
                  v-slot="props"
                >
                  {{ props.row.name }}
                </b-table-column>
                <b-table-column
                  field="created_at"
                  label="Date Added"
                  cell-class="has-text-centered"
                  v-slot="props"
                  centered
                >
                  <b-tag :type="props.row.created_at.color">
                    {{ props.row.created_at.date }}
                  </b-tag>
                  <b-tag class="ml-2">
                    {{ props.row.created_at.humanDate }}
                  </b-tag>
                </b-table-column>
                <b-table-column
                  field="updated_at"
                  label="Date Updated"
                  cell-class=""
                  v-slot="props"
                  centered
                >
                  <b-tag type="is-primary">{{ props.row.updated_at }}</b-tag>
                </b-table-column>
                <b-table-column
                  field="status"
                  label="Status"
                  cell-class=""
                  v-slot="props"
                  centered
                >
                  <b-tag :type="props.row.status.color">
                    {{ props.row.status.name }}
                  </b-tag>
                </b-table-column>
                <b-table-column
                  label="Actions"
                  cell-class="has-text-centered"
                  centered
                  v-slot="props"
                >
                  <b-button
                    size="is-small"
                    icon-pack="bi"
                    type="is-info"
                    icon-right="pencil-square"
                    class="mr-2"
                    @click="toEdit(props.row.id)"
                  />
                  <b-button
                    size="is-small"
                    icon-pack="bi"
                    type="is-danger"
                    icon-right="trash"
                  />
                </b-table-column>
              </b-table>
            </b-card-content>
            <b-card-footer
              class="px-5 py-4 is-flex is-justify-content-flex-end is-align-items-center"
            >
              <b-pagination
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
                    <b-icon pack="bi" icon="chevron-left" />
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
              </b-pagination>
            </b-card-footer>
          </b-card>
        </div>
        <!-- end of table card -->
      </div>
    </div>
  </fragment>
</template>

<script>
import VSwatches from "vue-swatches";
import { Head, Link } from "@inertiajs/inertia-vue";
import Verms from "@/Layouts/Verms.vue";
import GlobalComponents from "@/Components/Global";
import { Inertia } from "@inertiajs/inertia";
import {
  getFilter,
  getSort,
  getQuerySort,
  hasSort,
  hasFilter,
  hasPublish,
  getQueryStatus,
  hasSearch,
} from "@/Utils/venues";
import { toastAdd } from "@/Lib/toast";
export default {
  layout: Verms,
  props: {
    venues: {
      type: Object,
      default: {},
    },
    modal: {
      type: Boolean,
    },
  },
  components: {
    Head,
    Link,
    ...GlobalComponents,
    VSwatches,
  },  
  data() {
    const queries = route().params;
    let dsort = "new";
    let dstatus = "all";
    let dsearch = "";
    dsort = hasSort(queries) ? getQuerySort(queries.sort) : dsort;

    if (hasFilter(queries)) {
      dstatus = hasPublish(queries.filter)
        ? getQueryStatus(parseInt(queries.filter.is_publish))
        : dstatus;

      dsearch = hasSearch(queries.filter)
        ? route().params.filter.name
        : dsearch;
    }

    return {
      errors: null,
      isSubmitting: false,
      current_page: 1,
      venue: {
        name: "",
        legend: "#BDC3C8",
      },
      sort: dsort,
      sortOptions: [
        { text: "Newest", value: "new" },
        { text: "Oldest", value: "oldest" },
        { text: "Name", value: "name" },
      ],
      status: dstatus,
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
    toEdit: function (id) {
      Inertia.visit(route("verms.venues.details.index", { id }));
    },
    venueFormSubmit: function () {
      Inertia.post(route("verms.venues.store"), this.venue, {
        onProgress: () => {
          this.isSubmitting = true;
        },
        onError: (error) => {
          console.log(error);
          this.isSubmitting = false;
          this.errors = error;
          toastAdd("danger", "venue");
        },
        onSuccess: () => {
          this.isSubmitting = false;
          toastAdd("success", "venue");
        },
        preserveScroll: true,
      });
    },
    searchFormSubmit: function () {
      let sort = getSort(this.sort);
      let filter = getFilter(this.status, this.searchInput);
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
      let sort = getSort(n);
      let filter = getFilter(this.status);
      Inertia.visit(route("verms.venues.index", { sort, filter }), {
        preserveScroll: true,
      });
    },
    status: function (n) {
      let sort = getSort(this.sort);
      let filter = getFilter(n);
      Inertia.visit(route("verms.venues.index", { sort, filter }), {
        preserveScroll: true,
      });
    },
  },
  mounted() {
    this.current_page = this.venues.current_page;
    console.log(this.modal);
  },
};
</script>
