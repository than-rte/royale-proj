<template>
  <fragment>
    <Head>
      <title>VERMS | Venues - Details</title>
    </Head>
    <div class="is-flex is-justify-content-center">
      <BCard :style="{ width: '602px' }">
        <BCardContent v-if="detail !== null">
          <form @submit.prevent="formSubmit">
            <BField label="Name" class="mb-5">
              <BInput v-model="detail.name"></BInput>
            </BField>
            <b-field label="Legend" grouped>
              <b-input name="legend" expanded readonly v-model="detail.legend" />
              <v-swatches
                v-model="detail.legend"
                show-fallback
                fallback-input-type="color"
                popover-x="left"
              />
            </b-field>
            <BField label="Capacity">
              <!-- <input name="capacity" type="hidden" /> -->
              <BNumberinput
                v-model="detail.capacity"
                type="is-dark"
                icon-pack="bi"
                min="0"
              />
            </BField>
            <BField label="Body" class="mb-5">
              <BInput type="textarea" rows="7" v-model="detail.body"></BInput>
            </BField>
            <BField>
              <BSwitch v-model="detail.is_publish">
                {{ getPublish }}
              </BSwitch>
            </BField>
            <div class="is-flex is-justify-content-flex-start mb-5">
              <BButton
                native-type="submit"
                type="is-primary"
                icon-pack="bi"
                icon-left="pencil-square"
                label="Update Details"
                :disabled="isSubmitting"
              />
            </div>
          </form>
        </BCardContent>
      </BCard>
    </div>
  </fragment>
</template>

<script>
import VSwatches from "vue-swatches";
import VenueEdit from "@/Layouts/VenueEdit.vue";
import { Link, Head } from "@inertiajs/inertia-vue";
import GlobalComponents from "@/Components/Global";
import { Inertia } from "@inertiajs/inertia";
import { toastUpdate } from "@/Lib/toast";
export default {
  layout: VenueEdit,
  props: ["venue"],
  components: {
    ...GlobalComponents,
    Head,
    Link,
    VSwatches,
  },
  data() {
    return {
      detail: null,
      isSubmitting: false,
    };
  },
  computed: {
    getPublish: {
      get: function () {
        return this.detail.is_publish ? "Published" : "Unpublished";
      },
    },
  },
  methods: {
    formSubmit() {
      console.log("went here...");
      Inertia.patch(
        route("verms.venues.details.update", this.venue.id),
        this.detail,
        {
          onProgress: () => {
            this.isSubmitting = true;
          },
          onError: () => {
            this.isSubmitting = false;
            toastUpdate("danger", "venue");
          },
          onSuccess: () => {
            this.isSubmitting = false;
            toastUpdate("success", "venue");
          },
          preserveScroll: true,
        }
      );
    },
  },
  mounted() {
    this.detail = this.venue;
  },
};
</script>

<style lang="scss" scoped></style>
