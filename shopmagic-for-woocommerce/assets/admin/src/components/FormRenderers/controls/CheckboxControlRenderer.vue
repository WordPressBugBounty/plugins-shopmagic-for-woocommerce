<script lang="ts" setup>
import { NCheckbox } from "naive-ui";
import { type ControlElement } from "@jsonforms/core";
import { computed } from "vue";
import { rendererProps, useJsonFormsControl } from "@jsonforms/vue";
import { useVanillaControl } from "../util";
import FieldWrapper from "./FieldWrapper.vue";

const props = defineProps(rendererProps<ControlElement>());
const { control, controlWrapper, onChange } = useVanillaControl(useJsonFormsControl(props));
</script>
<template>
  <FieldWrapper :show-label="false" v-bind="controlWrapper">
    <NCheckbox
      :id="control.id + '-input'"
      :checked="!!control.data"
      :checked-value="true"
      :default-checked="control.schema.default"
      :disabled="!control.enabled"
      :label="control.label"
      :unchecked-value="false"
      @blur="isFocused = false"
      @focus="isFocused = true"
      @update:checked="onChange"
    />
  </FieldWrapper>
</template>
