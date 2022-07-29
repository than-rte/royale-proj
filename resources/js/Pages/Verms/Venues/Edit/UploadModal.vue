<template>
  <form @submit.prevent="formSubmitUpload">
    <BCard :style="{ width: '900px' }">
      <BCardHeader class="has-background-light">
        <h5 class="card-header-title">
          <BIcon pack="bi" icon="file-plus" class="mr-2" />
          Upload Image
          <div class="ml-4">{{ px }}%</div>
        </h5>
      </BCardHeader>
      <BCardContent>
        <BField>
          <BUpload v-model="form.files" multiple drag-drop expanded>
            <section class="section">
              <div class="content has-text-centered">
                <p>
                  <b-icon icon="upload" size="is-large"> </b-icon>
                </p>
                <p>Drop your files here or click to upload</p>
              </div>
            </section>
          </BUpload>
        </BField>
        <BField label="Images to upload">
          <div
            v-if="form.files.length > 0"
            class="tags"
            style="overflow-y: auto; max-height: 168px"
          >
            <span
              v-for="(file, index) in form.files"
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
          <div v-else class="">no images selected</div>
        </BField>
      </BCardContent>
      <BCardFooter
        class="px-5 py-4 is-flex is-justify-content-flex-end is-align-items-center"
      >
        <BButton
          class="mr-2"
          label="Cancel"
          icon-right="x-circle"
          @click="$emit('close')"
          :disabled="isUploading"
        />
        <BButton
          native-type="submit"
          type="is-primary"
          icon-right="plus-lg"
          label="Add Images"
          :disabled="isUploading"
        />
      </BCardFooter>
    </BCard>
  </form>
</template>

<script>
import BCard from "@/Components/BCard/BCard.vue";
import BCardHeader from "@/Components/BCard/BCardHeader.vue";
import BCardContent from "@/Components/BCard/BCardContent.vue";
import BCardFooter from "@/Components/BCard/BCardFooter.vue";
import { Inertia } from "@inertiajs/inertia";
import { toastUpload } from "@/Lib/toast";
export default {
  props: ["venue"],
  components: {
    BCard,
    BCardHeader,
    BCardContent,
    BCardFooter,
  },
  data() {
    return {
      form: {
        files: [],
      },
      px: 0,
      isUploading: false,
      cancelToken: null,
    };
  },
  methods: {
    deleteDropFile: function (index) {
      this.form.files.splice(index, 1);
    },
    formSubmitUpload: async function () {
      Inertia.post(
        route("verms.venues.media.upload", this.venue.id),
        this.form,
        {
          onCancelToken: (cancelToken) => (this.cancelToken = cancelToken),
          forceFormData: true,
          onStart: () => {
            this.isUploading = true;
          },
          onProgress: (progress) => {
            this.px = progress.percentage;
          },
          onFinish: () => {
            this.isUploading = false;
          },
          onSuccess: () => {
            this.isUploading = false;
            toastUpload('success', 'images');
            this.$emit('close');
          },
          onError: () => {
             toastUpload('danger', 'images');
            this.isUploading = false;
          },
        }
      );
    },
  },
  mounted() {},
};
</script>

<style lang="scss" scoped></style>
