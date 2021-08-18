=== Any Content Carousel ===
Contributors: treehost,Matteo182
Tags: woocommerce, carousel, author carousel, post carousel, product carousel, slick slider, custom post type, post, type, shortcode
Donate link: https://paypal.me/treehost
Requires at least: 3.8
Tested up to: 5.7.2
Requires PHP: 5.2.4
Stable tag: 1.2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin generates a shortcode to create a beautiful carousel with any post type you have on your site: Product, Post, User, Portfolio etc.

== Description ==

*The plugin allows you to create a carousel with any post type you have.*

This plugin is built to work for any theme and any post type or users.

With the Any Content Carousel Plugin you can create Carousels to give value to your Content, your Authors or your products.

Fully Responsive and Touch-friendly

<blockquote>
<h4>More from us</h4>
<p>We are a team of WordPress enthusiasts who enjoy <a href="https://treehost.eu">developing WordPress</a> and WooCommerce themes.</p>
<p>We also blog at <a href="https://giardinodimezzo.eu">GiardinoDiMezzo.eu</a>, where we write about Climate Change</p>
</blockquote>

**How to use:**

1. Go to Carousel Settings 
2. Select post Type 
3. Insert shortcode [tdm_contentslider] in page content
the Free version add only one type of carousel but in many page or content 
the Pro version you create one carousel for any type of post you have.

= Showcase =
See how it works : [Showcase](https://treehost.eu/wordpress-plugin-any-content-carousel/).

= Feedback =
Any suggestions or comments are welcome. Feel free to contact us via the [contact form](https://treehost.eu/).

== Installation ==
1.In your WordPress admin panel, go to *Plugins > New Plugin*, search for **Any Content Carousel** and click \"*Install now*\"
2. Alternatively, download the plugin and upload the contents of `any-content-carousel.zip` to your plugins directory, which usually is `/wp-content/plugins/`.
3. Activate the plugin


== Frequently Asked Questions ==
= How do I embed the carousel in my theme? =
There are tree easy ways to display Any Content Carousel in your theme:

– **Using a shortcode**

`[tdm_contentslider]`

– **As a widget** - in your WordPress admin panel, go to `Appearance → Widgets`, choose text widget, and use the shortcode

`[tdm_contentslider]`

– **Using PHP**

`<?php echo do_shortcode('[tdm_contentslider]'); ?>`
= how do i get the post type displayed in the carousel ? =
In the carousel options under Select Post type, search for the post type you want to display among the types your site has.
= How can I add a post type to the list? =
You can create any post type normally like you do on WordPress, using another plugin or by yourself if you know php
= how can i view the products of my e-commerce in the carousel? =
the carousel shows the featured products, then, after selecting the post type product, you have to go to the product list and highlight the ones you want in the carousel by clicking on the star. The carousel displays Woocommerce products.
= How do I show a video from the carousel ? =
now the plugin activates the selection of the post format, if you select the post format Video in post edior, the plugin will take the first video it finds from the content of the post and will make it visible by clicking on the play button directly in the carousel.

== Upgrade Notice ==
You will improve the interface and usability of your blog or your e-commerce by simplifying the interaction with your users.
You can select the type of content yourself to create the carousel and insert it via shortcode in the contents of your site. You can select any post type, Custom Post, Woocommerce Products or the authors of your Blog.


== Screenshots ==
1. Carousel Posts
2. Carousel Products
3. Carousel Portfolio
4. Carousel Users
5. Carousel Setting Area

== Changelog ==
= 1.0 =

= 1.2.0, July 01, 2021 =
* ADD: apply_filter after query_post to be able to change the result
* ADD: enqueue script only when the shortcode is present in the content or in a widget
* ADD: Improve post format Video
* FIX: button text color
* FIX: Responsive
* FIX: Carousel in widjet area

= 1.2.1, July 01, 2021 =
* FIX: Carousel responsive

= 1.2.2, July 03, 2021 =
* FIX: add library fslightboxjs 

= 1.3.0, August 18, 2021 =
* ADD: Post and Products category Selection
* FIX: User Author carousel 