=== ShopMagic - email automation ===
Contributors: wpdesk,dyszczo,bartj
Tags: customize woocommerce emails, follow up emails, woocommerce email customizer, woocommerce abandoned cart, woocommerce mailchimp
Author URL: https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-author
Donate link: https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-donate
Requires at least: 6.4
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 4.7.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Flexible email automation and workflows triggered by customer and site events.

== Description ==

ShopMagic – email automation is a WooCommerce extension that allows store owners to create automated emails and actions triggered by store and customer events.

The ShopMagic - email automation plugin provides a system for building email automations using events, optional filters, and actions. It can be used to send follow-up emails, transactional notifications, reminders, and internal messages related to WooCommerce orders, customers, and site activity.

ShopMagic - email automation runs entirely inside WordPress and WooCommerce. All data remains in the site database and is not sent to external services unless explicitly configured by the site administrator (for example, through integrations).

The plugin is designed to be extensible and can be enhanced with add-ons or custom code to support additional events, filters, and actions.

== Key Features ==

- **AI-powered interface** – Create email automations using prompts and reduce setup time.
- **Ready-to-use WooCommerce automation recipes** – Pre-built email workflows for common WooCommerce scenarios.
- **WooCommerce follow-up emails** – Automatically send post-purchase emails such as review requests or product recommendations.
- **Email automation for WooCommerce order statuses** – Trigger emails based on order status changes, including links to products or external review platforms.
- **Custom transactional emails for WooCommerce** – Create and send customized emails for all order statuses, including pending payment and cancelled orders.
- **Support for custom WooCommerce order statuses** – Build automations and emails for custom statuses added by other plugins.
- **Product-specific email content** – Create different email designs and messages depending on the purchased product.
- **Welcome emails** – Send automated welcome emails for new orders or newly created customer accounts.
- **Internal emails and notifications** - Send emails to store staff or administrators about selected store events.
- **Mailchimp integration** - Automatically add customers to Mailchimp lists during checkout.
- **Customer lists and segmentation** - Create and manage multiple lists for newsletters, promotions, or product announcements.
- **GDPR-compliant email lists** - Support for opt-in and opt-out lists with unsubscribe links.
- **Advanced guest customer handling** – View and target customers who placed orders without creating an account.
- **Email queue system** – Optimized email queue for reliable delivery and store performance.
- **Email history and logs** – Full visibility into sent emails and executed actions.
- **Abandoned cart recovery** – Free add-on to recover abandoned WooCommerce carts and lost revenue.
- **WooCommerce SMS notifications** – Free Twilio integration add-on for sending SMS notifications.
- **Cross-sell and related product emails** – Promote related or cross-sell products using automated emails.
- **UTM parameter support** – Add tracking parameters to email links for Google Analytics.
- **Reliable email delivery** – Use ShopMagic as a WooCommerce email customizer when default emails are not sent correctly.
- **Newsletter and reminder automation** – Send newsletters, pre- and post-purchase emails, and cart reminders from WordPress.
- **Extensible with add-ons** – Integrations with Twilio, Gravity Forms, Contact Form 7, Slack, WooCommerce Memberships, Bookings, Subscriptions, and Google Sheets.

