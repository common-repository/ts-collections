<?php
/**
 * 
 * 
 *
 * @since 1.0.0
 * @author: rktaiwala
 */

class contentClipsPostType
{
    /** @var string $nonceAction */
	static $nonceAction = 'contentClips-nonceAction';
	/** @var string $nonceName */
	static $nonceName = 'contentClips-nonceName';
	/** @var string $postType */
	static $postType = 'contentclips';//You can change this
	/**
	 * @since 1.3.0
	 */
	static function init()
	{
		add_action('init'                 , array(__CLASS__, 'registerPostType'));
		add_action('save_post'            , array(__CLASS__, 'save'));
		

		add_filter('post_updated_messages', array(__CLASS__, 'alterMessages'));
        add_filter( 'manage_edit-contentclips_columns',array(__CLASS__, 'ts_edit_content_clips_columns' ));
        add_action( 'manage_contentclips_posts_custom_column', array(__CLASS__,'ts_manage_content_clips_columns'), 10, 2 );
	}

	/**
	 
	 * @since 1.0.0
	 */
	static function registerPostType()
	{
		global $wp_version;

		register_post_type(
			self::$postType,
			array(
				'labels'               => array(
					'name'               => __('Content Clips', 'content-clips'),
					'singular_name'      => __('Add Content Clip', 'content-clips'),
					'add_new_item'       => __('Add New Content Clip', 'content-clips'),
					'edit_item'          => __('Edit Content Clip', 'content-clips'),
					'new_item'           => __('New Content Clip', 'content-clips'),
					'view_item'          => __('View Content Clip', 'content-clips'),
					'search_items'       => __('Search Content Clip', 'content-clips'),
					'not_found'          => __('No Content Clip found', 'content-clips'),
					'not_found_in_trash' => __('No Content Clip found', 'content-clips')
				),
				'public'               => true,
				'publicly_queryable'   => true,
                'exclude_from_search'  => true,
				'show_ui'              => true,
                'show_in_menu'         => true,
				'query_var'            => true,
				'rewrite'              => array( 'slug' => 'contentclips' ),
				'capability_type'      => 'page',
				'has_archive'          => true,
				'hierarchical'         => false,
				'menu_position'        => 18,
				'menu_icon'            => version_compare($wp_version, '3.8', '>') ? contentClips::getPluginUrl() . '/images/content-clip.png' : 'dashicons-format-gallery',
				'supports'             => array('title','editor'),
                'register_meta_box_cb' => array(__CLASS__, 'registerMetaBoxes')
				
			)
		);
	}
    
    
    static function ts_edit_content_clips_columns( $columns ) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Content Title', 'content-clips' ),
            'c_shortcode' => __( 'Content Shortcode', 'content-clips' ),
            'date' => __( 'Date posted', 'content-clips' )
        );
        return $columns;
    }
    

    // fill up with data
    static function ts_manage_content_clips_columns( $column, $post_id ) {

        global $post;

        switch( $column ) {

            case 'c_shortcode' : 

                // extract post meta...
                $all_meta = get_post_meta($post_id, 'content-clips-shortcode', true);
                //$post_content_meta_arr = unserialize( implode( '', $all_meta[ 'content-clips-shortcode' ] ) );
                $shortcode_code = $all_meta;

                if( !empty( $shortcode_code ) ) echo $shortcode_code;
                else echo _x( '-----', 'non-existing table value', 'content-clips' );
                
                break;

            default : break;
        }
    }
    
   
	/**
	 
	 * @since 1.0.0
	 */
	static function registerMetaBoxes()
	{
		add_meta_box(
			'content-clips-shortcode-info',
			__('Shortcode Information', 'content-clips'),
			array(__CLASS__, 'content_clips_meta_box'),
			self::$postType,
			'side',
			'high'
		);
        
		
	}

	/**
	 * 
	 * @since 1.0.0
	 * @param mixed $messages
	 * @return mixed $messages
	 */
	static function alterMessages($messages)
	{
		if (!function_exists('get_current_screen'))
		{
			return $messages;
		}

		$currentScreen = get_current_screen();

		// Return 
		if ($currentScreen->post_type != contentClipsPostType::$postType)
		{
			return $messages;
		}

		$messageID = filter_input(INPUT_GET, 'message', FILTER_VALIDATE_INT);

		if (!$messageID)
		{
			return $messages;
		}

		switch ($messageID)
		{
			case 6:
				$messages[$currentScreen->base][$messageID] = __('Content Clip created', 'content-clips');
				break;

			default:
				$messages[$currentScreen->base][$messageID] = __('Content Clip updated', 'content-clips');
		}

		return $messages;
	}

	
	/**
	 *
	 *
	 * @since 1.0.0
	 */
	static function content_clips_meta_box()
	{
		global $post;
        wp_nonce_field(self::$nonceAction, self::$nonceName);
		
		$shortCode = htmlentities(sprintf('[' . contentClipsShortcode::$shortCode . ' id=\'%s\']', $post->ID));

		?>
		<p><?php _e('To use this Content Clips Copy-paste Content clips shortcode to display content in widget ready sections or other pages or posts.', 'content-clips'); ?>:</p>
<p><i><?php echo $shortCode; ?></i>
        <input id="content-clips-shortcode" type="hidden"  name="content-clips-shortcode" value="<?php echo $shortCode ?>" />
    </p>
		<?php

	}

	static function save($postId)
	{
		// Verify nonce, check if user has sufficient rights and return on auto-save.
		if (get_post_type($postId) != self::$postType ||
			(!isset($_POST[self::$nonceName]) || !wp_verify_nonce($_POST[self::$nonceName], self::$nonceAction)) ||
			(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE))
		{
			return $postId;
		}

		if ( ! current_user_can( 'edit_post', $postId ) )
            return $post_id; 

        //your code to handle metabox			
        if(isset($_POST['content-clips-shortcode']))
            update_post_meta( $postId, 'content-clips-shortcode', $_POST['content-clips-shortcode'] ); 
        
		return $postId;
	}
    
    
}