<template>
  <fragment>
    <div class="is-flex is-justify-content-center">
      <BCard :style="{ width: '602px' }">
        <BCardContent v-if="detail !== null">
          <form @submit.prevent="formSubmit">
            <BField label="Name" class="mb-5">
              <BInput v-model="detail.name"></BInput>
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
import VenueEdit from "@/Layouts/VenueEdit.vue";
import { Link } from "@inertiajs/inertia-vue";
import GlobalComponents from "@/Components/Global";
import BCard from "@/Components/BCard/BCard.vue";
import BCardContent from "@/Components/BCard/BCardContent.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
  layout: VenueEdit,
  props: ["venue"],
  components: {
    ...GlobalComponents,
    Link,
    BCard,
    BCardContent,
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
            this.$buefy.toast.open({
              position: "is-bottom",
              duration: 3000,
              message: `An error has occured...`,
              type: "is-danger",
            });
          },
          onSuccess: () => {
            this.isSubmitting = false;
            this.$buefy.toast.open({
              position: "is-bottom",
              duration: 3000,
              message: `Venue has been updated...`,
              type: "is-success",
            });
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
