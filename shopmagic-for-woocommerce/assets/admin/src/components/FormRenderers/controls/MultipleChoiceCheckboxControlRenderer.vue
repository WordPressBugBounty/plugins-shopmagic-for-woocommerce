<script lang="ts" setup>
import { NCheckbox, NCheckboxGroup } from "naive-ui";
import {
  type ControlElement,
  mapDispatchToControlProps,
  mapStateToControlProps,
} from "@jsonforms/core";
import { computed } from "vue";
import { rendererProps, useJsonFormsOneOfEnumControl, useControl } from "@jsonforms/vue";
import { useVanillaControl } from "../util";
import FieldWrapper from "./FieldWrapper.vue";

const props = defineProps(rendererProps<ControlElement>());
const { control, controlWrapper, onChange } = useVanillaControl(
  useControl(props, mapStateToControlProps, mapDispatchToControlProps),
);

const options = computed(() => {
  const items = control.value.schema.items?.oneOf || control.value.schema.items?.anyOf || [];

  return items
    .filter((s) => s.title)
    .map((s) => ({
      label: s.title,
      value: s.const,
    }));
});
</script>
<template>
  <FieldWrapper v-bind="controlWrapper">
    <NCheckboxGroup
      :default-value="[control.schema.default]"
      :value="control.data"
      @update:value="onChange"
    >
      <NCheckbox
        v-for="(checkbox, i) in options"
        :key="i"
        :label="checkbox.label"
        :value="checkbox.value"
      >
      </NCheckbox>
    </NCheckboxGroup>
  </FieldWrapper>
</template>
