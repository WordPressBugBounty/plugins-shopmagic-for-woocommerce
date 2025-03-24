<script lang="ts" setup>
import { NSelect, NTag, type SelectRenderTag } from "naive-ui";
import {
  type ControlElement,
  mapDispatchToControlProps,
  mapStateToControlProps,
} from "@jsonforms/core";
import { rendererProps, useJsonFormsOneOfEnumControl, useControl } from "@jsonforms/vue";
import { useVanillaControl } from "../util";
import FieldWrapper from "./FieldWrapper.vue";
import { ref, h, computed } from "vue";

const props = defineProps(rendererProps<ControlElement>());
const { control, controlWrapper, onChange } = useVanillaControl(
  useControl(props, mapStateToControlProps, mapDispatchToControlProps),
);
const controlRef = ref(control);

const isMultipleSelect = computed(() => control.value.schema.type === "array");

const renderTag: SelectRenderTag = ({ option, handleClose }) => {
  // Value may be string or int. Compare loosely
  const label = options.value.find((formOption) => formOption.value == option.value);
  if (controlRef.value.schema?.uniqueItems) {
    return h(
      NTag,
      { closable: true, onClose: handleClose },
      { default: () => label?.label || option.label },
    );
  }

  return label?.label || option.label;
};

const options = computed(() => {
  let items;
  if (isMultipleSelect.value) {
    items = control.value.schema.items?.oneOf || control.value.schema.items?.anyOf || [];
  } else {
    items = control.value.schema?.oneOf || control.value.schema?.anyOf || [];
  }

  return items
    .filter((s) => s.title)
    .map((s) => ({
      label: s.title,
      value: s.const,
    }));
});

const isFilterable = computed(() => options.value.length > 5);
</script>
<template>
  <FieldWrapper v-bind="controlWrapper">
    <NSelect
      :id="control.id + '-input'"
      :consistent-menu-width="false"
      :default-value="control.schema.default"
      :disabled="!control.enabled"
      :filterable="isFilterable"
      :multiple="isMultipleSelect"
      :options="options"
      :placeholder="control.schema?.examples?.[0] ?? ''"
      :readonly="control.schema.readOnly"
      :value="control.data"
      :render-tag="renderTag"
      class="min-w-[140px] w-full"
      @update:value="onChange"
    />
  </FieldWrapper>
</template>
