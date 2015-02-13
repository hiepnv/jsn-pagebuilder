<?php
/**
 * @version    $Id$
 * @package    JSN_PageBuilder
 * @author     JoomlaShine Team <support@joomlashine.com>
 * @copyright  Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

// No direct access to this file.
defined('_JEXEC') || die('Restricted access');

include_once 'helpers/helper.php';

/**
 * Video shortcode element
 *
 * @package  JSN_PageBuilder
 * @since    1.0.0
 */
class JSNPBShortcodeVideo extends IG_Pb_Element {

	/**
	 * Constructor
	 *
	 * @return type
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Include admin scripts
	 * 
	 * @return type
	 */
	public function backend_element_assets() {
		$document = JFactory::getDocument();
		$document->addScript( JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-select2/select2.min.js', 'text/javascript' );
		$document->addStyleSheet( JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-select2/select2.css', 'text/css' );
		$document->addScript( JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-colorpicker/js/colorpicker.js', 'text/javascript' );
		$document->addStyleSheet( JSNPB_FRAMEWORK_ASSETS . '/3rd-party/jquery-colorpicker/css/colorpicker.css', 'text/css' );
		$document->addScript( JSNPB_ADMIN_URL . '/assets/joomlashine/js/jsn-colorpicker.js', 'text/javascript' );
		$document->addScript( JSNPB_ELEMENT_URL.'/video/assets/js/video-setting.js', 'text/javascript' );
	}
	
	/**
	 * DEFINE configuration information of shortcode
	 *
	 * @return type
	 */
	public function element_config() {
		$this->config['shortcode'] = 'pb_video';
		$this->config['name']      = JText::_( 'Video' );
		$this->config['cat']       = JText::_( 'Media' );
		$this->config['icon']      = 'icon-video';
		$this->config['description'] = JText::_("Embed Youtube/Vimeo or local file player");
	}

	/**
	 * DEFINE setting options of shortcode
	 *
	 * @return type
	 */
	public function element_items() {
		$this->items = array(
			// video source dropdown list on top.
			'generalaction' => array(
				'settings' => array(
					'id'    => 'general_action',
					'class' => 'general-action no-label pull-left',
				),
				array(
					'id'         => 'video_sources',
					'type'       => 'select',
					'has_depend' => '1',
					'std'        => 'local',
					'options'    => array(
						'local'   => JText::_( 'Local file' ),
						'youtube' => JText::_( 'Youtube' ),
						'vimeo'   => JText::_( 'Vimeo' )
					)
				)
			),
			// Content Tab
			'content' => array(
				array(
					'name'    => JText::_( 'Element Title' ),
					'id'      => 'el_title',
					'type'    => 'text_field',
					'class'   => 'jsn-input-xxlarge-fluid',
					'std'     => JText::_( 'Video PB_INDEX_TRICK' ),
					'role'    => 'title',
					'tooltip' => JText::_( 'Set title for current element for identifying easily' )
				),
				array(
					'id'          => 'video_source_local',
					'name'        => JText::_( 'File URL' ),
					'type'        => 'select_media',
					'filter_type' => 'video',
					'media_type'  => 'video',
					'class'       => 'jsn-input-large-fluid',
					'dependency'  => array( 'video_sources', '=', 'local' ),
					'tooltip'     => JText::_( 'Select video file' ),
				),
				// Youtube.
				array(
					'id'         => 'video_source_link_youtube',
					'name'       => JText::_( 'Video link' ),
					'type'       => 'text_append',
					'type_input' => 'text',
					'dependency' => array( 'video_sources', '=', 'youtube' ),
					'class'      => 'span6 jsn-input-xxlarge-fluid',
					'tooltip'    => JText::_( 'Set video link' ),
				),
				// Vimeo.
				array(
					'id'         => 'video_source_link_vimeo',
					'name'       => JText::_( 'Video link' ),
					'type'       => 'text_append',
					'type_input' => 'text',
					'dependency' => array( 'video_sources', '=', 'vimeo' ),
					'class'      => 'span6 jsn-input-xxlarge-fluid',
					'tooltip'    => JText::_( 'Set video link' ),
				),
			),
			// Styling tab .
			'styling' => array(
				array(
					'type' => 'preview',
				),
				/**
				 * Parameters for local video
				 */
				array(
					'name'                         => JText::_( 'Dimension' ),
					'container_class'              => 'combo-group',
					'dependency'                   => array( 'video_sources', '=', 'local' ),
					'id'                           => 'video_local_dimension',
					'type'                         => 'dimension',
					'extended_ids'                 => array( 'video_local_dimension_width', 'video_local_dimension_height' ),
					'video_local_dimension_width'  => array( 'std' => '500' ),
					'video_local_dimension_height' => array( 'std' => '330' ),
					'tooltip' => JText::_( 'Set width and height of element' ),
				),
				array(
					'name'            => JText::_( 'Elements' ),
					'id'              => 'video_local_elements',
					'type'            => 'checkbox',
					'class'           => 'jsn-column-item checkbox',
					'container_class' => 'jsn-columns-container jsn-columns-count-two',
					'dependency'      => array( 'video_sources', '=', 'local' ),
					'std'             => 'play_button__#__overlay_play_button__#__current_time__#__time_rail__#__track_duration__#__volume_button__#__volume_slider__#__fullscreen_button',
					'options'         => array(
						'play_button' => JText::_( 'Play/Pause Button' ),
						'overlay_play_button' => JText::_( 'Overlay Play Button' ),
						'current_time'        => JText::_( 'Current Time' ),
						'time_rail'           => JText::_( 'Time Rail' ),
						'track_duration'      => JText::_( 'Track Duration' ),
						'volume_button'       => JText::_( 'Volume Button' ),
						'volume_slider'       => JText::_( 'Volume Slider' ),
						'fullscreen_button'   => JText::_( 'Fullscreen Button' )
					),
					'tooltip' => JText::_( 'Select elements you want to show' ),
				),
				array(
					'name'         => JText::_( 'Start volume' ),
					'id'           => 'video_local_start_volume',
					'type'         => 'text_append',
					'type_input'   => 'number',
					'class'        => 'jsn-input-number input-mini',
					'parent_class' => 'combo-item',
					'std'          => '80',
					'append'       => '%',
					'dependency'   => array( 'video_sources', '=', 'local' ),
					'validate'     => 'number',
					'tooltip'      => JText::_( 'Set start volumn for the video player' ),
				),
				array(
					'name'       => JText::_( 'Loop' ),
					'id'         => 'video_local_loop',
					'type'       => 'radio',
					'std'        => 'false',
					'dependency' => array( 'video_sources', '=', 'local' ),
					'options'    => array(
						'true'  => JText::_( 'Yes' ),
						'false' => JText::_( 'No' )
					),
					'tooltip' => JText::_( 'Whether to repeat playing or not' ),
				),
				// Youtube video parameters
				array(
					'name'                           => JText::_( 'Dimension' ),
					'container_class'                => 'combo-group',
					'dependency'                     => array( 'video_sources', '=', 'youtube' ),
					'id'                             => 'video_youtube_dimension',
					'type'                           => 'dimension',
					'extended_ids'                   => array( 'video_youtube_dimension_width', 'video_youtube_dimension_height' ),
					'video_youtube_dimension_width'  => array( 'std' => '500' ),
					'video_youtube_dimension_height' => array( 'std' => '270' ),
					'tooltip' => JText::_( 'Set width and height of element' ),
				),
				array(
					'name'       => JText::_( 'Show List' ),
					'id'         => 'video_youtube_show_list',
					'type'       => 'radio',
					'std'        => '0',
					'dependency' => array( 'video_sources', '=', 'youtube' ),
					'options'    => array(
						'1' => JText::_( 'Yes' ),
						'0' => JText::_( 'No' )
					)
				),
				array(
					'name'       => JText::_( 'Auto Play' ),
					'id'         => 'video_youtube_autoplay',
					'type'       => 'radio',
					'std'        => '0',
					'dependency' => array( 'video_sources', '=', 'youtube' ),
					'options'    => array(
						'1' => JText::_( 'Yes' ),
						'0' => JText::_( 'No' )
					),
					'tooltip' => JText::_( 'Auto play the video' ),
				),
				array(
					'name'       => JText::_( 'Loop' ),
					'id'         => 'video_youtube_loop',
					'type'       => 'radio',
					'std'        => '0',
					'dependency' => array( 'video_sources', '=', 'youtube' ),
					'options'    => array(
						'1' => JText::_( 'Yes' ),
						'0' => JText::_( 'No' )
					),
					'tooltip' => JText::_( 'Whether to repeat playing or not' ),
				),
				array(
					'name'       => JText::_( 'Controls Auto Hide' ),
					'id'         => 'video_youtube_autohide',
					'type'       => 'select',
					'std'        => '2',
					'dependency' => array( 'video_sources', '=', 'youtube' ),
					'options'    => array(
						'2' => JText::_( 'Auto minimize Progress Bar' ),
						'1' => JText::_( 'Both after playing a couple seconds' ),
						'0' => JText::_( 'Never Hide' )
					),
					'tooltip' => JText::_( 'Whether Auto hide controls or not' ),
				),
				array(
					'name'       => JText::_( 'Show Caption (CC )' ),
					'id'         => 'video_youtube_cc',
					'type'       => 'radio',
					'std'        => '0',
					'dependency' => array( 'video_sources', '=', 'youtube' ),
					'options'    => array(
						'1' => JText::_( 'Never' ),
						'0' => JText::_( 'Yes' )
					),
					'tooltip' => JText::_( 'Whether to showing caption or not' ),
				),
				// Vimeo video parameters
				array(
					'name'                         => JText::_( 'Dimension' ),
					'container_class'              => 'combo-group',
					'dependency'                   => array( 'video_sources', '=', 'vimeo' ),
					'id'                           => 'video_vimeo_dimension',
					'type'                         => 'dimension',
					'extended_ids'                 => array( 'video_vimeo_dimension_width', 'video_vimeo_dimension_height' ),
					'video_vimeo_dimension_width'  => array( 'std' => '500' ),
					'video_vimeo_dimension_height' => array( 'std' => '270' ),
					'tooltip' => JText::_( 'Set width and height of element' ),
				),
				array(
					'name'       => JText::_( 'Auto Play' ),
					'id'         => 'video_vimeo_autoplay',
					'type'       => 'radio',
					'std'        => 'false',
					'dependency' => array( 'video_sources', '=', 'vimeo' ),
					'options'    => array(
						'true'  => JText::_( 'Yes' ),
						'false' => JText::_( 'No' )
					),
					'tooltip' => JText::_( 'Auto play the video' ),
				),
				array(
					'name'       => JText::_( 'Loop' ),
					'id'         => 'video_vimeo_loop',
					'type'       => 'radio',
					'std'        => 'false',
					'dependency' => array( 'video_sources', '=', 'vimeo' ),
					'options'    => array(
						'true'  => JText::_( 'Yes' ),
						'false' => JText::_( 'No' )
					),
					'tooltip' => JText::_( 'Whether to repeat playing or not' ),
				),
				array(
					'name'       => JText::_( 'Controls Color' ),
					'id'         => 'video_vimeo_color',
					'type'       => 'color_picker',
					'std'        => '#54BBFC',
					'dependency' => array( 'video_sources', '=', 'vimeo' ),
					'hide_value' => true,
					'tooltip' => JText::_( 'Set color of controls' ),
				),
				array(
					'type' => 'hr',
				),
				// Basic styling parameters
				array(
					'name'    => JText::_( 'Alignment' ),
					'id'      => 'video_alignment',
					'type'    => 'select',
					'std'     => 'center',
					'options' => array(
						'0'      => JText::_( 'No Alignment' ),
						'left'   => JText::_( 'Left' ),
						'right'  => JText::_( 'Right' ),
						'center' => JText::_( 'Center' ),
					),
					'tooltip' => JText::_( 'Setting position: right, left, center, inherit parent style' ),
				),
				array(
					'name'            => JText::_( 'Margin' ),
					'container_class' => 'combo-group',
					'id'              => 'video_margin',
					'type'            => 'margin',
					'extended_ids'    => array( 'video_margin_top', 'video_margin_right', 'video_margin_bottom', 'video_margin_left' ),
					'tooltip'         => JText::_( 'Set margin size' ),
				),
			)
		);
	}

	/**
	 * DEFINE shortcode content
	 *
	 * @param type $atts
	 * @param type $content
	 *
	 * @return string
	 */
	public function element_shortcode( $atts = null, $content = null ) {
		$html_element = '';
		if ( $atts['video_sources'] == 'local' ) {
			$atts['video_local_dimension_width'] = $atts['video_local_dimension_width'] ? $atts['video_local_dimension_width'] : '100%';
			$arr_params                          = ( JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts ) );
			if ( empty( $arr_params['video_source_local'] ) ){
				$html_element = "<p class='jsn-bglabel'>" . JText::_( 'No video file selected' ) . '</p>';
			} else {
				$this->load_local_video_assets();
				$html_element = $this->generate_local_file( $arr_params );
			}
		} else if ( $atts['video_sources'] == 'youtube' ) {
			$atts['video_youtube_dimension_width'] = $atts['video_youtube_dimension_width'] ? $atts['video_youtube_dimension_width'] : '100%';
			$arr_params                            = ( JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts ) );
			if ( empty( $arr_params['video_source_link_youtube'] ) ){
				$html_element = "<p class='jsn-bglabel'>" . JText::_( 'No video file selected' ) . '</p>';
			} else {
				$html_element = $this->generate_youtube( $arr_params );
			}
		} else if ( $atts['video_sources'] == 'vimeo' ) {
			$atts['video_vimeo_dimension_width'] = $atts['video_vimeo_dimension_width'] ? $atts['video_vimeo_dimension_width'] : '100%';
			$arr_params                              = ( JSNPagebuilderHelpersShortcode::shortcodeAtts( $this->config['params'], $atts ) );
			if ( empty( $arr_params['video_source_link_vimeo'] ) ){
				$html_element = "<p class='jsn-bglabel'>" . JText::_( 'No video file selected' ) . '</p>';
			} else {
				$html_element = $this->generate_vimeo( $arr_params );
			}
		}

		return $this->element_wrapper( $html_element, $arr_params );
	}

	/**
	 * Generate HTML for local video player
	 * 
	 * @return string
	 */
	function generate_local_file( $params ) {
		$random_id = JSNPagebuilderHelpersShortcode::generateRandomString();
		$video_size = array();
		$video_size['width']  = ' width="' . $params['video_local_dimension_width'] . '" ';
		$video_size['height'] = ( $params['video_local_dimension_height'] != '' ) ? ' height="' . $params['video_local_dimension_height'] . '" ' : '';

		$player_options = '{';
		$player_options .= $params['video_local_start_volume'] ? 'startVolume: ' . ( int ) $params['video_local_start_volume'] / 100 . ',' : '';
		$player_options .= $params['video_local_loop'] ? 'loop: ' . $params['video_local_loop'] . ',' : '';

		$_progress_bar_color = isset($params['video_local_progress_color']) ? '$(".mejs-time-loaded, .mejs-horizontal-volume-current", video_container).css("background", "none repeat scroll 0 0 ' . $params['video_local_progress_color'] . '");' : '';

		$params['video_local_elements'] = explode( '__#__', $params['video_local_elements'] );

		$player_elements = '';
		$player_elements .= in_array( 'play_button', $params['video_local_elements'] ) ? '' : '$(".mejs-playpause-button", video_container).hide();';
		$player_elements .= in_array( 'overlay_play_button', $params['video_local_elements'] ) ? '' : '$(".mejs-overlay-button", video_container).hide();';
		$player_elements .= in_array( 'current_time', $params['video_local_elements'] ) ? '' : '$(".mejs-currenttime-container", video_container).hide();';
		$player_elements .= in_array( 'time_rail', $params['video_local_elements'] ) ? '' : '$(".mejs-time-rail", video_container).hide();';
		$player_elements .= in_array( 'track_duration', $params['video_local_elements'] ) ? '' : '$(".mejs-duration-container", video_container).hide();';
		$player_elements .= in_array( 'volume_button', $params['video_local_elements'] ) ? '' : '$(".mejs-volume-button", video_container).hide();';
		$player_elements .= in_array( 'volume_slider', $params['video_local_elements'] ) ? '' : '$(".mejs-horizontal-volume-slider", video_container).hide();';
		$player_elements .= in_array( 'fullscreen_button', $params['video_local_elements'] ) ? '' : '$(".mejs-fullscreen-button", video_container).hide();';

		// Alignment
		$container_class = 'local_file ';
		$container_style = '';
		if ( $params['video_alignment'] === 'right' ) {
			$container_style .= 'float: right;';
			$container_class .= 'clearafter ';
		} else if ( $params['video_alignment'] === 'center' ) {
			$container_style .= 'margin: 0 auto;';
		} else if ( $params['video_alignment'] === 'left' ) {
			$container_style .= 'float: left;';
			$container_class .= 'clearafter ';
		}
		// Genarate Container class
		$container_class = $container_class ? ' class="' . $container_class . '" ' : '';

		$player_options .= 'defaultVideoHeight:' . ( intval( $params['video_local_dimension_height'] ) - 10 ) . ',';
		$player_options .= 'success: function(mediaElement, domObject){

var video_container= $(domObject).parents(".mejs-container");
' . $player_elements . '
},';
		$player_options .= 'keyActions:[], pluginPath:"' . JSNPB_PLG_SYSTEM_ASSETS_URL . '3rd-party/mediaelement/' . '"}';

		if ( isset( $params['video_source_local'] ) && $params['video_source_local'] != '' ) {
			$script = '
			JoomlaShine.jQuery(document).ready(function ($){
			new MediaElementPlayer("#' . $random_id . '",
			' . $player_options . '
			);
			});';
			$document = JFactory::getDocument();
			$document->addScriptDeclaration( $script, 'text/javascript' );
		}

		$container_style .= (isset($params['video_margin_left']) && $params['video_margin_left'] != '') ? 'margin-left:' . $params['video_margin_left'] . 'px;' : '';
		$container_style .= (isset($params['video_margin_top']) && $params['video_margin_top'] != '') ? 'margin-top:' . $params['video_margin_top'] . 'px;' : '';
		$container_style .= (isset($params['video_margin_right']) && $params['video_margin_right'] != '') ? 'margin-right:' . $params['video_margin_right'] . 'px;' : '';
		$container_style .= (isset($params['video_margin_bottom']) && $params['video_margin_bottom'] != '') ? 'margin-bottom:' . $params['video_margin_bottom'] . 'px;' : '';
		// This under is the fix for Chrome video dimension issue
		$container_style .= 'width: ' . $params['video_local_dimension_width'] . 'px;';
		$container_style .= 'height: ' . ($params['video_local_dimension_height'] + 5) . 'px;';

		$container_style = $container_style ? ' style=" ' . $container_style . ' " ' : '';

		// Define the media type
		$src    = str_replace( ' ', '+', urldecode( $params['video_source_local'] ) );
		$source = '<source type="%s" src="%s" />';
		$type   = JSNPagebuilderHelpersShortcode::checkFiletype( $src );
		$source = sprintf( $source, $type['type'], $src );

		$video  = '<video id="' . $random_id . '" ' . $video_size['width'] . $video_size['height'] . ' controls="controls" preload="none" src="' . $src . '">
' . $source . '
</video>';

		return '<div ' . $container_class . $container_style . '>'
				. $video . '
</div><div class="clear:both"></div>';
	}

