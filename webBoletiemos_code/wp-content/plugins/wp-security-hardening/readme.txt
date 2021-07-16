===WP Hardening - Fix Your WordPress Security===
Contributors: astrasecuritysuite, wizak, shikhil
Donate link: https://www.getastra.com
Tags:  security, hardening, xmlrpc, user enumeration, custom login url, admin url, Disable WP API JSON, Disable File Editor, Hide WP-includes, WP-content, Remove Version Stylesheet, Remove Version Script, Remove Slider Revolution Meta Generator
Requires at least: 4.3
Tested up to: 5.4.2
Stable tag: 1.1.2
Requires PHP: 5.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html



The WP Hardening is a one-click tool to fix standard security recommendations on your WordPress website.

== Description ==

WP Hardening by Astra Security is a tool which performs a real-time security audit of your website to find missing security best practices. Using our ‘Security Fixer’ you can also fix these with a single click from your WordPress backend.

It is a task to achieve the basic WordPress security measures without using multiple plugins. Ironically, this induces higher risk of a compromisation for websites with so many plugins at work. Multiple plugins also ask for better maintenance, updates, which many webmasters failed to comply. WP Hardening plugin solves this problem and more.

WP Hardening is a one-stop solution to implement security recommendations for your WordPress website. It is effortless to use and works efficiently from your WordPress backend.

<strong>About Astra</strong>
<p><br />Astra Security is a Techstars company &amp; the winner of the French Tech Ticket Program. Awarded as The Most Innovative Security Company at the Global Conference on Cyber Security.<br />

Astra's vision is to make cyber security a five minute affair for businesses</p>
<p><em>Astra's promise to a business owner is that their business would be secure without any ifs or buts. </em><em><strong>If a business is using Astra, they will be secure - no questions asked.</strong></em></p>

<br/>
==Features==

###Hardening Audit###
<ol>
  <li><strong>WordPress Version Check</strong>
    It checks if your website is on the latest version or not.<br>
  </li>
  <li><strong>Checking Outdated Plugins</strong>
    It checks if your website is running the updated plugins or not.<br>
  </li>
  <li><strong>Checking PHP Version</strong>
    WP Hardening also checks if your website is running on a secure version of PHP.<br>
  </li>
  <li><strong>Checking File &amp; Folder Permissions</strong>
    WP Hardening also checks if your website is built on the secured version of PHP or not.<br>
  </li>
  <li><strong>Database Password Strength</strong>
    We check the strength of passwords used on your database. Not having a secured password can become an easy target for Brute-Force attacks.<br>
  </li>
  <li><strong>Checking Firewall Protection</strong>
    We’ll check if your website is being protected by a firewall or not. Firewalls leverage a great monitoring and filtering system on your website. Check out the features of Astra firewall here.<br>
  </li>
</ol>

##Security Fixers##

**Admin & API Security**

<ol>
  <li><strong>Stop User Enumeration</strong> 
Hackers &amp; bad bots can easily find usernames in WordPress by visiting URLs like <em>yourwebsite.com/?author=1</em>. This can significantly help them in performing larger attacks like Bruteforce &amp; SQL injection.<br>
</li>
  <li><strong>Change Login URL</strong> 
Prevent admin password brute-forcing by changing the URL for the wp-admin login area. You can change the url only when this fixer is disabled.<br></li>
  <li><strong>Disable XMLRPC</strong> 
XMLRPC is often targeted by bots to perform brute force &amp; DDoS attacks (via pingback) causing considerable stress on your server. However, there are some services which rely on xmlrpc. Be sure you definitely do not need xmlrpc before disabling it. If you are using Astra firewall, then you’re safe against xmlrpc attacks automatically.<br></li>
  <li><strong>Disable WP API JSON</strong> 
Since 4.4 version, WordPress added JSON REST API which largely benefits developers. However, it’s often targeted for bruteforce attacks just like in the case of xmlrpc. If you are not using it, best is to disable it.<br></li>
  <li><strong>Disable File Editor</strong> 
If a hacker is able to get access to your WordPress admin, with the file editor enabled it becomes quite easy for them to add malicious code to your theme or plugins. If you are not using this, it’s best to keep the file editor disabled.<br></li>
</ol>


**Disable Information Disclosure & Remove Meta information**

