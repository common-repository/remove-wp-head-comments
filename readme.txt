=== Plugin Name ===
Contributors: martinhurford
Donate link: http://www.martinhurford.com/donate/remove-wp-head-comments.html
Tags: wp_head, remove comments
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: trunk

Removes comments from inside &lt;head&gt; tags, specifically the output of wp_head

== Description ==

Plugin authors sometimes add comments between the &lt;head&gt; tags highlighting the output from their plugin.

If you don't like these comments, for whatever reason, then this plugin will remove them for you.

Specifically comments are removed from the output of the wp_head function so comments in theme templates will not be affected.

== Installation ==

The automatic plugin installer should work for most people.

To manually install the plugin:

1. Upload the plugin folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= What does this plugin do? =

It removes comments inserted between the &lt;head&gt; tags by some plugins

= Why? =

1. It makes the code look [purdy](http://www.urbandictionary.com/define.php?term=purdy "it means - pretty").
2. Prevents advertizing which plugins are active. Potential hackers may look for specific plugins to exploit vulnerabilities. 
3. It makes the generated HTML file a little smaller. Less to send over the wire.
4. *Mostly* No.1 though.

= Does it remove the IE conditional comments output by plugin XYZ? =

No. IE conditional comments are ignored.

== Changelog ==

= 1.0 =

* Initial release.
