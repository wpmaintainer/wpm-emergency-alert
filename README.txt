=== Emergency Alerts ===
Contributors: wpmaintainer, theandystratton
Donate link: https://wpmaintainer.com
Tags: alert, lightbox, messages, emergency, covid-19, covid19, coronavirus, closing, shutdown, banner
Requires at least: 4.6
Tested up to: 5.3
Stable tag: 1.2.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Create emergency alerts for your website. Inspired by the COVID-19 (Coronavirus) pandemic, but usable for all sorts of messaging that you need to get to your site's users.

== Description ==

Create emergency alerts for your website. Inspired by the COVID-19 (Coronavirus) pandemic, but usable for all sorts of messaging that you need to get to your site's users.

Includes options for text/background color, lightbox, fixed and absolute positioning. Includes some Javascript support for resizing.

You can force the alert to ALWAYS show or you can 

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wpm-emergency-alerts` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings -> Emergnecy Alerts screen to configure the plugin
1. If you have issues with the default output not looking right with your site, you may need to add custom CSS via the Appearance > Customize option in WordPress (see FAQs).

== Frequently Asked Questions ==

= Can I only show this on certain pages? =

Currently, this is only available with a filter `wpm_ea_status` (set to `"on"` for on and `"off"` for off).

= It's trying to auto-adjust heights, can I turn this off? =

Yes simply toggle the **Enable Javascript Position Adjustments** to OFF.

= It's trying to auto-adjust heights, can I turn this off? =

Yes simply toggle the **Enable Javascript Position Adjustments** to OFF.

= I installed the plugin, but it looks awful! What do I do? =

You may need to add custom CSS. Usually the Lightbox, Top – Fixed, and Bottom – Fixed options work well regardless of site design, but are more obtrusive.

Top/Bottom Alert Positions will be more tricky with more complex header/footer areas. If you run out of support options, you may always work with our support team by signing up for further support at https://wpmaintainer.com

= Is this responsive? =

Yes, our default output is responsive but every site is different. You may require some custom CSS to make things look 100% perfect!

== Changelog ==

= 1.2.0 =
* Adds custom expiration time for suppressable alerts.

= 1.1.1 =
* Cleans up some code organization and comments.

= 1.1.0 =
* Updates for repository imagery and a filename typo. Adds setting link shortcut.

= 1.0 =
* First version of the plugin - released.

== Screenshots ==

1. Sample settings screen with messaging. Toggle all plugin settings.