<?php
if ( ! class_exists( 'Kite_Video_Widget' ) ) {
	// Widget class
	class Kite_Video_Widget extends WP_Widget {

		public function __construct() {
			parent::__construct(
				'Kite_Video', // Base ID
				'Kite - Video', // Name
				array( 'description' => esc_html__( 'A widget that displays your YouTube or Vimeo Video.', 'kitestudio-core' ) ) // Args
			);

			// This is where we add the style and script
			add_action( 'load-widgets.php', array( &$this, 'kite_admin_scripts' ) );
		}

		public function kite_admin_scripts() {

			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_style( 'thickbox' );
		}

		function widget( $args, $instance ) {
			extract( $args );

			// Our variables from the widget settings
			$title                   = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'] );
			$video_display_type      = isset( $instance['video_display_type'] ) ? $instance['video_display_type'] : '';
			$video_autoplay          = isset( $instance['video_autoplay'] ) ? $instance['video_autoplay'] : '';
			$video_poster_image      = isset( $instance['video_poster_image'] ) ? $instance['video_poster_image'] : '';
			$video_background_image  = isset( $instance['video_background_image'] ) ? $instance['video_background_image'] : '';
			$video_webm              = isset( $instance['video_webm'] ) ? $instance['video_webm'] : '';
			$video_mp4               = isset( $instance['video_mp4'] ) ? $instance['video_mp4'] : '';
			$video_ogv               = isset( $instance['video_ogv'] ) ? $instance['video_ogv'] : '';
			$video_play_button_color = isset( $instance['video_play_button_color'] ) ? $instance['video_play_button_color'] : '';
			$el_aspect               = isset( $instance['el_aspect'] ) ? $instance['el_aspect'] : '';
			$video_youtube_id        = isset( $instance['video_youtube_id'] ) ? $instance['video_youtube_id'] : '';
			$video_vimeo_id          = isset( $instance['video_vimeo_id'] ) ? $instance['video_vimeo_id'] : '';

			// Before widget (defined by theme functions file)
			echo wp_kses_post( $before_widget );

			// Display the widget title if one was input
			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}

			// video
			echo kite_sc_embed_video([
				'video_display_type' => $video_display_type,
				'video_autoplay' => $video_autoplay,
				'video_poster_image' => $video_poster_image,
				'video_background_image' => $video_background_image,
				'video_webm' => $video_webm,
				'video_mp4' => $video_mp4,
				'video_ogv' => $video_ogv,
				'video_play_button_color' => $video_play_button_color,
				'el_aspect' => $el_aspect,
				'video_youtube_id' => $video_youtube_id,
				'video_vimeo_id' => $video_vimeo_id
			]);

			// After widget (defined by theme functions file)
			echo wp_kses_post( $after_widget );
		}


		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			// Strip tags to remove HTML (important for text inputs)
			$instance['title']                   = strip_tags( $new_instance['title'] );
			$instance['video_display_type']      = stripslashes( $new_instance['video_display_type'] );
			$instance['video_autoplay']          = stripslashes( $new_instance['video_autoplay'] );
			$instance['video_poster_image']      = strip_tags( $new_instance['video_poster_image'] );
			$instance['video_background_image']  = strip_tags( $new_instance['video_background_image'] );
			$instance['video_webm']              = strip_tags( $new_instance['video_webm'] );
			$instance['video_mp4']               = strip_tags( $new_instance['video_mp4'] );
			$instance['video_ogv']               = strip_tags( $new_instance['video_ogv'] );
			$instance['video_play_button_color'] = stripslashes( $new_instance['video_play_button_color'] );
			$instance['el_aspect']               = stripslashes( $new_instance['el_aspect'] );
			$instance['video_youtube_id']        = strip_tags( $new_instance['video_youtube_id'] );
			$instance['video_vimeo_id']          = strip_tags( $new_instance['video_vimeo_id'] );

			return $instance;
		}

		function form( $instance ) {

			// Set up some default widget settings
			$defaults = array(
				'title'                   => 'Video',
				'video_display_type'      => 'local_video',
				'video_autoplay'          => 'enable',
				'video_poster_image'      => '',
				'video_background_image'  => '',
				'video_webm'              => '',
				'video_mp4'               => '',
				'video_ogv'               => '',
				'video_vimeo_id'          => '',
				'video_youtube_id'        => '',
				'video_play_button_color' => 'light',
				'animation'               => 'none',
				'delay'                   => '0',
				'el_aspect'               => '169',
			);

			$instance = wp_parse_args( (array) $instance, $defaults ); ?>

			<div class="kite-video-widget">

				<!-- Widget Title: Text Input -->
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'kitestudio-core' ); ?></label>
					<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
				</p>


				<p class="video_display_type_container">
					<label for="<?php echo esc_attr( $this->get_field_id( 'video_display_type' ) ); ?>"><?php esc_html_e( 'Video display type', 'kitestudio-core' ); ?></label>
					<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'video_display_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video_display_type' ) ); ?>">
						<option class="local_video" value="local_video" <?php selected( 'local_video', $instance['video_display_type'], true ); ?>><?php esc_html_e( 'local Video', 'kitestudio-core' ); ?></option>
						<option class="embeded_video_youtube" value="embeded_video_youtube" <?php selected( 'embeded_video_youtube', $instance['video_display_type'], true ); ?>><?php esc_html_e( 'Embedded Video (Youtube)', 'kitestudio-core' ); ?></option>
						<option class="embeded_video_vimeo" value="embeded_video_vimeo" <?php selected( 'embeded_video_vimeo', $instance['video_display_type'], true ); ?>><?php esc_html_e( 'Embedded Video (Vimeo)', 'kitestudio-core' ); ?></option>
						<option class="local_video_popup" value="local_video_popup" <?php selected( 'local_video_popup', $instance['video_display_type'], true ); ?>><?php esc_html_e( 'Local Video Popup', 'kitestudio-core' ); ?></option>
						<option class="embeded_video_youtube_popup" value="embeded_video_youtube_popup" <?php selected( 'embeded_video_youtube_popup', $instance['video_display_type'], true ); ?>><?php esc_html_e( 'Embedded Video  ( Youtube Popup )', 'kitestudio-core' ); ?></option>
						<option class="embeded_video_vimeo_popup" value="embeded_video_vimeo_popup" <?php selected( 'embeded_video_vimeo_popup', $instance['video_display_type'], true ); ?>><?php esc_html_e( 'Embedded Video ( Vimeo Popup )', 'kitestudio-core' ); ?></option>
					</select>
				</p>

				<p class="video_autoplay_container">
					<label for="<?php echo esc_attr( $this->get_field_id( 'video_autoplay' ) ); ?>"><?php esc_html_e( 'Auto-play', 'kitestudio-core' ); ?></label>
					<select name="<?php echo esc_attr( $this->get_field_name( 'video_autoplay' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'video_autoplay' ) ); ?>" class="widefat">
						<option class="enable" value="enable" <?php selected( 'enable', $instance['video_autoplay'], true ); ?>><?php esc_html_e( 'Enable', 'kitestudio-core' ); ?></option>
						<option class="disable" value="disable" <?php selected( 'disable', $instance['video_autoplay'], true ); ?>><?php esc_html_e( 'Disable', 'kitestudio-core' ); ?></option>
					</select>
				</p>

				<div class="video_poster_image_container">
					<label for="<?php echo esc_attr( $this->get_field_id( 'video_poster_image' ) ); ?>"><?php esc_html_e( 'Video Poster Image', 'kitestudio-core' ); ?></label>
					<div class="field upload-field clear-after" data-title="<?php echo esc_attr__( 'Upload Image', 'kitestudio-core' ); ?>" data-referer="kt-attr-image">
						<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'video_poster_image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video_poster_image' ) ); ?>" value="<?php echo esc_attr( $instance['video_poster_image'] ); ?>" />
						<a href="<?php echo esc_url( '#' ); ?>" class="upload-button"><?php esc_html_e( 'Browse', 'kitestudio-core' ); ?></a>
						<div class="upload-thumb <?php echo esc_attr( $instance['video_poster_image'] != '' ? 'show' : '' ); ?>">
							<div class="close"><span class="close-icon"></span></div>
							<img class="" src="<?php echo esc_attr( $instance['video_poster_image'] ); ?>" alt="<?php echo esc_attr( $instance['title'] ); ?>">
						</div>
					</div>
				</div>

				<div class="video_background_image_container">
					<label for="<?php echo esc_attr( $this->get_field_id( 'video_background_image' ) ); ?>"><?php esc_html_e( 'Video Cover Image', 'kitestudio-core' ); ?></label>
					<div class="field upload-field clear-after" data-title="<?php echo esc_attr__( 'Upload Image', 'kitestudio-core' ); ?>" data-referer="kt-attr-image">
						<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'video_background_image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video_background_image' ) ); ?>" value="<?php echo esc_attr( $instance['video_background_image'] ); ?>" />
						<a href="<?php echo esc_url( '#' ); ?>" class="upload-button"><?php esc_html_e( 'Browse', 'kitestudio-core' ); ?></a>
						<div class="upload-thumb <?php echo esc_attr( $instance['video_background_image'] != '' ? 'show' : '' ); ?>">
							<div class="close"><span class="close-icon"></span></div>
							<img class="" src="<?php echo esc_attr( $instance['video_background_image'] ); ?>" alt="<?php echo esc_attr( $instance['title'] ); ?>">
						</div>
					</div>
				</div>

				<p class="video_webm_container">
					<label for="<?php echo esc_attr( $this->get_field_id( 'video_webm' ) ); ?>"><?php esc_html_e( 'Self Hosted Video (.webm video type)', 'kitestudio-core' ); ?></label>
					<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'video_webm' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video_webm' ) ); ?>" value="<?php echo esc_attr( $instance['video_webm'] ); ?>" />
				</p>

				<p class="video_mp4_container">
					<label for="<?php echo esc_attr( $this->get_field_id( 'video_mp4' ) ); ?>"><?php esc_html_e( 'Self Hosted Video (.mp4 video type)', 'kitestudio-core' ); ?></label>
					<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'video_mp4' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video_mp4' ) ); ?>" value="<?php echo esc_attr( $instance['video_mp4'] ); ?>" />
				</p>

				<p class="video_ogv_container">
					<label for="<?php echo esc_attr( $this->get_field_id( 'video_ogv' ) ); ?>"><?php esc_html_e( 'Self Hosted Video (.ogv video type)', 'kitestudio-core' ); ?></label>
					<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'video_ogv' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video_ogv' ) ); ?>" value="<?php echo esc_attr( $instance['video_ogv'] ); ?>" />
				</p>

				<p class="video_play_button_color_container">
					<label for="<?php echo esc_attr( $this->get_field_id( 'video_play_button_color' ) ); ?>"><?php esc_html_e( 'Auto-play', 'kitestudio-core' ); ?></label>
					<select name="<?php echo esc_attr( $this->get_field_name( 'video_play_button_color' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'video_play_button_color' ) ); ?>" class="widefat">
						<option class="light" value="light" <?php selected( 'light', $instance['video_play_button_color'], true ); ?>><?php esc_html_e( 'Light', 'kitestudio-core' ); ?></option>
						<option class="dark" value="dark" <?php selected( 'dark', $instance['video_play_button_color'], true ); ?>><?php esc_html_e( 'Dark', 'kitestudio-core' ); ?></option>
					</select>
				</p>

				<p class="el_aspect_container">
					<label for="<?php echo esc_attr( $this->get_field_id( 'el_aspect' ) ); ?>"><?php esc_html_e( 'Video Aspect Ratio', 'kitestudio-core' ); ?></label>
					<select name="<?php echo esc_attr( $this->get_field_name( 'el_aspect' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'el_aspect' ) ); ?>" class="widefat">
						<option value="169" <?php selected( $instance['el_aspect'], '169', true ); ?>><?php esc_html_e( '16:9', 'kitestudio-core' ); ?></option>
						<option value="43" <?php selected( $instance['el_aspect'], '43', true ); ?>><?php esc_html_e( '4:3', 'kitestudio-core' ); ?></option>
						<option value="235" <?php selected( $instance['el_aspect'], '235', true ); ?>><?php esc_html_e( '2.35:1', 'kitestudio-core' ); ?></option>
					</select>
				</p>

				<p class="video_youtube_id_container">
					<label for="<?php echo esc_attr( $this->get_field_id( 'video_youtube_id' ) ); ?>"><?php esc_html_e( 'YouTube Video URL', 'kitestudio-core' ); ?></label>
					<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'video_youtube_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video_youtube_id' ) ); ?>" value="<?php echo esc_attr( $instance['video_youtube_id'] ); ?>" />
				</p>

				<p class="video_vimeo_id_container">
					<label for="<?php echo esc_attr( $this->get_field_id( 'video_vimeo_id' ) ); ?>"><?php esc_html_e( 'Vimeo Video URL', 'kitestudio-core' ); ?></label>
					<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'video_vimeo_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video_vimeo_id' ) ); ?>" value="<?php echo esc_attr( $instance['video_vimeo_id'] ); ?>" />
				</p>
			</div>

			<?php
		}
	}
}
