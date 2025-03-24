<script lang="ts" setup>
import {
  isScoped,
  type Layout,
  mapDispatchToControlProps,
  mapStateToLayoutProps,
  resolveSchema,
} from "@jsonforms/core";
import { NInput, NButton } from "naive-ui";
import { type LayoutProps, rendererProps, useControl } from "@jsonforms/vue";
import { useVanillaLayout } from "../util";
import FieldWrapper from "./FieldWrapper.vue";
import { ref } from "vue";

const useJsonFormsLayout = (props: LayoutProps) => {
  const { control, ...other } = useControl(props, mapStateToLayoutProps, mapDispatchToControlProps);
  return { layout: control, ...other };
};

const props = defineProps(rendererProps<Layout>());
const { handleChange, layout } = useVanillaLayout(useJsonFormsLayout(props));

const additionalFieldsRef = ref([]);
</script>
<template>
  <FieldWrapper v-for="(field, index) in layout.data">
    {{ field }} {{ index }}
    <NInput />
    <NInput />
  </FieldWrapper>
  <NButton>Add field</NButton>
</template>