<ol>
  <li><strong>Hide WordPress version number</strong>
    This gives away your WordPress version number making life of a hacker simple as they’ll be able to find targeted exploits for your WordPress version. It’s best to keep this hidden, enabling the button shall do that.<br>
  </li>
  <li><strong>Remove WordPress Meta Generator Tag</strong>
    The WordPress Meta tag contains your WordPress version number which is best kept hidden<br>
  </li>
  <li><strong>Remove WPML (WordPress Multilingual Plugin) Meta Generator Tag</strong>
    This discloses the WordPress version number which is best kept hidden.<br>
  </li>
  <li><strong>Remove Slider Revolution Meta Generator Tag</strong>
    Slider revolution stays on the radar of hackers due to its popularity. An overnight hack in the version you’re using could lead your website vulnerable too. Make it difficult for hackers to exploit the vulnerabilities by disabling version number disclosure here<br>
  </li>
  <li><strong>Remove Visual Composer / WPBakery Page Builder Meta Generator Tag</strong>
    Common page builders often are diagnosed with a vulnerability putting your website’s security at risk. With this toggle enabled, the version of these page builders will be hidden making it difficult for hackers to find if you’re using a vulnerable version.<br>
  </li>
  <li><strong>Remove Version from Stylesheet</strong>
    Many CSS files have the WordPress version number appended to their source, for cache purposes. Knowing the version number allows hackers to exploit known vulnerabilities.<br>
  </li>
  <li><strong>Remove Version from Script</strong>
    Many JS files have the WordPress version number appended to their source, for cache purposes. Knowing the version number allows hackers to exploit known vulnerabilities.<br>
  </li>
</ol>

**Basic Server Hardening**
<ol>
	<li><strong>Hide Directory Listing of WP includes</strong>
WP-includes directory gives away a lot of information about your WordPress to hackers. Disable it by simply toggling the option to ensure you make reconnaissance of hackers difficult</li>
</ol>

<br/>
== Installation ==

<ol>
  <li>Visit ‘Plugins &gt; Add New’ in your admin dashboard</li>
  <li>Search for ‘WP-Hardening’</li>
  <li>Install WP-Hardening once it appears</li>
  <li>Activate it from your Plugins page</li>
  <li>WP-Hardening button will appear on the bottom left of your admin dashboard</li>
</ol>

<br/>

==Frequently Asked Questions==

=Is WP hardening plugin free to use?=

Yes, it is absolutely free. Just download the plugin and activate it from your backend. Run the scan and review the results.

=How does WP Hardening plugin works?=

WP Hardening scans your website for security recommendations like File Permissions, WordPress Version, Outdated plugins etc. & helps you with proper steps to fix these issues. The ‘Security Fixer’ button help to fix Admin & API security, Disable Information Disclosure & Remove Meta information & Basic Server Hardening. For more security practices you can check our detailed step by step guide on <a target="_blank" href="https://www.getastra.com/blog/cms/wordpress-security/wordpress-security-guide/">WordPress Security</a>

=Will this plugin help me with malware infected website?=

No, this plugin will help you harden your WordPress Security. However, you can opt for malware cleanup & firewall from within the plugin offered by Astra Security. You can also follow our <a target="_blank" href="https://www.getastra.com/blog/911/wordpress-site-hacked-malware-backdoor/">Hack Removal Guide</a> to scan & fix your website.

=How will I get informed about my website’s security?=

You will get informed instantly after each scan via email. For additional information, subscribe to our newsletter and stay updated.

=Does WP Hardening conflict with other security plugins?=
No, WP Hardening does not conflict with any security plugin. However, you can get rid of multiple plugins that you have installed to disable XMLRPC, prevent user enumeration, changing admin URL, etc. In case, you face any issues with the WP hardening plugin, feel free to send us a mail.

=What level of support will I get?=

You can contact our team via
<a href=”mailto:hello@getastra.com”>mail</a>. Besides, we also have an extensive repository of <a href=”https://www.getastra.com/kb/”>knowledge bases</a> to help you save time.


=Will this plugin help me to fix issues?=

You will find a comprehensive step by step guides in the recommendation to fix the detected issues. The ‘Security Fixer’ option will help you to fix most of the security recommendations by just a click. If you have any questions contact us over <a href="mailto:hello@getastra.com">mail</a>

=What are the terms & conditions?=

Here are the <a target="_blank" href="https://www.getastra.com/terms">Terms & Conditions</a> of the Service.</p>

=Where can I see customer testimonials of Astra Security?=

<a target="_blank" href="https://www.trustpilot.com/review/getastra.com">Trustpilot</a> & <a target="_blank" href="https://www.capterra.com/p/162941/Astra-Security/">Capterra</a> are two platforms where you can see Astra Security testimonials.


<br/>
== Screenshots ==

Harden security with WP Hardening

1. This is the main dashboard; you’ll find a concise overview of your website’s present security. Buttons “Start a new audit”, “Security Fixers”, “Request malware cleanup”, “View Help docs”, on the dashboard take you to the respective sections.
2. 'Audit Recommendation' section on the same page details the audit results. Whereas the “Recommendations” sub-section show improvement areas with links to comprehensive guide to implement those practices.
3. 'Passed test' sub-section shows already implemented best practices.
4. The 'Security Fixers' section contains 13 vital security hardening areas. You can optimize these with a single click.
5. The first section in the security fixer is of 'Admin & API Security'. You can find the details of each test by hovering.
6. The second & third section are 'Disable Information Disclosure & Remove Meta information' & 'Basic Server Hardening'.

== Changelog ==

Initial public release of WP Hardening Plugin.

== Upgrade Notice ==

Initial public release of WP Hardening Plugin.