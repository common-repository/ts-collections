<?php
/*
 Addon Name: Minimum Comment Length  
 Description: Require Minimum Comment Length.
 Author: Rahul Taiwala
 Author URI: http://www.rktaiwala.in
 Addon Id: 102
 Version: 1.0.1
 class: MinimumCommentLength
 */

class MinimumCommentLength
{
	/** @var string $version */
	static $version = '1.0.1';
	static $addonID= '102';
	static $addonName= 'minimum_comment_length';

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
        
        add_filter( 'preprocess_comment', array(__CLASS__,'minimal_comment_length'), 99, 2 );
        
    }
    
    static function minimal_comment_length( $commentdata ) {
        $minimalCommentLength = 20;
        if ( strlen( trim( $commentdata['comment_content'] ) ) < $minimalCommentLength ){
            wp_die( 'All comments must be at least ' . $minimalCommentLength . ' characters long.' );
        }
        return $commentdata;
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

MinimumCommentLength::bootStrap();
