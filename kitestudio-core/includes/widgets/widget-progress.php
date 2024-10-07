<?php
if ( ! class_exists( 'Kite_Progress_Widget' ) ) {
	// Widget class
	class Kite_Progress_Widget extends WP_Widget {

		public function __construct() {
			parent::__construct(
				'Kite_Progress', // Base ID
				'Kite - Progress Widget', // Name
				array( 'description' => esc_html__( 'Displays 5 progress bars with a title', 'kitestudio-core' ) ) // Args
			);
			add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ), 99 );
		}

		public function load_scripts() {
			wp_enqueue_script( 'kite-progressbar' );
		}

		function widget( $args, $instance ) {
			extract( $args );

			// Our variables from the widget settings
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'] );

			// Before widget (defined by theme functions file)
			echo wp_kses_post( $before_widget );

			// Display the widget title if one was input
			if ( $title ) {
				echo wp_kses_post( $before_title . $title . $after_title );
			}

			?>
			<div class="progress-list">
			<?php
			for ( $i = 1; $i <= 5; $i++ ) {
				$id     = "title$i";
				$prog_id = "progress$i";

				if ( ! strlen( $instance[ $id ] ) ) {
					continue;
				}

				?>

				<div class="progress_bar">
					<div class="progressbar_holder">
						<span class="progress_title"><?php echo esc_html( $instance[ $id ] ); ?></span>
						<span class="progress_percent_value complete" style="left:<?php echo esc_attr( $instance[ $prog_id ] ); ?>%;"><?php echo esc_html( $instance[ $prog_id ] ); ?>%</span>
						<div class="progressbar_percent" data-percentage="<?php echo esc_attr( $instance[ $prog_id ] ); ?>"></div>
					</div>
				</div>

				<?php
			}
			?>
			</div>
			<?php
			// After widget (defined by theme functions file)
			echo wp_kses_post( $after_widget );
		}


		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			// Strip tags to remove HTML (important for text inputs)
			$instance['title'] = strip_tags( $new_instance['title'] );

			for ( $i = 1; $i <= 5; $i++ ) {
				$id    = "title$i";
				$str_id = "progress$i";

				$instance[ $id ]    = trim( strip_tags( $new_instance[ $id ] ) );
				$instance[ $str_id ] = $new_instance[ $str_id ];
			}

			return $instance;
		}

		function form( $instance ) {

			// Set up some default widget settings
			$defaults = array(
				'title' => 'Skills',
			);

			for ( $i = 1; $i <= 5; $i++ ) {
				$defaults[ "title$i" ]    = '';
				$defaults[ "progress$i" ] = '';
			}

			$instance = wp_parse_args( (array) $instance, $defaults );
			?>

			<!-- Widget Title: Text Input -->
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'kitestudio-core' ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"  value=" <?php echo esc_attr( $instance['title'] ); ?>" />
			</p>

			<?php for ( $i = 1; $i <= 5; $i++ ) { ?>
			<!-- Title: Text Input -->
			<p>
				<?php $id = "title$i"; ?>
				<label for="<?php echo esc_attr( $this->get_field_id( $id ) ); ?>"><?php printf( esc_html__( 'Progress %d Title:', 'kitestudio-core' ), $i ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( $id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $id ) ); ?>" value="<?php echo esc_attr( $instance[ $id ] ); ?>" />
			</p>

			<!-- Progress: Text Input -->
			<p>
				<?php $id = "progress$i"; ?>
				<label for="<?php echo esc_attr( $this->get_field_id( $id ) ); ?>"><?php printf( esc_html__( 'Progress %d:', 'kitestudio-core' ), $i ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( $id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $id ) ); ?>" class="widefat">
					<?php for ( $j = 0; $j <= 100; $j += 10 ) { ?>
						<option <?php selected( esc_attr( $instance[ $id ] ), $j ); ?> value="<?php echo esc_attr( $j ); ?>"><?php echo esc_html( $j ); ?>%</option>
					<?php } ?>
				</select>
			</p>

			<?php }//end for(...) ?>

			<?php
		}
	}
}

