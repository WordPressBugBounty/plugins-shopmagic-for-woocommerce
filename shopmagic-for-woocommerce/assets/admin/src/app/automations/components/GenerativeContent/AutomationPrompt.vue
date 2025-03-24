<script setup lang="ts">
import { ref, computed, watch, onMounted } from "vue";
import { NIcon, NButton } from "naive-ui";
import { ColorWand } from "@vicons/ionicons5";

const props = withDefaults(
  defineProps<{
    disabled?: boolean;
    maxLength?: number;
    value: string;
  }>(),
  { disabled: false, maxLength: 1000, value: "" },
);

const emit = defineEmits<{
  (e: "update:value", value: string): void;
  (e: "submit"): void;
}>();

const inputValue = ref(props.value);
const isInputFocused = ref(false);
const textareaRef = ref(null);

watch(
  () => props.value,
  (newValue) => {
    if (newValue !== inputValue.value) {
      inputValue.value = newValue;
      resizeTextarea();
    }
  },
);

watch(inputValue, (newValue) => {
  emit("update:value", newValue);
  resizeTextarea();
});

function focusTextarea() {
  if (textareaRef.value && !props.disabled) {
    textareaRef.value.focus();
  }
}

function resizeTextarea() {
  if (!textareaRef.value) return;

  textareaRef.value.style.height = "auto";
  textareaRef.value.style.height = Math.min(200, textareaRef.value.scrollHeight) + "px";
}

function updateTextarea() {
  resizeTextarea();
}

onMounted(() => {
  resizeTextarea();
});

function handleSubmit() {
  if (canSendMessage.value) {
    emit("submit");
  }
}

const canSendMessage = computed(() => !props.disabled && inputValue.value.trim() !== "");
</script>

<template>
  <div
    class="input-container"
    :class="{
      'input-container-focus': isInputFocused,
      'input-container-disabled': disabled,
      'input-container-warning': inputValue.length > 900,
    }"
    @click="focusTextarea"
  >
    <textarea
      ref="textareaRef"
      v-model="inputValue"
      class="shopmagic-prompt-input"
      :disabled="disabled"
      :maxlength="maxLength"
      rows="4"
      :placeholder="
        __(
          'Send a thank you email with a 15% discount code 7 days after purchase',
          'shopmagic-for-woocommerce',
        )
      "
      @focus="isInputFocused = true"
      @blur="isInputFocused = false"
      autofocus
    ></textarea>

    <div class="char-counter" v-if="inputValue.length > 900">
      {{ inputValue.length }}/{{ maxLength }}
    </div>
    <NButton
      class="shopmagic-generate-button"
      type="primary"
      @click="handleSubmit"
      :disabled="!canSendMessage"
      icon-placement="right"
    >
      <template #icon>
        <NIcon>
          <ColorWand />
        </NIcon>
      </template>
    </NButton>
  </div>
</template>

<style scoped>
.input-container {
  box-sizing: border-box;
  width: 100%;
  border-radius: 8px;
  border: 1px solid #ddd;
  padding: 12px;
  transition: all 0.2s ease;
  position: relative;
  background: #fff;
  cursor: text;
}

.input-container:hover {
  border-color: #50c878;
}

.input-container-focus {
  border-color: #36ad6a;
  box-shadow: 0 0 0 2px rgba(0, 115, 170, 0.2);
}

.input-container-disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.input-container-warning {
  border-color: #f0ad4e;
}

.input-container-warning .char-counter {
  color: #f0ad4e;
}

.char-counter {
  position: absolute;
  bottom: 12px;
  left: 12px;
  font-size: 12px;
  color: #666;
  background: rgba(255, 255, 255, 0.8);
  padding: 2px 6px;
  border-radius: 4px;
}

.shopmagic-prompt-input {
  width: 100%;
  border: 0;
  outline: none;
  resize: none;
  background: transparent;
  min-height: 100px;
  box-shadow: none;
}

.shopmagic-generate-button {
  margin-left: auto;
  width: auto;
  display: flex;
  align-items: center;
}
</style>