	/**
	 * Generate HTML for Youtube
	 * 
	 * @return string
	 */
	function generate_youtube( $params ) {
		$random_id = JSNPagebuilderHelpersShortcode::generateRandomString();

		$_w = ' width="' . $params['video_youtube_dimension_width'] . '" ';
		$_h = $params['video_youtube_dimension_height'] ? ' height="' . $params['video_youtube_dimension_height'] . '" ' : '';

		// Alignment
		$container_class = '';
		$object_style = '';
		if ( $params['video_alignment'] === 'right' ) {
			$object_style    .= 'float:right;';
			$container_class .= 'clearafter ';
		} else if ( $params['video_alignment'] === 'center' ) {
			$object_style .= 'margin: 0 auto;';
		} else if ( $params['video_alignment'] === 'left' ) {
			$object_style    .= 'float:left;';
			$container_class .= 'clearafter ';
		}

		// Genarate Container class
		$container_class = $container_class ? 'class="' . $container_class . '" ' : '';

		// Margin.
		$container_style = '';
		$container_style .= (isset($params['video_margin_left']) && $params['video_margin_left'] != '') ? 'margin-left:' . $params['video_margin_left'] . 'px;' : '';
		$container_style .= (isset($params['video_margin_top']) && $params['video_margin_top'] != '') ? 'margin-top:' . $params['video_margin_top'] . 'px;' : '';
		$container_style .= (isset($params['video_margin_right']) && $params['video_margin_right'] != '') ? 'margin-right:' . $params['video_margin_right'] . 'px;' : '';
		$container_style .= (isset($params['video_margin_bottom']) && $params['video_margin_bottom'] != '') ? 'margin-bottom:' . $params['video_margin_bottom'] . 'px;' : '';
		$container_style = $container_style ? ' style=" ' . $container_style . ' " ' : '';

		$params['video_source_link_youtube'] = urldecode( $params['video_source_link_youtube'] );
		// Get video ID.
		$video_info = JSNPbVideoHelper::getYoutubeVideoInfo( $params['video_source_link_youtube'] );
		$video_info = json_decode( $video_info );
		if ( ! $video_info )
			return;
		$video_info = $video_info->html;
		$_arr = array();
		$video_src = '';
		preg_match( '/src\s*\n*=\s*\n*"([^"]*)"/i', $video_info, $_arr );

		if ( count( $_arr ) ) {
			// Check if video url included playlist id.
			$pattern = '#list=([A-Za-z0-9^/]*)#i';
			$matches = array();
			preg_match_all( $pattern, $params['video_source_link_youtube'], $matches, PREG_SET_ORDER );

			if ( count( $matches ) ) {
				if ( isset( $params['video_youtube_show_list'] ) && $params['video_youtube_show_list'] == '1' ) {
					$video_src = 'http://www.youtube.com/embed?listType=playlist&list=';
					$_list_id = $matches[0][1];
					$video_src .= $_list_id;
					$video_src .= '&innerframe=true';
				} else {
					$video_src = $_arr[1];
					$video_src .= '&innerframe=true';
				}
			} else {
				$video_src = $_arr[1];
				$video_src .= '&innerframe=true';
			}

			$video_src .= isset($params['video_youtube_autoplay']) ? '&autoplay=' . (int) $params['video_youtube_autoplay'] : '';
			$video_src .= isset($params['video_youtube_autohide']) ? '&autohide=' . (int) $params['video_youtube_autohide'] : '';
			$video_src .= isset($params['video_youtube_controls']) ? '&controls=' . (int) $params['video_youtube_controls'] : '';
			$video_src .= isset($params['video_youtube_loop']) ? '&loop=' . (int) $params['video_youtube_loop'] : '';
			$video_src .= (isset($params['video_youtube_cc']) && (int) $params['video_youtube_cc'] == 1) ? '&cc_load_policy =1' : '';
		}
		
		// Specific playlist id for feature loop youtube video.
		$youtube_id = isset( $params['video_source_link_youtube'] ) ? $this->getYoutubeID( $params['video_source_link_youtube'] ) : '';
		if ( $youtube_id ) {
			$video_src .= '&playlist=' . $youtube_id;
		}

		$embed = '<div ' . $container_class . $container_style . '>';
		$embed .= '<iframe style="display:block;' . $object_style . '" ' . $_w . $_h . '
src="' . $video_src . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		$embed .= '</div>';
        $embed .= '<div class="clear:both"></div>';

		return $embed;
	}

