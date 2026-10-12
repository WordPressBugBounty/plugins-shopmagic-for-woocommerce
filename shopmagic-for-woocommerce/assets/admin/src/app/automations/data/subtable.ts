import type { DataTableColumns } from "naive-ui";
import { NButton, NIcon, NPopover, NSpace } from "naive-ui";
import type { AutomationData } from "@/types/automation";
import { h } from "vue";
import { RouterLink } from "vue-router";
import { DownloadOutline, TrashOutline } from "@vicons/ionicons5";
import { __ } from "@/plugins/i18n";
import DuplicationMessage from "../components/DuplicationMessage.vue";
import { downloadAutomation, removeAutomation } from "@/app/automations/singleAutomation";
import QuickPublishToggle from "@/app/automations/components/QuickPublishToggle.vue";
import AutomationTrend from "@/app/automations/components/AutomationTrend.vue";

export const automationSubTable: DataTableColumns<AutomationData> = [
  {
    key: "name",
    title: __("Name", "shopmagic-for-woocommerce"),
    render: ({ id, name }) =>
      h(
        RouterLink,
        { to: { name: "automation", params: { id } } },
        () => name || __("(Unnamed)", "shopmagic-for-woocommerce"),
      ),
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
    key: "language",
    title: __("Language", "shopmagic-for-woocommerce"),
    minWidth: 130,
    render: ({ language }) => {
      if (language === null) return;
      return new Intl.DisplayNames(navigator.languages, {
        type: "language",
        style: "short",
        languageDisplay: "standard",
      }).of(language);
    },
  },
  {
    key: "actionable",
    width: 164,
    render: ({ id }) =>
      h(NSpace, () => [
        h(DuplicationMessage, { id }),
        h(
          NPopover,
          {
            trigger: "hover",
          },
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
          {
            trigger: "hover",
          },
          {
            trigger: () =>
              h(
                NButton,
                {
                  tertiary: true,
                  type: "error",
                  size: "small",
                  onClick: () => void removeAutomation(id),
                },
                { icon: () => h(TrashOutline) },
              ),
            default: () => __("Delete", "shopmagic-for-woocommerce"),
          },
        ),
      ]),
  },
];
