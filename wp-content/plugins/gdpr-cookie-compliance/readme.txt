=== GDPR Cookie Compliance ===
Contributors: MooveAgency, gaspar.nemes
Stable tag: trunk
Tags: gdpr
Requires at least: 4.5 or higher
Tested up to: 4.9.5
Requires PHP: 5.6
License: GPLv2

GDPR is an EU wide legislation that specifies how user data should be handled. This plugin has settings that can assist you with GDPR cookie compliance requirements.

== Description ==

**What is GDPR?**

General Data Protection Regulation (GDPR) is a European regulation to strengthen and unify the data protection of EU citizens. ([https://www.eugdpr.org/](https://www.eugdpr.org/))

**GDPR and Cookie Compliance**

* GDPR states that as a website owner, you cannot assume a user has opted into the cookies being used on your website -  the user must give a positive opt in or "affirmative action" to signal their consent to the use of cookies and you also cannot force users to opt into the use of cookies.
* Users who do not give consent should have the same experience of your website as those who give consent, which means you have to provide the same level of service and experience to those who do not accept the cookies.
* Consent will need to be specific to the different cookie purposes with the ability to enable and disable cookies at a granular level for each cookie.
* It also means that you should not be tracking users on your website with tools such as Google Analytics until they give you a specific permission to do so.

**How this plugin works**

* This plugin is designed to help you prepare your website for the GDPR regulations related to cookies but IT WILL NOT MAKE IT FULLY COMPLIANT - this plugin is just a template and needs to be setup by your developer in order to work properly.
* Once installed, the plugin gives you a template that you can customise; you can modify all text and colours to suit your needs.
* You can also allow users to enable and disable cookies on your site, however, this will require bespoke development work as every site is unique and uses different cookies.

**Demo Video**

You can view a demo of the plugin here: [GDPR Cookie Compliance Plugin by Moove Agency](https://vimeo.com/255655268)

**Disclaimer**

* Please note, it is possible that you will see a drop of perceived traffic and visitor numbers in your various analytics such as Google Analytics. This is because GDPR legislations state that you cannot track users unless they explicitly give consent by enabling the 3rd party tracking and cookies.
* This plugin will require technical support from your developer to ensure that it is implemented correctly on your website.
* This is a general plugin with basic functionality. We advise that you to seek independent legal advice on this topic.
* THIS PLUGIN DOES NOT MAKE YOUR WEBSITE COMPLIANT. YOU ARE RESPONSIBLE FOR ENSURING THAT ALL GDPR REQUIREMENTS ARE MET ON YOUR WEBSITE.

**Contributors**

This plugin was developed by [Moove Agency](https://www.mooveagency.com).

== Installation ==

1. Upload the plugin files to the plugins directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the \'Plugins\' screen in WordPress.
3. Settings are available in the "GDPR Cookie" menu under the Settings.
4. Use the Settings screen to configure the plugin.
5. You can link to the Cookie Settings on your website using the following: /#moove_gdpr_cookie_modal
6. WPML supported, switch the language in your admin and translate the texts

== Changelog ==

= 1.0.0. =
* Initial release of the plugin.

= 1.0.1. =
* Fixed button conflicts.
* Fixed validation for the scripts in tabs.

= 1.0.2. =
* Fixed .pot file.
* Added WPML support.
* Fixed Strictly Necessary tab content.
* Fixed conflicts inside the WYSIWYG editor.

= 1.0.3. =
* Extended scripts sections with fields to add "<head>" and to "<body>"
* Editable label for "Powered by" text
* Added radio buttons to change the logo position (left, center, right)
* Colour pickers added to customise the floating button
* Fixed infobar WYSIWYG editor, links are allowed

= 1.0.4. =
* Moved modal content to wp_footer

= 1.0.5. =
* Fixed php method declarations and access
* Bugfixes

= 1.0.6. =
* Fixed Lity conflict
* Added "postscribe" library

= 1.0.7. =
* Third party script jump fixed
* Added new warning message if the strict necessary cookes are not enabled but the user try to enable other cookies
* Updated admin colorpicker
* Qtranslate X support
* Bugfixes

= 1.0.8. =
* Admin color picker fixed

= 1.0.9. =
* Added One Page layout
* Extended strictly necessary cookies functionality
* the_content conflicts resolved
* Bugfixes

= 1.1.0. =
* Lightbox loaded from local server
* Google fonts loaded from local, @import removed
* Improved functions to remove cookies
* Bugfixes

= 1.1.1. =
* Fixed missing ttf font files
* Fixed checkbox visibility
* Added forceGet to location.reload
* Accessibility improvements
* Popup open / close improvements