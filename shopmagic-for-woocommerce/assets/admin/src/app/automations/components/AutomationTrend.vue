<script lang="ts" setup>
import { computed } from "vue";
import { sprintf } from "@/plugins/i18n";

const props = defineProps<{ values: number[] }>();
const width = 72;
const height = 26;
const max = computed(() => Math.max(...props.values, 1));
const points = computed(() =>
  props.values
    .map((value, index) => {
      const x = (index / Math.max(props.values.length - 1, 1)) * width;
      const y = height - 2 - (value / max.value) * (height - 4);
      return `${x},${y}`;
    })
    .join(" "),
);
const total = computed(() => props.values.reduce((sum, value) => sum + value, 0));
</script>

<template>
  <svg
    v-if="total > 0"
    class="automation-trend"
    :aria-label="
      sprintf(
        __('%d executions during the last 14 days', 'shopmagic-for-woocommerce'),
        total,
      )
    "
    :viewBox="`0 0 ${width} ${height}`"
    role="img"
  >
    <polyline :points="points" />
  </svg>
</template>

<style scoped>
.automation-trend {
  color: #2271b1;
  display: block;
  height: 26px;
  width: 72px;
}

.automation-trend polyline {
  fill: none;
  stroke: currentColor;
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke-width: 2;
}
</style>
