=== Dashboard Widget Plugin ===
Contributors: your_wp_org_username
Donate link: https://localhost/
Tags: dashboard, widget, react, rest-api
Requires at least: 5.0
Tested up to: 6.0
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin to add a custom dashboard widget using ReactJS and WP REST API.

== Description ==

This plugin adds a custom dashboard widget to the WordPress admin area using ReactJS and the WP REST API. The widget displays a line chart with data fetched from the WordPress database. The chart data can be filtered to show data for the last 7 days, 15 days, or 1 month.

Features:
* Custom dashboard widget using ReactJS
* Fetches data via WP REST API
* Line chart with filter options for 7 days, 15 days, and 1 month

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `dw-plugin` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The custom dashboard widget will automatically appear in the WordPress admin dashboard

== Frequently Asked Questions ==

= What does this plugin do? =

It adds a custom widget to the WordPress dashboard that displays a line chart with data fetched from the WordPress database.

= How can I filter the data in the chart? =

You can use the dropdown menu in the widget to filter the data for the last 7 days, 15 days, or 1 month.

== Screenshots ==

1. Dashboard widget displaying a line chart with sample data
2. Dropdown menu to filter chart data

== Changelog ==

= 1.0 =
* Initial release of the Dashboard Widget Plugin.

== Upgrade Notice ==

= 1.0 =
Initial release.

== Arbitrary section ==

You can add any additional information here that does not fit into the other sections.

== A brief Markdown Example ==

Ordered list:

1. Add a custom dashboard widget
2. Display data using a line chart
3. Filter data by time range

Unordered list:

* Custom dashboard widget
* ReactJS integration
* WP REST API usage

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax]. Titles are optional, naturally.

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax "Markdown is what the parser uses to process much of the readme file"

Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up for **strong**.

`<?php code(); // goes in backticks ?>`
