<?php
/*
 Plugin Name: Remove WP Head Comments
 Plugin URI: http://www.martinhurford.com/remove-wp-head-comments.html
 Description: Remove comments from the wp_head function output
 Version: 1.0
 Author: Martin Hurford
 Author URI: http://www.martinhurford.com/about.html
 License: WTFPL 2.0
 License URI: http://sam.zoy.org/wtfpl/COPYING
*/
/*
 This program is free software. It comes without any warranty, to the extent
 permitted by applicable law. You can redistribute it and/or modify it under
 the terms of the Do What The Fuck You Want To Public License, Version 2,
 as published by Sam Hocevar.
 See http://sam.zoy.org/wtfpl/COPYING for more details.
*/
/**
* An object capturing the output of 'wp_head' and removing HTML comments
*
* Removes the functions assigned to 'wp_head' and re-assigns them to a custom
* action allowing output to <head> to be modified before it reaches the page
*
*/
class Remove_WP_Head_Comments
{
	/**
     * Add action to un-assign functions from wp_head.
     * Priority set so this executes at the last possible moment before wp_head executes
	 * @see Remove_WP_Head_Comments::requeue_wp_head_actions
	 */
	public function __construct()
	{
		add_filter( 'plugin_row_meta',array( &$this, 'register_remove_wp_head_comments_links'),10,2);
		add_action( 'get_header', array( &$this, 'requeue_wp_head_actions' ), 99999 );
	}

	/**
	 * This method executed during 'get_header'
     * Make local copy of functions assigned to 'wp_head'. Remove functions from 'wp_head'.
	 * Re-assign functions to custom action 'remove_wp_head_comments'
     * Add method {@link Remove_WP_Head_Comments::execute_wp_head_actions} to 'wp_head'
	 */
	public function requeue_wp_head_actions()
	{
		global $wp_filter;
		$wp_head_actions = $wp_filter['wp_head'];
		foreach( $wp_head_actions as $priority => $actions ){
			foreach($actions as $function){
				remove_action( 'wp_head', $function['function'], $priority );
				add_action( 'remove_wp_head_comments', $function['function'], $priority,$function['accepted_args'] );
			}
		}
		add_action( 'wp_head', array( &$this, 'execute_wp_head_actions' ), 1 );
	}

	/**
	 * This method executed during 'wp_head'
     * Execute all functions formally assigned to 'wp_head' and capture output
	 * Remove HTML comments and leading whitespace before output to <head>
     */
	public function execute_wp_head_actions()
	{
		$patterns = array(
			// Remove comments but not IE conditional comments
			"/<!--(?!\s*\[).*?-->/s"				=> ""
			// Remove empty lines
		,   "/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/" 	=> "\n"
			// Remove leading whitespace from tags ('cause I like everything to line up nicely :)
		,	"/\n+\s*</"								=> "\n<"
		);
		ob_start();
			do_action( 'remove_wp_head_comments' );
		echo preg_replace( array_keys($patterns), array_values($patterns), ob_get_clean() );
	}

	/**
	 * Adds 'donate' link to the plugin row on the plugins page, you never know! ;)
	 * @param array $links
	 * @param string $file
     */
	public function register_remove_wp_head_comments_links($links, $file){
		$base = plugin_basename(__FILE__);
		if ($file == $base) {
			$links[] = '<a href="http://www.martinhurford.com/donate/remove-wp-head-comments.html">Donate</a>';
		}
		return $links;
	}

}
$removeWPHeadComments = new Remove_WP_Head_Comments();