<template>
  <fragment>
    <Head>
      <title>VERMS | Media</title>
      <meta name="description" content="manage media..." />
    </Head>
    <BBackground class="container is-fluid py-5 mb-5" color="info">
      <BH3 color="info" light type="title" text="Media" />
      <BH4
        color="info"
        light
        type="subtitle"
        text="Manage all your media here..."
      />
    </BBackground>
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
              type="is-primary"
              icon-pack="bi"
              icon-left="upload"
              label="Upload Images"
             
            />
          </div>
          <div class="mb-5">
            <BBackground color="light" class="p-2 mb-4">
              <span class="is-italic">12 results</span>
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
          <div class="columns is-multiline">
            <div class="column is-one-quarter" v-for="i in 12" :key="i">
              <div class="is-relative">
                <img
                  :style="{
                    height: '200px',
                    width: '200px',
                    'object-fit': 'cover',
                  }"
                  class="is-absolute"
                  :src="`https://picsum.photos/id/${i}/200/300`"
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
import { Head, Link } from "@inertiajs/inertia-vue";
import Verms from "@/Layouts/Verms.vue";
import BCard from "@/Components/BCard/BCard.vue";
import BCardHeader from "@/Components/BCard/BCardHeader.vue";
import BCardContent from "@/Components/BCard/BCardContent.vue";
import BCardFooter from "@/Components/BCard/BCardFooter.vue";
import BBackground from "@/Components/BBackground.vue";
import GlobalComponents from "@/Components/Global";


export default {
  layout: Verms,
  components: { 
    ...GlobalComponents,
    Head,
    Link,
    BCard,
    BCardHeader,
    BCardContent,
    BCardFooter,
    BBackground
  },
};
</script>

<style lang="scss" scoped></style>
