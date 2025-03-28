import { createRouter, createWebHashHistory } from "vue-router";
import { __ } from "@/plugins/i18n";

import automation from "@/app/automations/routes";
import dashboard from "@/app/dashboard/routes";
import welcome from "@/app/welcome/routes";
import logs from "@/app/logs/routes";
import marketingLists from "@/app/marketing-lists/routes";
import guests from "@/app/guests/routes";
import settings from "@/app/settings/routes";
import carts from "@/app/carts/routes";

const router = createRouter({
  history: createWebHashHistory(),
  routes: [
    ...automation,
    ...dashboard,
    ...guests,
    ...logs,
    ...marketingLists,
    ...settings,
    ...welcome,
    ...carts,
  ],
});

function setPageTitle(page: string) {
  let pageTitle = "";
  switch (page) {
    case "automation":
      pageTitle = __("Automation", "shopmagic-for-woocommerce");
      break;
    case "automations":
      pageTitle = __("Automations", "shopmagic-for-woocommerce");
      break;
    case "generateAutomation":
      pageTitle = __("ShopWizard", "shopmagic-for-woocommerce");
      break;
    case "recipes":
      pageTitle = __("Automation Recipes", "shopmagic-for-woocommerce");
      break;
    case "outcomes":
      pageTitle = __("Outcomes", "shopmagic-for-woocommerce");
      break;
    case "tracker":
      pageTitle = __("Email tracking", "shopmagic-for-woocommerce");
      break;
    case "lists":
      pageTitle = __("Marketing lists", "shopmagic-for-woocommerce");
      break;
    case "marketing-list":
      pageTitle = __("Edit marketing list", "shopmagic-for-woocommerce");
      break;
    case "subscribers":
      pageTitle = __("List subscribers", "shopmagic-for-woocommerce");
      break;
    case "guests":
      pageTitle = __("Guests", "shopmagic-for-woocommerce");
      break;
    case "settings":
      pageTitle = __("Settings", "shopmagic-for-woocommerce");
      break;
    case "carts":
      pageTitle = __("Abandoned carts", "shopmagic-for-woocommerce");
      break;
    case "queue":
      pageTitle = __("Queue", "shopmagic-for-woocommerce");
      break;
    case "welcome":
      pageTitle = __("Start here", "shopmagic-for-woocommerce");
      break;
    case "dashboard":
      pageTitle = __("Dashboard", "shopmagic-for-woocommerce");
      break;
    case "manual-run":
      pageTitle = __("Manual action", "shopmagic-for-woocommerce");
      break;
    case "transfer":
      pageTitle = __("Transfer", "shopmagic-for-woocommerce");
      break;
    default:
      pageTitle = page;
      break;
  }

  document.title = `${pageTitle} - ShopMagic`;
}

function highlightActiveMenuItem(page: string) {
  const menuItems = document.querySelectorAll("#toplevel_page_shopmagic-admin .wp-submenu li");
  menuItems.forEach((item) => {
    item.classList.remove("current");
  });

  // This is mapping of WP menu from PHP. We need to keep numeric order, as there is no identifiers.
  const wordPressMenuItems = [
    "hidden",
    "dashboard",
    "automations",
    "lists",
    "outcomes",
    "carts",
    "guests",
    "settings",
    "welcome",
  ] as const;

  const subpageToPage = (p: string) => {
    switch (p) {
      case "automation":
      case "automations":
      case "generateAutomation":
      case "manual-run":
      case "recipes":
        return "automations";
      case "outcomes":
      case "tracker":
      case "queue":
        return "outcomes";
      case "lists":
      case "marketing-list":
      case "transfer":
      case "subscribers":
        return "lists";
      default:
        return p;
    }
  };

  const menuItem = menuItems[wordPressMenuItems.indexOf(subpageToPage(page))];

  if (menuItem) {
    menuItem.classList.add("current");
  }
}

router.afterEach((to) => {
  setPageTitle(to.name);

  highlightActiveMenuItem(to.name);
});

export default router;
