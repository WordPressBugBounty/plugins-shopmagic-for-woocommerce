<script lang="ts" setup>
import DataTable from "@/components/Table/DataTable.vue";
import { computed, ref } from "vue";
import { automationSubTable } from "@/app/automations/data/subtable";
import type { Automation, AutomationData, AutomationMetrics } from "@/types/automation";
import { get } from "@/_utils";
import { appendSearchParams } from "@/composables/useSearchParams";
import { storeToRefs } from "pinia";
import { useAutomationResourcesStore } from "@/app/automations/resourceStore";

const props = defineProps<{
  automation: Automation;
}>();

const automations = ref<Automation[]>([]);
const metrics = ref<Record<number, AutomationMetrics> | null>(null);
const { events, actions: actionsStore } = storeToRefs(useAutomationResourcesStore());

get<Automation[]>(props.automation._links.children.href).then((a) => {
  automations.value = a;
  const ids = a.map(({ id }) => id).filter((id): id is number => id !== null);
  if (ids.length === 0) {
    metrics.value = {};
    return;
  }

  void get<Record<number, AutomationMetrics>>(
    appendSearchParams("/automations/metrics", { filters: { ids } }),
  )
    .then((result) => {
      metrics.value = result;
    })
    .catch(() => {
      metrics.value = null;
    });
});

const checkedRows = ref([]);

const data = computed<AutomationData[]>(() =>
  automations.value
    .filter((automation): automation is Automation & { id: number } => automation.id !== null)
    .map((automation) => {
      const event = events.value?.find((item) => automation.event.name === item.value);
      const actions = actionsStore.value
        ?.filter((item) => automation.actions.map((action) => action.name).includes(item.value))
        .map((item) => item.label as string);

      return {
        ...automation,
        source: automation,
        event: event?.label || "No event selected",
        actions,
        metrics:
          metrics.value === null
            ? null
            : metrics.value[automation.id] || { executed: 0, queued: 0, trend: Array(14).fill(0) },
      };
    }),
);
</script>
<template>
  <DataTable
    :show-pagination="false"
    v-model:checked-row-keys="checkedRows"
    :columns="automationSubTable"
    :data="data"
  />
</template>
