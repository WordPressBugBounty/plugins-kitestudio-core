<?php
/*-----------------------------------------------------------------------------------*/
/*  Social Link
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'kite_sc_socialLink' ) ) {
	function kite_sc_socialLink( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'sociallink_url'   => '',
					'sociallink_type'  => 'facebook',
					'sociallink_style' => 'dark',
					'sociallink_text'  => '',
				),
				$atts
			)
		);

		$id = kite_sc_id( 'socialLink' );

		switch ( $sociallink_type ) {
			case 'facebook':
				$sociallink_text = 'facebook';
				break;
			case 'twitter':
				$sociallink_text = 'Twitter';
				break;
			case 'vimeo':
				$sociallink_text = 'Vimeo';
				break;
			case 'youtube-play':
				$sociallink_text = 'YouTube';
				break;
			case 'google-plus':
				$sociallink_text = 'Google+';
				break;
			case 'dribbble':
				$sociallink_text = 'Dribbble';
				break;
			case 'tumblr':
				$sociallink_text = 'Tumblr';
				break;
			case 'linkedin':
				$sociallink_text = 'LinkedIn';
				break;
			case 'flickr':
				$sociallink_text = 'Flickr';
				break;
			case 'forrst':
				$sociallink_text = 'Forrst';
				break;
			case 'github':
				$sociallink_text = 'GitHub';
				break;
			case 'lastfm':
				$sociallink_text = 'Last.FM';
				break;
			case 'paypal':
				$sociallink_text = 'PaypPal';
				break;
			case 'feed':
				$sociallink_text = 'RSS';
				break;
			case 'WordPress':
				$sociallink_text = 'WordPress';
				break;
			case 'skype':
				$sociallink_text = 'Skype';
				break;
			case 'yahoo':
				$sociallink_text = 'Yahoo';
				break;
			case 'steam':
				$sociallink_text = 'Steam';
				break;
			case 'reddit-alien':
				$sociallink_text = 'Reddit';
				break;
			case 'stumbleupon':
				$sociallink_text = 'StumbleUpon';
				break;
			case 'pinterest':
				$sociallink_text = 'Pinterest';
				break;
			case 'deviantart':
				$sociallink_text = 'DeviantArt';
				break;
			case 'xing':
				$sociallink_text = 'Xing';
				break;
			case 'blogger':
				$sociallink_text = 'Blogger';
				break;
			case 'soundcloud':
				$sociallink_text = 'SoundCloud';
				break;
			case 'delicious':
				$sociallink_text = 'Delicious';
				break;
			case 'foursquare':
				$sociallink_text = 'Foursquare';
				break;
			case 'instagram':
				$sociallink_text = 'Instagram';
				break;
			case 'behance':
				$sociallink_text = 'Behance';
				break;
			case 'custom':
				$sociallink_text = esc_attr( $sociallink_text );
				break;
			default:
				$sociallink_text = 'facebook';
		}

		if ( esc_attr( $sociallink_type ) == 'custom' ) {
			$sociallink_type = $id;
		}//if social network name was custom

		ob_start();

		?>
	
		<div class="sociallink-shortcode textstyle <?php echo esc_attr( $sociallink_type ); ?> <?php echo esc_attr( $sociallink_style ); ?>">
			<a id="<?php echo esc_attr( $id ); ?>" href="<?php echo esc_url( $sociallink_url ); ?>" target="_blank">
				<span><?php echo esc_html( $sociallink_text ); ?></span>
			</a>
		</div>
	
		<?php
		return ob_get_clean();
	}
}
