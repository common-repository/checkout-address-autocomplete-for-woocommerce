=== Checkout Address Autocomplete for WooCommerce ===
Contributors: ecreationsllc, ccloyd, scottg11
Tags: WooCommerce, Checkout, Address Autosuggestion, Address Autocomplete, Checkout Address, WooCommerce Address Autocomplete, Google Address, Checkout Address Autocomplete, Google Maps API
Requires at least: 3.0.0
Tested up to: 5.0.0
Stable tag: 2.0.7
License: GPLv3
License URI: http://www.gnu.org/licenses/quick-guide-gplv3.html

Allows your customers to autocomplete billing and shipping addresses on the checkout page using the Google Maps Javascript API.

== Description ==

Reduce cart abandonment and increase sales by making checkout even easier!

Checkout Address Autocomplete for WooCommerce adds a feature to WooCommerce checkout so that customers start typing in the billing address or shipping address field, and a Google address suggestions autocomplete dropdown appears.  When the customer clicks or hits enter on one of the addresses, then the corresponding Address, City, State, and Zip fields automatically populate with the selected address data.

Works for Billing and/or Shipping addresses.

Address suggestions are relative to the selected country.

To enable the functionality of this plugin, you need to paste your free Google Maps Javascript API Key in the plugin settings page.

Made with love by <a href="https://www.ecreations.net" target="_blank">eCreations</a>, the <a href="https://www.ecreations.net/arizona-woocommerce-expert/" target="_blank"><strong>ONLY</strong> Certified WooCommerce Expert in Arizona!</a>

<strong>Check Out our Premium Plugins</strong>

<a href="https://www.ecreations.net/shop/woocommerce-transaction-central/" target="_blank" title="WooCommerce Extension / Plugin for Transaction Central">WooCommerce Extension / Plugin for Transaction Central</a><br />
<a href="https://www.ecreations.net/shop/woocommerce-extension-for-paid-calendar-events/" target="_blank" title="WooCommerce Extension for Paid Calendar Events">WooCommerce Extension for Paid Calendar Events</a><br>
<a href="https://www.ecreations.net/shop/woocommerce-extension-coupon-for-product-attributes/" target="_blank" title="WooCommerce Extension for Product Attribute Coupon">WooCommerce Extension for Product Attribute Coupon</a><br>
<a href="https://www.ecreations.net/shop/woocommerce-extension-export-orders-shopworks/" target="_blank" title="WooCommerce Extension to Export Orders to ShopWorks">WooCommerce Extension to Export Orders to ShopWorks</a><br>
<a href="https://www.ecreations.net/shop/woocommerce-extension-to-sponsor-calendar-events/" target="_blank" title="WooCommerce Extension to Sponsor Calendar Events">WooCommerce Extension to Sponsor Calendar Events</a>

= Features: =

* Checkout Address Autocomplete Suggestions
* Reduce cart abandonment
* Prevent address typos
* Address suggestions are relative to the selected country
* Supports the latest version of WooCommerce

== Installation ==

To install Checkout Address Autocomplete for WooCommerce, follow these steps:

1. Download and unzip the plugin

2. Upload the entire checkout-address-autocomplete-woocommerce/ directory to the /wp-content/plugins/ directory

3. Activate the plugin through the Plugins menu in WordPress

== Screenshots ==

1. Shows address autocomplete suggestions as you type
2. Selected address automatically populates the fields
3. Address suggestions are relative to the selected country
4. Simple settings page to save your Google Maps Javascript API Key

== Changelog ==

= 2.0.7 =
* Version bump for declared WooCommerce compatibility.

= 2.0.6 =
* Added UK (GB) to the list of countries that use the alternate address component mapping.  County field now populates correctly for the British.  Ex. "North Somerset" instead of "England".

= 2.0.4 =
* Add filter hook for 'checkout_adddress_autocomplete_language' and jQuery trigger 'input' on inputs after populating

= 2.0.3 =
* Bug fix

= 2.0.2 =
* Added a language setting to specify the language of Google's autocomplete responses

= 2.0.1 =
* Prevent Chrome autocomplete dropdown on the address line 1 fields

= 2.0.0 =
* Revamped much of the javascript logic that parses address components from Google in order to more accurately populate address fields in various countries.

= 1.9.8 =
* Added Precise Street Address Warning feature with a setting for the alert text.

= 1.9.7 =
* Updated Google API Key link and help text.

= 1.9.6 =
* Bug fix for Spain.

= 1.9.5 =
* Added address autocomplete feature to the My Account section.

= 1.9.4 =
* Fixed issues with address line 1 in some countries

= 1.9.3 =
* Fixed issues with the format of address line 1

= 1.9.2 =
* Trigger ajax cart refresh.

= 1.9.1 =
* Updated field label link for the API Key field to reduce confusion.

= 1.9 =
* Added option to force enqueue Google Maps javascript instead of first checking to see if it's already enqueued.

= 1.8 =
* Fix for address formats where the street number is after the street name.

= 1.7 =
* Reimplemented a better fix to not load multiple instances of Google Maps API

= 1.6 =
* Fixed script enqueue issue
* Fixed javascript error when store is set to sell to one country (causing state to not populate)
* If you have any other issues, please let us know in the support forum and we will address it.  Thanks!

= 1.3 =
* Fix to not load multiple instances of Google Maps API

= 1.2 =
* Minor updates

= 1.0 =
* Initial Release