[youtube https://www.youtube.com/watch?v=otFW9egNI3U]

== How It Works ==

Automations in ShopMagic – email automation are built using three components:

= 1. Event =

Defines when the automation is triggered.
Examples include:

- Order status change
- New order created
- Customer account creation

= 2. Filter (optional) =

Defines conditions that must be met for the automation to run.
Filters can be used to limit automations to:

- Specific products or categories
- Selected order statuses
- Specific customer data

If no filter is added, the automation runs globally for the selected event.

= 3. Action =

Defines what happens when the event occurs and conditions are met.
Actions can include:

- Sending an email
- Adding a customer to a list
- Triggering an integration

Emails in ShopMagic – email automation can be customized using placeholders that insert dynamic WooCommerce and customer data.


== Getting Started ==

1. Install and activate the ShopMagic plugin.
2. Create a new automation in WooCommerce → Automations.
3. Choose an event and add an email action.
4. Save the automation — emails will be sent automatically.

A step-by-step guide is available in the documentation and video tutorial.

[youtube https://www.youtube.com/watch?v=UIBnaT_peHc]

== Documentation ==

ShopMagic comes with an [extensive docs](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-docs) for both store owners and staff as well as [developer docs](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-dev-docs) aimed to help with extending ShopMagic with new features.


== Help and support ==

ShopMagic is backed by a friendly and professional support team ready to answer your questions and help you along the way.

We also have an [extensive documentation site](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-docs) available. For support requests, please use the [official plugin forums](https://wpdesk.link/shopmagic-for-woocommerce-readme-support/) at WP.org.

If you’re looking for faster support via email, we encourage you to [purchase ShopMagic PRO](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-pro), which comes with 1-on-1 priority email support.


== Is there a PRO version? ==

Glad you asked.

Core functionalities of ShopMagic are free forever. However, we developed some add-ons which you can use to enhance your eCommerce possibilities:

**These are paid add-ons for [ShopMagic PRO](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-home).**

- [**Delayed Actions**](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-delayed) – Create post-purchase emails, i.e. with a 1-week delay or anniversary email 365 days after the initial purchase. Delay WooCommerce emails by minutes, hours, days, or weeks.
- [**Review Requests**](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-review-requests) – Adds review requests with direct links to products purchased for customers to review.
- [**Personalized Coupons**](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-advanced-filters) – Adds the ability to create personalized coupon codes for customers and send them automatically.
- [**Advanced Filters**](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-delayed-actions) – Ability to segment your customers with advanced filters, for example, order total, product category, payment or shipping method, and more.
- [**Manual Actions**](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-manual-actions) – Manually trigger one-time emails. Suitable for newsletters, product announcements, or any emails you want to send manually.
- [**WooCommerce Subscriptions Integration**](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-woocommerce-subscriptions) – Allows creating automations based on subscription events, such as payments or status changes.
- [**WooCommerce Memberships Integration**](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-woocommerce-memberships) – Allows creating automations based on membership events, such as status changes or before expiry.
- [**WooCommerce Bookings Integration**](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-woocommerce-bookings) - Let you crate automation based on booking events like status changes or before expiry.
- [**Gravity Forms**](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-woocommerce-gravity-forms) - Let you create automation based on user or customer form submission. You may use the forms to gather feedback in WordPress or information from WooCommerce customers and send the data to [Google Sheets](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-google-sheets/).
- [**Post to Slack**](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-slack) – allows you and your team to stay up to date with what’s happening in your store right in Slack.
- [**Webhooks**](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-webhooks) - allows using WooCommerce webhooks to integrate ShopMagic automations with external services or systems via REST API.
- [**ShopMagic for Flexible Subscriptions**](https://shopmagic.app/sk/shopmagic-for-woocommerce-for-flexible-subscriptions) - allows creating automations based on Flexible Subscriptions events, such as new subscriptions, status changes, upcoming renewals, trial ending, or subscription expiry, with advanced filters and subscription-specific placeholders.

**Upgrade to ShopMagic PRO**

[Upgrade to ShopMagic PRO now](https://shopmagic.app/sk/shopmagic-for-woocommerce-readme-go-pro) to get all the add-ons with all PRO features in one affordable package and get the priority e-mail support!

== Built with developers in mind ==

Extensible, adaptable, and open source. We made sure that ShopMagic is [easy to extend and adapt](https://shopmagic.app/sk/shopmagic-for-woocommerce-dev-docs) to the needs of your clients.

The ShopMagic API makes it possible for developers to extend ShopMagic by:

- Creating custom events, filters, actions, and placeholders.
- Creating custom templates for sending emails.
- Integrating with other plugins and web applications.
- Overriding default plugin behavior.

== ShopMagic in a nutshell ==

- WooCommerce email automation plugin for WordPress
- Create automated follow-up and transactional emails
- Customize WooCommerce email templates and content
- Send product-specific and order-based emails
- Support for custom WooCommerce order statuses
- WooCommerce review request and reminder emails
- Cross-sell and related product emails
- Abandoned cart recovery with a free add-on
- Email queue, logs, and automation history
- AutomateWoo alternative for WooCommerce stores

== Installation ==
1. Install either via the WordPress.org plugin directory, or by uploading the files to your server.
2. Activate the plugin through the "Plugins" menu in WordPress
3. Go to WooCommerce &rarr; Automations in your WordPress admin area and add a automation
4. Choose an event and an action for automation based on your preferences.

== Data use policy ==

Learn about [Use of Data Policy by WP Desk Plugins](https://shopmagic.app/sk/shopmagic-for-woocommerce-use-policy)

== Frequently Asked Questions ==

= Is ShopMagic suitable for WooCommerce beginners? =

Yes. Creating a simple automation, such as a follow-up or welcome email, takes only a few minutes and does not require technical knowledge. Documentation is available if you need additional guidance.

= Do I need coding skills to use ShopMagic? =

No. ShopMagic is designed for non-technical users. Automations are created using events, filters, and actions through an intuitive interface.

= Does ShopMagic work with guest orders? =

Yes. Automations and emails can be triggered for both registered users and guest customers.

= Can I send unlimited emails and create unlimited automations? =

Yes. ShopMagic does not limit the number of automations or emails. All data and emails are handled locally within WordPress.

= Will ShopMagic slow down my WooCommerce store? =

No. ShopMagic uses an internal queue system and processes emails in batches to ensure optimal store performance, even for large stores.

= Can I customize WooCommerce emails with ShopMagic? =

Yes. ShopMagic allows you to customize and send transactional and follow-up emails beyond the default WooCommerce email capabilities.

= Does ShopMagic send data to external services? =

No. By default, all data stays in your WordPress database. Data is shared externally only if you enable optional integrations.

= Is there a PRO version of ShopMagic? =

Yes. The core plugin is free. Optional paid add-ons (ShopMagic PRO) provide advanced features such as delayed actions, advanced filters, and additional integrations.

= Where can I get support? =

Support is available through the official WordPress.org support forums. Documentation is available on the plugin website.

= How can I report a security issue? =

Security issues can be reported through the Patchstack Vulnerability Disclosure Program.

== Screenshots ==

1. Plugin dashboard – create WooCommerce and WordPress email automations.
2. Overview of WooCommerce email campaign results and outcomes.
3. ShopMagic plugin settings page for marketing automation.
4. Manage and activate free add-ons for WooCommerce email automation.
5. Add WordPress users and WooCommerce customers to Mailchimp lists.
6. Customize WooCommerce emails for marketing and abandoned cart recovery (free add-on).
7. Send data from WordPress and WooCommerce to Google Sheets (free add-on).
8. Send SMS notifications to WooCommerce customers via Twilio integration (free add-on).
9. List of WooCommerce customers and WordPress users for marketing automation.
10. Add, import, and filter email marketing campaigns in WooCommerce.
11. Ready-to-use email automation templates for WordPress and WooCommerce.
12. Edit custom email content using placeholders, events, filters, and actions.
13. Example WooCommerce email automation – thank you note with a coupon.
14. Email automation workflow with free and PRO add-ons for WordPress and WooCommerce.
15. Add subscribers to newsletter lists from WordPress and WooCommerce for free.
16. Send automated WordPress newsletters to blog readers.
17. Automate follow-up emails for WooCommerce abandoned carts (free add-on).
18. Recover abandoned WooCommerce carts with ShopMagic add-on.
19. Send order status change notifications with custom emails in WooCommerce.
20. Export WordPress blog readers to Google Sheets and Mailchimp lists (free add-ons).
21. Send WooCommerce SMS notifications using Twilio integration (free add-on).
22. WooCommerce email automation triggered by order status changes.
23. Customize SMS notifications for WooCommerce using ShopMagic and Twilio.
24. Send email marketing campaigns triggered by Contact Form 7 submissions (free add-on).
25. Send email marketing campaigns triggered by Gravity Forms submissions (PRO add-on).
26. Use filters and customer segmentation for WooCommerce email marketing campaigns (some PRO).
27. Send follow-up emails, notifications, newsletters, and special offers via WooCommerce.
28. Build custom email lists for newsletters and marketing campaigns in WordPress and WooCommerce.
29. Add WooCommerce customers to email marketing lists using the free plugin.
30. Import and export subscribers for email marketing campaigns.
31. Monitor email marketing automation results in WordPress and WooCommerce.
32. Check the queue of automated emails awaiting sending.
33. Analyze outcomes and statistics of WooCommerce and WordPress marketing automation campaigns.
34. Example of WooCommerce abandoned cart email automation results.
35. Review logs for emails sent to guest customers.
36. Build advanced email marketing automations using ShopMagic PRO features.
37. Documentation and guidance for customizing WooCommerce emails and email marketing campaigns.

== Changelog ==

= 4.7.7 - 2026-01-26 =
* Readme update.

= 4.7.6 - 2026-01-21 =
* Added support for WooCommerce 10.5

= 4.7.5 - 2026-01-15 =
* Improved compatibility with recent PHP versions >= 8.4.

= 4.7.4 - 2025-12-29 =
* Readme update.

= 4.7.3 - 2025-12-15 =
* Fixed vulnerability in communication preferences update page.

= 4.7.2 - 2025-12-09 =
* Readme update.

[See changelog for all versions](https://plugins.trac.wordpress.org/browser/shopmagic-for-woocommerce/trunk/changelog.txt).

== Upgrade Notice ==

Upgrade to the latest version to get the newest features and all interface improvements.
