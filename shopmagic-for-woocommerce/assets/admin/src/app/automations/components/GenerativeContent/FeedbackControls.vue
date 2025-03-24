<script setup lang="ts">
import { computed } from "vue";
import { NButton, NIcon } from "naive-ui";
import { ThumbsUpOutline, ThumbsDownOutline } from "@vicons/ionicons5";
import { __ } from "../../../../plugins/i18n";

const props = defineProps<{
  currentVote: int<-1, 1> | null;
}>();

const emit = defineEmits<{
  (e: "vote", isPositive: boolean): void;
}>();

const isPositiveVoteActive = computed(() => props.currentVote === 1);
const isNegativeVoteActive = computed(() => props.currentVote === -1);

function handleVote(isPositive) {
  emit("vote", isPositive);
}
</script>

<template>
  <div class="feedback">
    <span class="feedback-label">{{ __("Was this helpful?", "shopmagic-for-woocommerce") }}</span>
    <div class="voting-buttons">
      <NButton
        @click="handleVote(true)"
        title="This automation is helpful"
        circle
        :type="isPositiveVoteActive ? 'primary' : 'default'"
      >
        <template #icon>
          <NIcon>
            <ThumbsUpOutline />
          </NIcon>
        </template>
      </NButton>
      <NButton
        @click="handleVote(false)"
        title="This automation is not helpful"
        circle
        :type="isNegativeVoteActive ? 'primary' : 'default'"
      >
        <template #icon>
          <NIcon>
            <ThumbsDownOutline />
          </NIcon>
        </template>
      </NButton>
    </div>
  </div>
</template>

<style scoped>
.feedback {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 12px;
  margin-top: 12px;
}

.feedback-label {
  font-size: 13px;
  color: #666;
}

.voting-buttons {
  display: flex;
  gap: 8px;
}
</style>
