<script lang="ts" setup>
import { NA, NInput } from "naive-ui";
import { useDebounceFn, useFetch } from "@vueuse/core";
import { ref } from "vue";

const debouncedSearch = useDebounceFn((query: string) => {
  useFetch(
    `https://api.shopmagic.app/v1/docs?query=${query}`,
  )
    .json()
    .then(({ data }) => {
      articles.value = data.value?.articles.items;
    });
}, 600);
const articles = ref([]);
</script>
<template>
  <NInput
    :placeholder="__('Search support articles...', 'shopmagic-for-woocommerce')"
    class="mb-4"
    @update:value="debouncedSearch"
  />
  <ul>
    <li v-for="(doc, i) in articles" :key="i">
      <NA :href="doc.url" target="_blank">
        {{ doc.name }}
      </NA>
    </li>
  </ul>
</template>
