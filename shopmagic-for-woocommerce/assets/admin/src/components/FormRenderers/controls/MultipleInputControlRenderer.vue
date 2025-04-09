<script lang="ts" setup>
import { NButton, NInput, NInputGroup, NIcon } from "naive-ui";
import { TrashOutline } from "@vicons/ionicons5";
import { rendererProps, useJsonFormsControl, type ControlElement } from "@jsonforms/vue";
import { useVanillaControl } from "../util";
import FieldWrapper from "./FieldWrapper.vue";
import { ref, watch, computed } from "vue";
import { __ } from "@/plugins/i18n";
import { isObject } from "@vueuse/core";

interface KeyValuePair {
  key: string;
  value: string;
}

const props = defineProps(rendererProps<ControlElement>());
const { control, controlWrapper, onChange } = useVanillaControl(useJsonFormsControl(props));

console.log(control.data)

// Helper to transform { key: value } object to [{ key: 'key', value: 'value' }] array
function transformToArray(data: unknown): KeyValuePair[] {
  if (!isObject(data) || Array.isArray(data)) {
    return [];
  }
  return Object.entries(data).map(([key, value]) => ({ key, value: String(value) }));
}

// Helper to transform [{ key: 'key', value: 'value' }] array to { key: value } object
function transformToObject(pairs: KeyValuePair[]): Record<string, string> {
  return pairs.reduce((obj, pair) => {
    // Only include pairs where the key is not empty
    if (pair.key.trim() !== "") {
      obj[pair.key] = pair.value;
    }
    return obj;
  }, {} as Record<string, string>);
}

const keyValuePairs = ref<KeyValuePair[]>(transformToArray(control.value.data));

function addRow() {
  keyValuePairs.value.push({ key: "", value: "" });
  onChange(transformToObject(keyValuePairs.value));
}

function removeRow(index: number) {
  keyValuePairs.value.splice(index, 1);
  onChange(transformToObject(keyValuePairs.value));
}

function updateRow(index: number, field: "key" | "value", newValue: string) {
  if (keyValuePairs.value[index]) {
    keyValuePairs.value[index][field] = newValue;
    onChange(transformToObject(keyValuePairs.value));
  }
}

const label = computed(() => control.value.label);
const description = computed(() => control.value.schema.description);
const errors = computed(() => control.value.errors);

</script>
<template>
  <FieldWrapper :label="label" :description="description" :errors="errors">
    <div class="flex flex-col gap-y-2">
      <NInputGroup v-for="(pair, index) in keyValuePairs" :key="index" class="flex items-center gap-x-2">
        <NInput
          :placeholder="__('Key', 'shopmagic-for-woocommerce')"
          :value="pair.key"
          @update:value="(v) => updateRow(index, 'key', v)"
        />
        <NInput
          :placeholder="__('Value', 'shopmagic-for-woocommerce')"
          :value="pair.value"
          @update:value="(v) => updateRow(index, 'value', v)"
        />
        <NButton text type="error" @click="() => removeRow(index)">
          <template #icon>
            <NIcon><TrashOutline /></NIcon>
          </template>
        </NButton>
      </NInputGroup>
      <NButton @click="addRow" type="primary" ghost>
        {{ __("Add", "shopmagic-for-woocommerce") }}
      </NButton>
    </div>
  </FieldWrapper>
</template>
