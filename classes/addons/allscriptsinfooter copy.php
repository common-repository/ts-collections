<?php
/*
 Addon Name: All JavaScripts in Footer 
 Description: Enqueue all scripts in Footer
 Author: Rahul Taiwala
 Author URI: http://www.rktaiwala.in
 Addon Id: 109
 Version: 1.0.1
 class: AJIF_addon
 */

class AJIF_addon
{
	/** @var string $version */
	static $version = '1.0.1';
	static $addonID= '109';
	static $addonName= 'AJIF_addon';

	/**
	 * Bootstraps the application by assigning the right functions to
	 * the right action hooks.
	 *
	 * @since 1.0.0
	 */
	static function bootStrap()
	{
        add_filter( 'tlo_settings_default_data', array(__CLASS__,'register_addon'),99,1);
		
	}
   
    static function on_active(){
        
        //add_action( 'wp_default_scripts', array(__CLASS__,'jquery_in_footer' ));
        add_action('after_setup_theme', array(__CLASS__,'jquery_in_footer'));
    }
    
    static function jquery_in_footer(){
        if ( ! is_admin() ){
           //$scripts->add_data( 'jquery-core', 'group', 1 );
           //$scripts->add_data( 'jquery-migrate', 'group', 1 );
            remove_action('wp_head', 'wp_print_scripts');
            remove_action('wp_head', 'wp_print_head_scripts', 9);
            remove_action('wp_head', 'wp_enqueue_scripts', 1);
            add_action('wp_footer', 'wp_print_scripts', 5);
            add_action('wp_footer', 'wp_enqueue_scripts', 5);
            add_action('wp_footer', 'wp_print_head_scripts', 5);
        }
        
        //print_r($scripts);
    }
    
    static function register_addon($data){

        return array_merge($data,array('addon_id_'.self::$addonID=>false));
    }
    
	
    
	
}

AJIF_addon::bootStrap();
