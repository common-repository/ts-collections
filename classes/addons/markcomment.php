<?php
/*
 Addon Name: Mark Comment as Spam  
 Description: Mark Comments with Very Long URLs as Spam.
 Author: Rahul Taiwala
 Author URI: http://www.rktaiwala.in
 Addon Id: 101
 Version: 1.0.1
 class: MarkComment
 */

class MarkComment
{
	/** @var string $version */
	static $version = '1.0.1';
	static $addonID= '101';
	static $addonName= 'mark_comment';

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
        
        add_filter( 'pre_comment_approved', array(__CLASS__,'rkv_url_spamcheck'), 99, 2 );
        
    }
    
    static function rkv_url_spamcheck( $approved , $commentdata ) {
        return ( strlen( $commentdata['comment_author_url'] ) > 50 ) ? 'spam' : $approved;
    }
    
    static function register_addon($data){

        return array_merge($data,array('addon_id_'.self::$addonID=>false));
    }
    /**
	 * Includes backend script.
	 *
	 * Should always be called on the admin_enqueue_scrips hook.
	 *
	 * @since 1.0.0
	 */
	static function enqueueBackendScripts()
	{
		// Function get_current_screen() should be defined
		if (!function_exists('get_current_screen'))
		{
			return;
		}

		$currentScreen = get_current_screen();

		// Enqueue 3.5 uploader
		

		
	}
	
    
	
}

MarkComment::bootStrap();
