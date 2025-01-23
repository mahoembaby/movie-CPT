<?php 

/**
 * Uninstall File works when the plugin uninstall
 */

global $wpdb;

// Remove the custom post type 'book'
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'movie' " );

// Remove the custom taxonomy
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
 
// Remove the custom meta box
$wpdb->query( " DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );
