<template>
  <fragment>
    <div class="is-flex is-justify-content-center">
      <BCard :style="{ width: '900px' }">
        <BCardHeader class="has-background-light">
          <h5 class="card-header-title">
            <BIcon pack="bi" icon="list" class="mr-2" />
            Image List
          </h5>
        </BCardHeader>
        <BCardContent>
          <div class="mb-5 is-flex is-justify-content-flex-start">
            <BButton
              @click="openUpload"
              type="is-primary"
              icon-pack="bi"
              icon-left="upload"
              label="Upload Images"
             
            />
          </div>
          <div class="mb-5">
            <BBackground color="light" class="p-2 mb-4">
              <span v-if="venue.images.length > 0" class="is-italic">{{ venue.images.length }} results</span>
              <span v-else class="is-italic">no images found</span>
            </BBackground>
            <div class="is-flex is-justify-content-space-between p-2 mb-4">
              <BField>
                <BCheckbox>select all</BCheckbox>
              </BField>
              <BButton
                type="is-danger"
                icon-pack="bi"
                icon-left="trash"
                size="is-small"
                label="Delete selected"
              />
            </div>
          </div>
          <div v-if="venue.images.length > 0" class="columns is-multiline">
            <div class="column is-one-quarter" v-for="image in venue.images" :key="image.id">
              <div class="is-relative">
                <img
                  :style="{
                    height: '200px',
                    width: '200px',
                    'object-fit': 'cover',
                  }"
                  class="is-absolute"
                  :src="image.src"
                  :alt="image.alt"
                />
                <div class="image-overlay">
                  <div class="is-flex is-justify-content-flex-end">
                    <BButton
                      type="is-danger"
                      size="is-small"
                      icon-pack="bi"
                      icon-left="trash"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </BCardContent>
        <BCardFooter></BCardFooter>
      </BCard>
    </div>
  </fragment>
</template>

<script>
import VenueEdit from "@/Layouts/VenueEdit.vue";
import BCard from "@/Components/BCard/BCard.vue";
import BCardHeader from "@/Components/BCard/BCardHeader.vue";
import BCardContent from "@/Components/BCard/BCardContent.vue";
import BCardFooter from "@/Components/BCard/BCardFooter.vue";
import BBackground from "@/Components/BBackground.vue";
import UploadModal from "./UploadModal.vue";

export default {
  layout: VenueEdit,
  props: ["venue"],
  components: {
    BCard,
    BCardHeader,
    BCardContent,
    BCardFooter,
    BBackground,
  },
  methods: {
    openUpload: function () {
      this.$buefy.modal.open({
        parent: this,
        component: UploadModal,
        hasModalCard: true,
        customClass: "custom-class custom-class-2",
        trapFocus: true,
        canCancel: false,
        props: {
          venue: this.venue,
        },
      });
    },
  },
};
</script>

<style lang="scss" scoped></style>
