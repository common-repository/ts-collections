<?php
/**
 * @since 1.1.0
 * @author: Rahul Taiwala
 */
class contentClipsEditorIcon
{
	/** @var string $shortCode */
	
	/**
	 * Initializes the shortcode
	 *
	 * @since 1.0.0
	 */
	static function init()
	{
		// TinyMCE options
		add_action( 'wp_ajax_contentclipsTinymceOptions', array( __CLASS__, 'tinymce_options' ) );
		add_action( 'admin_init', array( __CLASS__, 'load_tinymce' ) );

		
	}

	static function load_tinymce() {
		if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && get_user_option( 'rich_editing' ) == 'true' ) {
            
			add_filter( 'mce_external_plugins', array( __CLASS__, 'tinymce_add_plugin' ) );
			add_filter( 'mce_buttons', array( __CLASS__, 'tinymce_register_button' ) );
		}
	}

	/**
	 * TinyMCE dialog content
	 */
	static function tinymce_options() {
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
		<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<script type="text/javascript" src="../wp-includes/js/tinymce/tiny_mce_popup.js?ver=327-1235"></script>
			<script type="text/javascript" src="../wp-includes/js/tinymce/utils/form_utils.js?ver=327-1235"></script>
			<script type="text/javascript" src="../wp-includes/js/tinymce/utils/editable_selects.js?ver=327-1235"></script>

			<script type="text/javascript" src="../wp-includes/js/jquery/jquery.js"></script>

			<script type="text/javascript">

				tinyMCEPopup.storeSelection();

				var insertContentClip = function (ed) {

					tinyMCEPopup.restoreSelection();

					output = '[content_clips';

					

					
					//insert title
					if (jQuery('#cc-title').val())
						output += ' title="' + jQuery('#cc-title').val() + '"';

					if (jQuery('#cc-content-clip').val())
						output += ' id="'+jQuery('#cc-content-clip').val() + '"';


					output += ']' + tinyMCEPopup.editor.selection.getContent() + '[/content_clips]';

					tinyMCEPopup.execCommand('mceInsertContent', 0, output);
					tinyMCEPopup.editor.execCommand('mceRepaint');
					tinyMCEPopup.editor.focus();
					// Return
					tinyMCEPopup.close();
				};
			</script>
			<style type="text/css">
				td.info {
					vertical-align: top;
					color: #777;
					width: 150px;
				}
			</style>

			<title><?php _e( "Content Clips", 'content-clips' ); ?></title>
		</head>
		<body style="display: none">
		<form onsubmit="insertContentClip();return false;" action="#">

			<div id="general_panel" class="panel current">
				<fieldset>
					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td><label for="cc-title"><?php _e( "Title", 'content-clips' ); ?></label></td>
							<td>
								<input type="text" id="cc-title" name="cc-title" value="" style="width:100%"/>
							</td>
						</tr>
						
					</table>
				</fieldset>
				<br/>
				<fieldset>
					<table border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td><label for="cc-content-clip"><?php _e( "Content Clip", 'content-clips' ); ?></label></td>
							<td>
								<select id="cc-content-clip" name="cc-clip-id">
								    <option value=""></option>
									<?php
                                    $res=self::ts_get_content_clips();
                                    
									foreach ($res as $r ) {
										
										echo '<option value="' . $r['value'] . '">' . $r['label'] . '</option>';
									}
									?>
								</select>
								
							</td>
							
						</tr>
						
					</table>
				</fieldset>
			</div>

			<div class="mceActionPanel">
				<div style="float: left">
					<input type="button" id="cancel" name="cancel" value="<?php _e( "Cancel", 'content-clips' ); ?>"
					       onclick="tinyMCEPopup.close();"/>
				</div>

				<div style="float: right">
					<input type="submit" id="insert" name="insert" value="<?php _e( "Insert", 'content-clips' ); ?>"/>
				</div>
			</div>
		</form>
		</body>
		</html>
		<?php
		exit( 0 );
	}

	/**
	 * @see    http://codex.wordpress.org/TinyMCE_Custom_Buttons
	 */
	static function tinymce_register_button( $buttons ) {
		array_push( $buttons, "separator", "contentclips" );

		return $buttons;
	}

	/**
	 * @see    http://codex.wordpress.org/TinyMCE_Custom_Buttons
	 */
	static function tinymce_add_plugin( $plugin_array ) {
		$plugin_array['contentclips'] = plugins_url( '../js/contentclip_plugin.js',__FILE__ );

		return $plugin_array;
	}

	// return all content clips
    static function ts_get_content_clips() {
        $argz = array( 'post_type' => array( contentClipsPostType::$postType ), 'post_status' => 'publish', 'posts_per_page' => -1 );
        $wp_pages = get_posts( $argz );
        $result = array();
        foreach( $wp_pages as $pge ) {
            $result[] = array( 'value' => $pge->ID, 'label' => $pge->post_title );
        }
        return $result;
    }

	
}