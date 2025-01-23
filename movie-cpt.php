<?php

/*
 * Plugin Name:       Movie CPT 
 * Plugin URI:        https://github.com/mahoembaby/movie-CPT
 * Description:       This plugin can use for the movie website as it will supports the different of categories and tags in the movie web like casts, genre etc..
 * Version:           1.0.0
 * Author:            Mahmoud Hosny
 * Author URI:        https://github.com/mahoembaby
 */


 if(! defined('ABSPATH') ) { exit; }

 class Movie_CPT {
    

    /**
    *  Fire Any Code with add_action() when the plugin activation
    */ 
    public function activate() {
        // fire the function add_movie_cpt() for the register custom post type [ movie ]
        add_action('init', [$this, 'add_movie_cpt'] );

        // Fire the function add_cpt_taxonomy_genre() for the first custom taxonomy
        add_action( 'init', [$this, 'add_cpt_taxonomy'] );

        // Fire the function add_custom_meta_box() for the Details movie Metabox
        add_action('add_meta_boxes', [$this, 'add_custom_meta_box']);

        // Fire the function cmb_save_data() for the save data from Metabox
        add_action('save_post', [$this, 'cmb_save_data']);

        flush_rewrite_rules();
    }


    /**
    *  Fire Any Code when the plugin deactivation
    */ 
    public function deactivate() {
  
        /** 
         * flush rewite rules
         */      
        
        flush_rewrite_rules();
    }


    /**
    * Registers CPT Movies
    */
    public function add_movie_cpt() {
        $labels = [
            'name' => _x( 'Movies', 'Post Type General Name', 'movie' ),
            'singular_name' => _x( 'Movie', 'Post Type Singular Name', 'movie' ),
            'menu_name' => __( 'Movies', 'movie' ),
            'name_admin_bar' => __( 'Movies', 'movie' ),
            'archives' => __( 'Movies Archives', 'movie' ),
            'attributes' => __( 'Movies Attributes', 'movie' ),
            'parent_item_colon' => __( 'Parent Movie:', 'movie' ),
            'all_items' => __( 'All Movies', 'movie' ),
            'add_new_item' => __( 'Add New Movie', 'movie' ),
            'add_new' => __( 'Add New', 'movie' ),
            'new_item' => __( 'New Movie', 'movie' ),
            'edit_item' => __( 'Edit Movie', 'movie' ),
            'update_item' => __( 'Update Movie', 'movie' ),
            'view_item' => __( 'View Movie', 'movie' ),
            'view_items' => __( 'View Movies', 'movie' ),
            'search_items' => __( 'Search Movies', 'movie' ),
            'not_found' => __( 'Movie Not Found', 'movie' ),
            'not_found_in_trash' => __( 'Movie Not Found in Trash', 'movie' ),
            'featured_image' => __( 'Featured Image', 'movie' ),
            'set_featured_image' => __( 'Set Featured Image', 'movie' ),
            'remove_featured_image' => __( 'Remove Featured Image', 'movie' ),
            'use_featured_image' => __( 'Use as Featured Image', 'movie' ),
            'insert_into_item' => __( 'Insert into Movie', 'movie' ),
            'uploaded_to_this_item' => __( 'Uploaded to this Movie', 'movie' ),
            'items_list' => __( 'Movies List', 'movie' ),
            'items_list_navigation' => __( 'Movies List Navigation', 'movie' ),
            'filter_items_list' => __( 'Filter Movies List', 'movie' ),
        ];
        $labels = apply_filters( 'movie-labels', $labels );

        $args = [
            'label' => __( 'Movie', 'movie' ),
            'labels' => $labels,
            'supports' => [
                'title',
                'editor',
                'excerpt',
                'author',
                'thumbnail',
                'comments',
                'trackbacks',
                'revisions',
                'page-attributes',
                'post-formats',
            ],
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-admin-collapse',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'can_export' => true,
            'capability_type' => 'post',
            'show_in_rest' => true,
        ];
        $args = apply_filters( 'movie-args', $args );

	    register_post_type( 'movie', $args );
    }


    /**
    * Registers the taxonomy.
    */
    public function add_cpt_taxonomy()  {

        /**
         * Registers the 'Genre' taxonomy.
        */

        $args_genre = [
            'labels' => [
                'name' => _x( 'Genres', 'Taxonomy Name', '' ),
                'singular_name' => _x( 'Genre', 'Taxonomy Singular Name', '' ),
                'menu_name' => __( 'Genres ', '' ),
                'all_items' => __( 'All Genres ', '' ),
                'parent_item' => __( 'Parent Genre ', '' ),
                'parent_item_colon' => __( 'Parent Genre: ', '' ),
                'new_item_name' => __( 'New Genre ', '' ),
                'add_new_item' => __( 'Add New Genre ', '' ),
                'edit_item' => __( 'Edit Genre ', '' ),
                'update_item' => __( 'Update Genre ', '' ),
                'view_item' => __( 'View Genre ', '' ),
                'add_or_remove_items' => __( 'Add or Remove Genres ', '' ),
                'choose_from_most_used' => __( 'Choose from most used Genres ', '' ),
                'popular_items' => __( 'Popular Genres ', '' ),
                'search_items' => __( 'Search Genres ', '' ),
                'not_found' => __( 'Not Found ', '' ),
                'no_terms' => __( 'No Genres ', '' ),
                'items_list' => __( 'Genres List ', '' ),
                'items_list_navigation' => __( 'Genres List Navigation ', '' ),
            ],
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'show_in_rest' => true,
            'rest_base' => 'genre',
            'rest_controller_class' => 'WP_REST_genre_Terms_Controller',
        ];

        register_taxonomy( 'genre', ['movie'], $args_genre );

        /**
         * Registers the 'Casts' taxonomy.
        */

        $args_casts = [
            'labels' => [
                'name' => _x( 'Casts', 'Taxonomy Name' ),
                'singular_name' => _x( 'Cast', 'Taxonomy Singular Name' ),
                'menu_name' => __( 'Casts ' ),
                'all_items' => __( 'All Casts ' ),
                'parent_item' => __( 'Parent Cast ' ),
                'parent_item_colon' => __( 'Parent Cast: ' ),
                'new_item_name' => __( 'New Cast ' ),
                'add_new_item' => __( 'Add New Cast ' ),
                'edit_item' => __( 'Edit Cast ' ),
                'update_item' => __( 'Update Cast ' ),
                'view_item' => __( 'View Cast ' ),
                'add_or_remove_items' => __( 'Add or Remove Casts ' ),
                'choose_from_most_used' => __( 'Choose from most used Casts ' ),
                'popular_items' => __( 'Popular Casts ' ),
                'search_items' => __( 'Search Casts ' ),
                'not_found' => __( 'Not Found ' ),
                'no_terms' => __( 'No Casts ' ),
                'items_list' => __( 'Casts List ' ),
                'items_list_navigation' => __( 'Casts List Navigation ' ),
            ],
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'show_in_rest' => true,
            'rest_base' => 'cast',
            'rest_controller_class' => 'WP_REST_cast_Terms_Controller',
        ];
    
        register_taxonomy( 'cast', ['movie'], $args_casts );


        /**
         * Registers the 'Production' taxonomy.
        */

        $args_productions = [
        'labels' => [
            'name' => _x( 'Productions', 'Taxonomy Name' ),
            'singular_name' => _x( 'Production', 'Taxonomy Singular Name' ),
            'menu_name' => __( 'Productions ' ),
            'all_items' => __( 'All Productions ' ),
            'parent_item' => __( 'Parent Production ' ),
            'parent_item_colon' => __( 'Parent Production: ' ),
            'new_item_name' => __( 'New Production ' ),
            'add_new_item' => __( 'Add New Production ' ),
            'edit_item' => __( 'Edit Production ' ),
            'update_item' => __( 'Update Production ' ),
            'view_item' => __( 'View Production ' ),
            'add_or_remove_items' => __( 'Add or Remove Productions' ),
            'choose_from_most_used' => __( 'Choose from most used Productions ' ),
            'popular_items' => __( 'Popular Productions ' ),
            'search_items' => __( 'Search Productions ' ),
            'not_found' => __( 'Not Found ' ),
            'no_terms' => __( 'No Productions ' ),
            'items_list' => __( 'Productions List ' ),
            'items_list_navigation' => __( 'Productions List Navigation ' ),
        ],
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'show_in_rest' => true,
        'rest_base' => 'production',
        'rest_controller_class' => 'WP_REST_production_Terms_Controller',
        ];

        register_taxonomy( 'production', ['movie'], $args_productions);

        
        /**
         * Registers the 'country' taxonomy.
         */


        $args_country = [
            'labels' => [
                'name' => _x( 'Countrys', 'Taxonomy Name' ),
                'singular_name' => _x( 'Country', 'Taxonomy Singular Name' ),
                'menu_name' => __( 'Countrys ' ),
                'all_items' => __( 'All Countrys ' ),
                'parent_item' => __( 'Parent Country ' ),
                'parent_item_colon' => __( 'Parent Country: ' ),
                'new_item_name' => __( 'New Country ' ),
                'add_new_item' => __( 'Add New Country ' ),
                'edit_item' => __( 'Edit Country ' ),
                'update_item' => __( 'Update Country ' ),
                'view_item' => __( 'View Country ' ),
                'add_or_remove_items' => __( 'Add or Remove Countrys ' ),
                'choose_from_most_used' => __( 'Choose from most used Countrys ' ),
                'popular_items' => __( 'Popular Countrys ' ),
                'search_items' => __( 'Search Countrys ' ),
                'not_found' => __( 'Not Found ' ),
                'no_terms' => __( 'No Countrys ' ),
                'items_list' => __( 'Countrys List ' ),
                'items_list_navigation' => __( 'Countrys List Navigation ' ),
            ],
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'show_in_rest' => true,
            'rest_base' => 'country',
            'rest_controller_class' => 'WP_REST_country_Terms_Controller',
            ];
            
            register_taxonomy( 'country', ['movie'], $args_country );

    }


    /**
    * Registers the Custom MetaBox.
    */    


    public function add_custom_meta_box() {
        add_meta_box( "cmp_details", 'Movie Details', [$this, 'mo_callback_metabox'], 'movie', 'side', 'default' );
    }

    public function mo_callback_metabox() {

        ob_start();

        include_once plugin_dir_path( __FILE__ ) . 'templates/form_metabox.php';
    
        $template = ob_get_contents();
    
        ob_end_clean();
    
        echo $template;

    }

    public function cmb_save_data($post_id) {

                
        // check and verify nonce value
        if(wp_verify_nonce($_POST['mmp_save_pmetabox_nonce'],'cmb_save_data')) {
            return;
        }

        // wp_nonce_field('mmp_save_page_metabox_data', 'mmp_save_pmetabox_nonce');

        // check and verify auto save of wordpress

        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }



        if(isset($_POST["cmpQualityMovie"])) {
            update_post_meta($post_id, "QualityMovie", $_POST["cmpQualityMovie"]);
        }

        if(isset($_POST["cmpIMDB"])) {
            update_post_meta($post_id, "IMDB", $_POST["cmpIMDB"]);
        }

        if(isset($_POST["cmpReleased"])) {
            update_post_meta($post_id, "Released", $_POST["cmpReleased"]);
        }

        if(isset($_POST["cmpDuration"])) {
            update_post_meta($post_id, "Duration", $_POST["cmpDuration"]);
        }

    }



 }


 $movie_cpt = new Movie_CPT();

 $movie_cpt->activate();

 register_activation_hook( __FILE__ , array( $movie_cpt, 'activate'));

 register_deactivation_hook( __FILE__ , array( $movie_cpt, 'deactivate'));