	/**
	 * Get youtube video id from URL.
	 * 
	 * @param string $url
	 * 
	 * @return string
	 */
	function getYoutubeID( $url = '' )
	{
		if ( ! $url )
			return '';
		$pattern = '#^(?:https?://)?';    # Optional URL scheme. Either http or https.
		$pattern .= '(?:www\.)?';         #  Optional www subdomain.
		$pattern .= '(?:';                #  Group host alternatives:
		$pattern .=   'youtu\.be/';       #    Either youtu.be,
		$pattern .=   '|youtube\.com';    #    or youtube.com
		$pattern .=   '(?:';              #    Group path alternatives:
		$pattern .=     '/embed/';        #      Either /embed/,
		$pattern .=     '|/v/';           #      or /v/,
		$pattern .=     '|/watch\?v=';    #      or /watch?v=,
		$pattern .=     '|/watch\?.+&v='; #      or /watch?other_param&v=
		$pattern .=   ')';                #    End path alternatives.
		$pattern .= ')';                  #  End host alternatives.
		$pattern .= '([\w-]{11})';        # 11 characters (Length of Youtube video ids).
		$pattern .= '(?:.+)?$#x';         # Optional other ending URL parameters.
		preg_match( $pattern, $url, $matches );
		return ( isset( $matches[1] ) ) ? $matches[1] : false;
	}
	
