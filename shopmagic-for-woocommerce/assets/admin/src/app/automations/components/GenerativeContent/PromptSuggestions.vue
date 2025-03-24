<script setup lang="ts">
import { __ } from "../../../../plugins/i18n";

const props = defineProps<{
  disabled?: boolean;
}>();

const emit = defineEmits<{
  (e: "select", suggestion: string): void;
}>();

const suggestions = [
  {
    id: 1,
    text: __("Recover abandoned carts", "shopmagic-for-woocommerce"),
    prompt: __(
      "Create an automation that sends an email reminder to customers who abandoned their shopping carts with a 10% discount code to incentivize purchase completion",
      "shopmagic-for-woocommerce",
    ),
  },
  {
    id: 2,
    text: __("Welcome new customers", "shopmagic-for-woocommerce"),
    prompt: __(
      "Create a welcome email automation for new customers that includes store information, a thank you message, and a small discount for their next purchase",
      "shopmagic-for-woocommerce",
    ),
  },
  {
    id: 3,
    text: __("Review request after purchase", "shopmagic-for-woocommerce"),
    prompt: __(
      "Create an automation that sends an email asking for a product review 7 days after a customer completes their purchase",
      "shopmagic-for-woocommerce",
    ),
  },
];

function selectSuggestion(suggestion) {
  emit("select", suggestion.prompt);
}
</script>

<template>
  <div class="suggestions-container">
    <div class="suggestions-grid">
      <button
        v-for="suggestion in suggestions"
        :key="suggestion.id"
        class="suggestion-button"
        :disabled="props.disabled"
        @click="selectSuggestion(suggestion)"
      >
        {{ suggestion.text }}
      </button>
    </div>
  </div>
</template>

<style scoped>
.suggestions-container {
  margin-top: 20px;
  animation: fadeIn 0.3s ease-in-out;
}

.suggestions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 10px;
}

.suggestion-button {
  padding: 12px 16px;
  background: #f8f9fa;
  border: 1px solid #ddd;
  border-radius: 8px;
  cursor: pointer;
  text-align: left;
  font-size: 14px;
  transition: all 0.2s ease;
  color: #333;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.suggestion-button:hover {
  background: #eef2f5;
  border-color: #0073aa;
}

.suggestion-button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
