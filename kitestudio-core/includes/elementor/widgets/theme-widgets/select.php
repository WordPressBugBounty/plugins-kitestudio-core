<?php
namespace KiteStudioCore\Elementor\Widgets\ThemeElements;

/**
 * Elementor Select Widget
 *
 * @since 1.2.2
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

class Select extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Icon Box Left widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-theme-select';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Icon Box Left widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Header - Select Box', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Icon Box Left widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-select kite-element-icon';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Icon Box Left widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'kite-theme-elements' );
	}

	/**
	 * Register Icon Box Left widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Select', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'item_title',
			array(
				'label'       => esc_html__( 'Title', 'kitestudio-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Link title', 'kitestudio-core' ),
			)
		);

		$repeater->add_control(
			'item_link',
			array(
				'label'         => __( 'Link', 'kitestudio-core' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'kitestudio-core' ),
				'show_external' => true,
				'default'       => array(
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => true,
				),
			)
		);

		$repeater->add_control(
			'item_icon',
			array(
				'label'   => __( 'Icon', 'kitestudio-core' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-star',
					'library' => 'solid',
				),
			)
		);

		$repeater->add_control(
			'is_language_switcher',
			array(
				'label'        => __( 'Is language swicher ?', 'kitestudio-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kitestudio-core' ),
				'label_off'    => __( 'No', 'kitestudio-core' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$repeater->add_control(
			'language',
			array(
				'label'     => __( 'Language', 'kitestudio-core' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_languages_list(),
				'condition' => array(
					'is_language_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'select_items',
			array(
				'label'       => esc_html__( 'Items', 'kitestudio-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'item_title' => esc_html__( 'First Item', 'kitestudio-core' ),
					),
					array(
						'item_title' => esc_html__( 'Second Item', 'kitestudio-core' ),
					),
				),
				'title_field' => '{{{ item_title }}}',
			)
		);

		$this->add_control(
			'action',
			array(
				'label'        => esc_html__( 'Display Items On Hover', 'kitestudio-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Hover', 'kitestudio-core' ),
				'label_off'    => esc_html__( 'Click', 'kitestudio-core' ),
				'return_value' => 'hover',
				'default'      => 'hover',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'select_style_section',
			array(
				'label' => esc_html__( 'Select Style', 'kitestudio-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'select_align',
			array(
				'label'                => esc_html__( 'Alignment', 'kitestudio-core' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => array(
					'left'   => array(
						'title' => __( 'Left', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'kitestudio-core' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'              => 'left',
				'selectors_dictionary' => array(
					'left'   => 'text-align: left;justify-content: flex-start;',
					'center' => 'text-align: center;justify-content: center;',
					'right'  => 'text-align: right;justify-content: flex-end;',
				),
				'selectors'            => array(
					'{{WRAPPER}} div.nice-select'       => '{{VALUE}}',
					'{{WRAPPER}} div.nice-select ul li' => '{{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'select_width',
			array(
				'label'      => __( 'Select Width', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 2000,
						'step' => 5,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .nice-select' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'select_height',
			array(
				'label'      => __( 'Select Height', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 2000,
						'step' => 5,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .nice-select' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'select_typography',
				'label'    => __( 'Select Typography', 'kitestudio-core' ),
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .current, {{WRAPPER}} ul li',
			)
		);

		$this->add_responsive_control(
			'item_padding',
			array(
				'label'      => esc_html__( 'Item Padding', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_padding',
			array(
				'label'      => esc_html__( 'icon Padding', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} span.element-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'select_state_colors' );

		$this->start_controls_tab(
			'select_normal',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'current_color_normal',
			array(
				'label'     => esc_html__( 'Current Item Color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .current'                 => 'color: {{VALUE}};',
					'{{WRAPPER}} .kt-select-element:after' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'select_background_normal',
				'label'    => __( 'Select Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .nice-select',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'select_hover',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'current_color_hover',
			array(
				'label'     => esc_html__( 'Current Item Color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .current:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'select_background_hover',
				'label'    => __( 'Select Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .nice-select',
			)
		);

		$this->add_responsive_control(
			'select_transition',
			array(
				'label'      => __( 'Transition (ms)', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 5000,
						'step' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .nice-select, {{WRAPPER}} .current' => 'transition: all {{SIZE}}ms ease;',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'select_border_options',
			array(
				'label'     => __( 'Select Border Options', 'kitestudio-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'select_border',
				'label'     => esc_html__( 'Select Border', 'kitestudio-core' ),
				'selector'  => '{{WRAPPER}} div.nice-select',
				'separator' => 'none',
			)
		);

		$this->add_responsive_control(
			'select_border_radius',
			array(
				'label'      => esc_html__( 'Select Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} div.nice-select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'select_list_border_options',
			array(
				'label'     => __( 'Dropdown Border Options', 'kitestudio-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'select_list_border',
				'label'     => esc_html__( 'Select List Border', 'kitestudio-core' ),
				'selector'  => '{{WRAPPER}} div.nice-select ul',
				'separator' => 'none',
			)
		);

		$this->add_responsive_control(
			'select_list_border_radius',
			array(
				'label'      => esc_html__( 'Dropdown Border Radius', 'kitestudio-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} div.nice-select ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'dropdown_state_colors' );

		$this->start_controls_tab(
			'dropdown_normal',
			array(
				'label' => __( 'Normal', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'icon_color_normal',
			array(
				'label'     => esc_html__( 'Icon Color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .element-icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_color_normal',
			array(
				'label'     => esc_html__( 'Title Color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ul li a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'item_background_normal',
				'label'    => __( 'Item Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} ul li',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'dropdown_hover',
			array(
				'label' => __( 'Hover', 'kitestudio-core' ),
			)
		);

		$this->add_control(
			'icon_color_hover',
			array(
				'label'     => esc_html__( 'Icon Color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ul li:hover .element-icon' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_color_hover',
			array(
				'label'     => esc_html__( 'Title Color ', 'kitestudio-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ul li:hover a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'item_background_hover',
				'label'    => __( 'Item Background', 'kitestudio-core' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} ul li:hover',
			)
		);

		$this->add_responsive_control(
			'dropdown_transition',
			array(
				'label'      => __( 'Transition (ms)', 'kitestudio-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 5000,
						'step' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ul li, {{WRAPPER}} ul li a, {{WRAPPER}} ul li .element-icon' => 'transition: all {{SIZE}}ms ease;',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Render Icon Box Left widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$action = $settings['action'] == 'hover' ? 'hover' : 'click';

		$current_item = $this->get_current_item( $settings );

		?>
		<div class="nice-select kt-select-element" data-action="<?php echo esc_attr( $action ); ?>">
			<span class="current">
				<span class="selected">
					<?php
					if ( ! empty( $settings['select_items'][ $current_item ]['item_icon']['library'] ) && $settings['select_items'][ $current_item ]['item_icon']['library'] == 'svg' ) {
						echo'<img src="' . esc_url( $settings['select_items'][ $current_item ]['item_icon']['value']['url'] ) . '">';
					} elseif ( ! empty( $settings['select_items'][ $current_item ]['item_icon']['value'] ) ) {
						echo '<span class="element-icon ' . esc_attr( $settings['select_items'][ $current_item ]['item_icon']['value'] ) . '"></span>';
					}
					echo esc_html( $settings['select_items'][ $current_item ]['item_title'] );
					?>
				</span>
			</span>
			<ul class="list">
				<?php
				foreach ( $settings['select_items'] as $key => $item ) {
					$is_external = $item['item_link']['is_external'] ? '_blank' : '_self';
					?>
					<li class="option">
                        <?php
                        if ( ! empty( $item['item_icon']['value'] ) ) {
	                        echo '<span class="element-icon ' . esc_attr( $item['item_icon']['value'] ) . '"></span>';
                        }
                        ?>
                        <a href="<?php echo esc_url( $item['item_link']['url'] ); ?>" target="<?php echo esc_attr( $is_external ); ?>"><?php echo esc_html( $item['item_title'] ); ?></a>
                    </li>
				<?php } ?>
			</ul>
		</div>
		<?php
	}

	/**
	 * Whether the reload preview is required or not.
	 *
	 * Used to determine whether the reload preview is required.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return bool Whether the reload preview is required.
	 */
	public function is_reload_preview_required() {
		return false;
	}

	/**
	 * Render shortcode widget as plain content.
	 *
	 * Override the default behavior by printing the shortcode instead of rendering it.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function render_plain_content() {

	}

	protected function content_template() {
	}

	/**
	 * Get current item for url visiting
	 *
	 * @param array $settings
	 * @return int
	 */
	public function get_current_item( $settings ) {
		global $wp;
		$current_link = rtrim( home_url( $wp->request ), '/' );

		// if permalink structure is pretty
		foreach ( $settings['select_items'] as $key => $item ) {
			$item_link = ! empty( $item['is_language_switcher'] ) ? $this->get_item_language_link( $item ) : rtrim( $item['item_link']['url'], '/' );
			if ( ! empty( $item_link ) && ( $item_link == $current_link || strpos( $current_link, $item_link ) != false ) ) {
				return $key;
			}
		}

		// if permalink structure is not pretty and hast query variables inside
		foreach ( $settings['select_items'] as $key => $item ) {
			$item_link = ! empty( $item['is_language_switcher'] ) ? $this->get_item_language_link( $item ) : rtrim( $item['item_link']['url'], '/' );
			if ( ! empty( $item_link ) ) {
				$query = parse_url( $item_link, PHP_URL_QUERY );
				if ( $query ) {
					parse_str( $query, $params );
					if ( ! empty( $params ) ) {
						$param_key_found = true;
						foreach ( $params as $param_key => $param_value ) {
							if ( empty( $_GET[ $param_key ] ) || $_GET[ $param_key ] != $param_value ) {
								$param_key_found = false;
								break;
							}
						}

						if ( $param_key_found ) {
							return $key;
						}
					}
				}
			}
		}

		return 0;
	}

	/**
	 * List available languages
	 *
	 * @return array
	 */
	public function get_languages_list() {
		if ( function_exists( 'pll_languages_list' ) ) {
			$languages_list = pll_languages_list();
			return array_combine( $languages_list, $languages_list );
		}

		if ( function_exists( 'wpml_get_active_languages_filter' ) ) {
			$languages_list = wpml_get_active_languages_filter( '' );
			return array_combine( array_keys( $languages_list ), array_keys( $languages_list ) );
		}
		return array();
	}

	/**
	 * Get relative language link for an item
	 *
	 * @param array $item
	 * @return string
	 */
	public function get_item_language_link( $item ) {
		global $post;
		if ( is_object( $post ) && ! is_archive() ) {
			if ( function_exists( 'pll_get_post' ) ) {
				$translated_post = pll_get_post( $post->ID, $item['language'] );
				return ! empty( $translated_post ) ? rtrim( get_permalink( $translated_post ), '/' ) : rtrim( $item['item_link']['url'], '/' );
			}

			if ( function_exists( 'wpml_object_id_filter' ) ) {
				$translated_post = wpml_object_id_filter( $post->ID, $post->post_type, false, $item['language'] );
				return ! empty( $translated_post ) ? rtrim( wpml_permalink_filter( get_permalink( $translated_post ), $item['language'] ), '/' ) : rtrim( $item['item_link']['url'], '/' );
			}
		}

		return rtrim( $item['item_link']['url'], '/' );
	}
}
