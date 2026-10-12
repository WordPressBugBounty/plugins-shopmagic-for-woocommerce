<script lang="ts" setup>
import { NSwitch, NTooltip, useMessage } from "naive-ui";
import { computed, ref } from "vue";
import type { Automation } from "@/types/automation";
import { useWpFetch } from "@/composables/useWpFetch";
import { revalidateAutomations } from "@/app/automations/store";
import { __ } from "@/plugins/i18n";

const props = defineProps<{ automation: Automation }>();
const saving = ref(false);
const message = useMessage();
const statusLabel = computed(() => {
  if (props.automation.status === "trash") {
    return __("Trashed automation", "shopmagic-for-woocommerce");
  }

  return props.automation.status === "publish"
    ? __("Published — click to unpublish", "shopmagic-for-woocommerce")
    : __("Draft — click to publish", "shopmagic-for-woocommerce");
});

async function updateStatus(status: "publish" | "draft") {
  const previousStatus = props.automation.status;
  props.automation.status = status;
  saving.value = true;

  const { error } = await useWpFetch(`/automations/${props.automation.id}/status`).patch({ status });
  saving.value = false;

  if (error.value) {
    props.automation.status = previousStatus;
    message.error(
      __(
        "The automation status could not be changed. Please try again.",
        "shopmagic-for-woocommerce",
      ),
    );
    return;
  }

  revalidateAutomations();
}
</script>

<template>
  <NTooltip>
    <template #trigger>
      <NSwitch
        :aria-label="statusLabel"
        :disabled="automation.status === 'trash'"
        :loading="saving"
        :value="automation.status"
        checked-value="publish"
        unchecked-value="draft"
        @update:value="updateStatus"
      />
    </template>
    {{ statusLabel }}
  </NTooltip>
</template>
