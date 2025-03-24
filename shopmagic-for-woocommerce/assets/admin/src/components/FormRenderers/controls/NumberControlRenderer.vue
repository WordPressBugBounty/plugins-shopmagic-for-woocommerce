<script setup lang="ts">
import { NInputNumber } from "naive-ui";
import { computed } from "vue";
import type { ControlElement } from "@jsonforms/core";
import { rendererProps, type RendererProps, useJsonFormsControl } from "@jsonforms/vue";
import { useVanillaControl } from "../util";
import FieldWrapper from "./FieldWrapper.vue";

const props = defineProps(rendererProps<ControlElement>());

const { control, controlWrapper, onChange } = useVanillaControl(useJsonFormsControl(props));
</script>
<template>
  <FieldWrapper v-bind="controlWrapper">
    <NInputNumber
      :id="control.id + '-input'"
      :default-value="control.schema.default"
      :disabled="!control.enabled"
      :placeholder="control.schema?.examples?.[0] ?? ''"
      :readonly="control.schema.readOnly"
      :value="control.data"
      @update:value="onChange"
    />
  </FieldWrapper>
</template>
<style scoped>
.n-input-number {
  width: 100%;
}
</style>
