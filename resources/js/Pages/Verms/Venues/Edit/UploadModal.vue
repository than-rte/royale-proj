<template>
  <BCard :style="{ width: '900px' }">
    <BCardHeader class="has-background-light">
      <h5 class="card-header-title">
        <BIcon pack="bi" icon="file-plus" class="mr-2" />
        Upload Image
      </h5>
    </BCardHeader>
    <BCardContent>
      <b-field>
        <b-upload v-model="dropFiles" multiple drag-drop expanded>
          <section class="section">
            <div class="content has-text-centered">
              <p>
                <b-icon icon="upload" size="is-large"> </b-icon>
              </p>
              <p>Drop your files here or click to upload</p>
            </div>
          </section>
        </b-upload>
      </b-field>
      <b-field label="Images to upload">
        <div v-if="dropFiles.length > 0" class="tags" style="overflow-y: auto; max-height: 168px">
          <span
            v-for="(file, index) in dropFiles"
            :key="index"
            class="tag is-primary"
          >
            {{ file.name }}
            <button
              class="delete is-small"
              type="button"
              @click="deleteDropFile(index)"
            ></button>
          </span>
        </div>
        <div v-else class="">
          no images selected
        </div>
      </b-field>
    </BCardContent>
    <BCardFooter
      class="px-5 py-4 is-flex is-justify-content-flex-end is-align-items-center"
    >
      <BButton
        class="mr-2"
        label="Cancel"
        icon-right="x-circle"
        @click="$emit('close')"
      />
      <BButton type="is-primary" icon-right="plus-lg" label="Add Images" />
    </BCardFooter>
  </BCard>
</template>

<script>
import BCard from "@/Components/BCard/BCard.vue";
import BCardHeader from "@/Components/BCard/BCardHeader.vue";
import BCardContent from "@/Components/BCard/BCardContent.vue";
import BCardFooter from "@/Components/BCard/BCardFooter.vue";
export default {
  components: {
    BCard,
    BCardHeader,
    BCardContent,
    BCardFooter,
  },
  data() {
    return {
      dropFiles: [],
    };
  },
  methods: {
    deleteDropFile(index) {
      this.dropFiles.splice(index, 1);
    },
  },
};
</script>

<style lang="scss" scoped></style>
