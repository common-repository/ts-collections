<?php
/**
 * @since 1.1.0
 * @author: Rahul Taiwala
 */
class contentClipsShortcode
{
	/** @var string $shortCode */
	public static $shortCode = 'content_clips';
	/**
	 * Initializes the shortcode
	 *
	 * @since 1.0.0
	 */
	static function init()
	{
		// Register shortcode
		add_shortcode(self::$shortCode, array(__CLASS__, 'content_clips_init'));

		
	}

	/**
	 * Function canvas_paint_shortcode_init Outputs the canvas app HTML
	 *
	 * @since 1.1.0
	 * @param mixed $attributes
	 * @return String $output
	 */
	static function content_clips_init($attributes)
	{
		
		$output   = '';
        $output = self::prepare($attributes);
		

		// Return output
		return $output;
	}

	/**
	 * Function prepare returns the code for the Canvas Paint .
	 *
	 * @since 1.0.0
	 * 
	 * @return String $content
	 */
	static function prepare($atts)
	{
        extract( shortcode_atts( array( 'title' => '', 'id' => '' ), $atts ) );
        $output = '';
        if( !empty( $section_title ) ) $output .= '<h1 class="title-widget">' . esc_attr( $section_title ) . '</h1>';
        if( !empty( $id ) ) {
            // query
            $argz = array( 'page_id' => intval( $id ), 'post_type' => contentClipsPostType::$postType );
            $clip_page = new WP_Query( $argz );
            if( !$clip_page->have_posts() ) $output .= '<div class="alert alert-danger">' . __( 'No entries found!', 'content-clips' ) . '</div>';
            else {
                while( $clip_page->have_posts() ) : $clip_page->the_post();

                    // print it
                    $output .= do_shortcode( get_the_content() );

                endwhile;
            }

            wp_reset_query();

        }

        return $output;
	}



	
}