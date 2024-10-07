<?php
if ( ! class_exists( 'Kite_Recent_Post_Widget' ) ) {
	// Widget class
	class Kite_Recent_Post_Widget extends WP_Widget_Recent_Posts {

		function widget( $args, $instance ) {

			extract( $args );

			$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

			if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) {
				$number = 5;
			}
			$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

			$r = new WP_Query(
				apply_filters(
					'widget_posts_args',
					array(
						'posts_per_page'      => $number,
						'no_found_rows'       => true,
						'post_status'         => 'publish',
						'ignore_sticky_posts' => true,
					)
				)
			);

			if ( $r->have_posts() ) :

				echo wp_kses_post( $before_widget );
				if ( $title ) {
					echo wp_kses_post( $before_title . $title . $after_title );
				} ?>
					<ul>
					<?php
					while ( $r->have_posts() ) :
						$r->the_post();
						?>
							
						<?php $title = ( ! empty( $post_title ) ) ? $post_title : esc_html__( 'no title', 'kitestudio-core' ); ?>
						<li>
							<a 
							<?php
							if ( ! $show_date ) {
								?>
								class='no-info'  <?php } ?> href="<?php the_permalink(); ?>" title="<?php echo the_title(); ?>">
							<?php if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail() ) { ?>
								<div class="post-img"><?php the_post_thumbnail( 'Kite_recent_post_thumb' ); ?></div> <?php } ?>
								<span class="title"><?php the_title(); ?></span>
							</a>
							<?php if ( $show_date ) { ?>
							<div class="postinfo 
								<?php
								if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail() ) {
									?>
								hasimg <?php } ?>">
								
								<div class="post-date">
									<div class="monthyear">
										<span class="month"><?php echo ( get_the_time( 'M j, Y' ) ); ?></span>
									</div>
								</div>
								<?php if ( comments_open() ) { ?>
									<span class="post-comments kt-icon icon-bubble" data-name="bubble">
									<?php
									if ( comments_open() ) {
										comments_popup_link( esc_html__( 'No Comment', 'kitestudio-core' ), '1', '%', 'comments-link', '' );}
									?>
									</span>
								<?php } ?>
							
							</div>
						<?php } ?>
						</li>
					
					<?php endwhile; ?>
					</ul>
				<?php
				echo wp_kses_post( $after_widget );

				wp_reset_postdata();
			endif;
		}
	}
}