	/**
	 * Generate HTML for Vimeo
	 * 
	 * @return string
	 */
	function generate_vimeo( $params ) {
		$random_id = JSNPagebuilderHelpersShortcode::generateRandomString();

		$_w = ' width="' . $params['video_vimeo_dimension_width'] . '" ';
		$_h = $params['video_vimeo_dimension_height'] ? ' height="' . $params['video_vimeo_dimension_height'] . '" ' : '';
		// Alignment
		$container_class = '';
		$object_style = '';
		if ( $params['video_alignment'] === 'right' ) {
			$object_style    .= 'float:right;';
			$container_class .= 'clearafter ';
		} else if ( $params['video_alignment'] === 'center' ) {
			$object_style .= 'margin: 0 auto;';
		} else if ( $params['video_alignment'] === 'left' ) {
			$object_style    .= 'float:left;';
			$container_class .= 'clearafter ';
		}

		// Genarate Container class
		$container_class = $container_class ? 'class="' . $container_class . '" ' : '';

		// Margin.
		$container_style = '';
		$container_style .= (isset($params['video_margin_left']) && $params['video_margin_left'] != '') ? 'margin-left:' . $params['video_margin_left'] . 'px;' : '';
		$container_style .= (isset($params['video_margin_top']) && $params['video_margin_top'] != '') ? 'margin-top:' . $params['video_margin_top'] . 'px;' : '';
		$container_style .= (isset($params['video_margin_right']) && $params['video_margin_right'] != '') ? 'margin-right:' . $params['video_margin_right'] . 'px;' : '';
		$container_style .= (isset($params['video_margin_bottom']) && $params['video_margin_bottom'] != '') ? 'margin-bottom:' . $params['video_margin_bottom'] . 'px;' : '';
		$container_style = $container_style ? ' style=" ' . $container_style . ' " ' : '';

		// Get video ID.
		$params['video_source_link_vimeo'] = urldecode( $params['video_source_link_vimeo'] );
		$video_info                        = JSNPbVideoHelper::getVimeoVideoInfo( $params['video_source_link_vimeo'] );
		$video_info                        = json_decode( $video_info );
		if ( ! $video_info )
			return;
		$video_info = $video_info->html;
		$_arr = array();
		$video_src = '';
		preg_match( '/src\s*\n*=\s*\n*"([^"]*)"/i', $video_info, $_arr );
		if ( count( $_arr ) ) {
			$video_src = $_arr[1];
			$video_src .= '?innerframe=true';
			$video_src .= isset($params['video_vimeo_autoplay']) ? '&autoplay=' . (string) $params['video_vimeo_autoplay'] : '';
			$video_src .= isset($params['video_vimeo_loop']) ? '&loop=' . (string) $params['video_vimeo_loop'] : '';
			$video_src .= isset($params['video_vimeo_title']) ? '&title=' . (string) $params['video_vimeo_title'] : '';
			$video_src .= isset($params['video_vimeo_color']) ? '&color=' . str_replace( '#', '', (string) $params['video_vimeo_color'] ) : '';
		}

		$embed = '<div ' . $container_class . $container_style . '>';
		$embed .= '<iframe webkitallowfullscreen mozallowfullscreen allowfullscreen style="display:block;' . $object_style . '" ' . $_w . $_h . '"
src="' . $video_src . '" frameborder="0"></iframe>';
		$embed .= '</div>';
        $embed .= '<div class="clear:both"></div>';

		return $embed;
	}

	/**
	 * Method to load needed assets
	 * to render local video player.
	 * 
	 * @return type
	 */
	function load_local_video_assets() {
		$document = JFactory::getDocument();
		$document->addScript( JSNPB_PLG_SYSTEM_ASSETS_URL . '3rd-party/mediaelement/mediaelement.min.js', 'text/javascript' );
		$document->addScript( JSNPB_PLG_SYSTEM_ASSETS_URL . '3rd-party/mediaelement/mediaelementplayer.min.js', 'text/javascript' );
		$document->addStyleSheet( JSNPB_PLG_SYSTEM_ASSETS_URL . '3rd-party/mediaelement/mediaelementplayer.min.css', 'text/css' );
	}
}
