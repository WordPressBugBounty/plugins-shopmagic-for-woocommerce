import type { DataTableColumns } from "naive-ui";
import { NButton, NIcon, NPopover, NSpace } from "naive-ui";
import type { AutomationData } from "@/types/automation";
import { h } from "vue";
import { RouterLink } from "vue-router";
import { DownloadOutline } from "@vicons/ionicons5";
import { __ } from "@/plugins/i18n";
import DuplicationMessage from "../components/DuplicationMessage.vue";
import DeleteButtonWithNotification from "../components/DeleteButtonWithNotification.vue";
import { downloadAutomation } from "@/app/automations/singleAutomation";
import AutomationSubTable from "@/app/automations/components/AutomationSubTable.vue";
import QuickPublishToggle from "@/app/automations/components/QuickPublishToggle.vue";
import AutomationTrend from "@/app/automations/components/AutomationTrend.vue";

export const automationTableColumns: DataTableColumns<AutomationData> = [
  {
    type: "selection",
  },
  ...(window.ShopMagic.modules.includes("multilingual-module")
    ? [
        {
          type: "expand",
          // Expand only if automation has reference to any children
          expandable: (automation) => automation?._links?.children,
          renderExpand: (automation) => h(AutomationSubTable, { automation }),
        },
      ]
    : []),
  {
    key: "name",
    title: __("Name", "shopmagic-for-woocommerce"),
    render: ({ id, name }) =>
      h(
        RouterLink,
        { to: { name: "automation", params: { id } } },
        () => name || __("(Unnamed)", "shopmagic-for-woocommerce"),
      ),
    sorter: (a, b) => a.name.localeCompare(b.name),
  },
  {
    key: "status",
    title: __("Active", "shopmagic-for-woocommerce"),
    width: 96,
    render: ({ source }) => h(QuickPublishToggle, { automation: source }),
  },
  {
    key: "event",
    title: __("Event", "shopmagic-for-woocommerce"),
  },
  {
    key: "actions",
    title: __("Actions", "shopmagic-for-woocommerce"),
    render: ({ actions }) => actions?.join(", ") || "",
  },
  {
    key: "executed",
    title: __("Runs", "shopmagic-for-woocommerce"),
    width: 132,
    render: ({ id, metrics }) =>
      metrics === null
        ? h(
            "span",
            {
              "aria-label": __("Metrics unavailable", "shopmagic-for-woocommerce"),
              style: { color: "#646970" },
            },
            "—",
          )
        : h(NSpace, { align: "center", size: 10, wrap: false }, () => [
            h(RouterLink, { to: { name: "outcomes", query: { automation: id } } }, () =>
              metrics.executed.toLocaleString(),
            ),
            h(AutomationTrend, { values: metrics.trend }),
          ]),
  },
  {
    key: "queued",
    title: __("Queued", "shopmagic-for-woocommerce"),
    width: 76,
    render: ({ id, metrics }) =>
      metrics === null
        ? h(
            "span",
            {
              "aria-label": __("Metrics unavailable", "shopmagic-for-woocommerce"),
              style: { color: "#646970" },
            },
            "—",
          )
        : h(RouterLink, { to: { name: "queue", query: { automation: id } } }, () =>
            metrics.queued.toLocaleString(),
          ),
  },
  {
    key: "actionable",
    width: 164,
    render: ({ id }) =>
      h(NSpace, () => [
        h(DuplicationMessage, { id }),
        h(
          NPopover,
          { trigger: "hover" },
          {
            trigger: () =>
              h(
                NButton,
                {
                  tertiary: true,
                  type: "info",
                  size: "small",
                  onClick: () => void downloadAutomation(id),
                },
                {
                  icon: () => h(NIcon, () => h(DownloadOutline)),
                },
              ),
            default: () => __("Export", "shopmagic-for-woocommerce"),
          },
        ),
        h(
          NPopover,
          { trigger: "hover" },
          {
            trigger: () => h(DeleteButtonWithNotification, { id }),
            default: () => __("Delete", "shopmagic-for-woocommerce"),
          },
        ),
      ]),
  },
];
