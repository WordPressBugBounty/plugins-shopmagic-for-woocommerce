<script setup lang="ts">
import { NButton, NIcon, NP } from "naive-ui";
import { OpenOutline, RepeatOutline } from "@vicons/ionicons5";
import { __ } from "../../../../plugins/i18n";
import type { Automation } from "@/types/automation";
import FeedbackControls from "./FeedbackControls.vue";
import Markdown from "./MarkdownRenderer.vue";

const props = withDefaults(
  defineProps<{
    isLoading?: boolean;
    description?: string;
    automation?: Automation | null;
    userVote?: int<-1, 1> | null;
    waitingMessage?: string;
  }>(),
  {
    isLoading: false,
    description: "",
    automation: null,
    userVote: null,
    waitingMessage: "",
  },
);

const emit = defineEmits<{
  (e: "open"): void;
  (e: "reset"): void;
  (e: "vote", isPositive: boolean): void;
}>();

function handleVote(isPositive) {
  emit("vote", isPositive);
}
</script>

<template>
  <div class="results-area">
    <div v-if="isLoading" class="loading-state">
      <div class="shopmagic-spinner"></div>
      <p>{{ waitingMessage }}</p>
    </div>

    <div v-else class="result-content">
      <div class="generated-description">
        <Markdown>{{ description }}</Markdown>
      </div>

      <div class="automation-actions">
        <NButton
          v-if="automation"
          class="primary-button"
          @click="$emit('open')"
          type="primary"
          icon-placement="right"
        >
          <template #icon>
            <NIcon>
              <OpenOutline />
            </NIcon>
          </template>
          {{ __("Save & Open", "shopmagic-for-woocommerce") }}
        </NButton>

        <NButton @click="$emit('reset')" :type="automation ? 'default' : 'primary'">
          <template #icon>
            <NIcon>
              <RepeatOutline />
            </NIcon>
          </template>
          {{ __("Reset", "shopmagic-for-woocommerce") }}
        </NButton>
      </div>

      <FeedbackControls v-if="automation" :currentVote="userVote" @vote="handleVote" />
    </div>
  </div>
</template>

<style scoped>
.results-area {
  box-sizing: border-box;
  width: 100%;
  padding: 24px;
  margin-top: 24px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
  animation: fadeIn 0.3s ease-in-out;
}

.loading-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 30px 0;
}

.shopmagic-spinner {
  border: 3px solid rgba(0, 0, 0, 0.1);
  border-radius: 50%;
  border-top: 3px solid #50c878;
  width: 30px;
  height: 30px;
  animation: spin 1.5s linear infinite;
  margin-bottom: 12px;
}

.generated-description {
  background: #f8f9fa;
  padding: 16px;
  border-radius: 8px;
  margin-bottom: 20px;
  line-height: 1.5;
}

.automation-actions {
  display: flex;
  gap: 12px;
  width: 100%;

  & > button {
    width: 20%;
  }

  & > .primary-button {
    width: 80%;
    flex-shrink: 1;
  }
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

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
