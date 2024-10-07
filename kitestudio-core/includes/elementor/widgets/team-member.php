<?php
/**
 * Elementor Team Member Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Kite_Team_Member_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Team Member widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'kite-team-member';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Team Member widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Team Member', 'kitestudio-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Team Member widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-person kite-element-icon';
	}

	/**
	 * Get widget keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords
	 */
	public function get_keywords() {
		return array( 'team', 'member', 'person' );
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Team Member widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'by-kite' );
	}

	/**
	 * load dependent styles
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return array(
			'kite-team-member',
		);
	}

	/**
	 * Register Team Member widget controls.
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
				'label' => esc_html__( 'Content', 'kitestudio-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'name',
			array(
				'label'       => esc_html__( 'Name', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Member Name', 'kitestudio-core' ),
			)
		);
		$this->add_control(
			'job_title',
			array(
				'label'       => esc_html__( 'Job', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Member Job', 'kitestudio-core' ),
			)
		);
		$this->add_control(
			'style',
			array(
				'label'   => esc_html__( 'Style', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'dark'  => esc_html__( 'Dark', 'kitestudio-core' ),
					'light' => esc_html__( 'Light', 'kitestudio-core' ),
				),
				'default' => 'dark',
			)
		);
		$this->add_control(
			'team_color',
			array(
				'label'     => esc_html__( 'Team Member Color', 'kitestudio-core' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'selectors' => array(
					'{{WRAPPER}} .team-member:hover .member-plus' => 'background-color:{{VALUE}}',
					'{{WRAPPER}} .team-member .member-line' => 'background-color:{{VALUE}}',
					'{{WRAPPER}} .team-member .icons li:hover a' => 'color:{{VALUE}}',
				),
			)
		);
		$this->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Optional URL of member\'s image', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);
		$this->add_control(
			'signature',
			array(
				'label'   => esc_html__( 'Optional URL of the person\'s signature', 'kitestudio-core' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => '',
				),
			)
		);
		$this->add_control(
			'description',
			array(
				'label' => esc_html__( 'Content', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
				'rows'  => 5,
			)
		);
		$this->add_control(
			'url',
			array(
				'label'         => esc_html__( 'Link', 'kitestudio-core' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'kitestudio-core' ),
				'show_external' => true,
				'default'       => array(
					'url' => '#',
				),
			)
		);
		$this->add_control(
			'elementor_url_title',
			array(
				'label' => esc_html__( 'Link Title', 'kitestudio-core' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'team_new_icon1',
			array(
				'label'       => esc_html__( 'Select 1st icon', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'description' => esc_html__( 'Choose an icon for team member icon 1', 'kitestudio-core' ),
			)
		);
		$this->add_control(
			'team_icon1_url',
			array(
				'label'         => esc_html__( '1st Icon Link', 'kitestudio-core' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'kitestudio-core' ),
				'show_external' => true,
				'default'       => array(
					'url' => '#',
				),
			)
		);
		$this->add_control(
			'team_new_icon2',
			array(
				'label'       => esc_html__( 'Select 2nd icon', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'description' => esc_html__( 'Choose an icon for team member icon 1', 'kitestudio-core' ),
			)
		);
		$this->add_control(
			'team_icon2_url',
			array(
				'label'         => esc_html__( '2nd Icon Link', 'kitestudio-core' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'kitestudio-core' ),
				'show_external' => true,
				'default'       => array(
					'url' => '#',
				),
			)
		);
		$this->add_control(
			'team_new_icon3',
			array(
				'label'       => esc_html__( 'Select 3rd icon', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'description' => esc_html__( 'Choose an icon for team member icon 1', 'kitestudio-core' ),
			)
		);
		$this->add_control(
			'team_icon3_url',
			array(
				'label'         => esc_html__( '3rd Icon Link', 'kitestudio-core' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'kitestudio-core' ),
				'show_external' => true,
				'default'       => array(
					'url' => '#',
				),
			)
		);
		$this->add_control(
			'team_new_icon4',
			array(
				'label'       => esc_html__( 'Select 4th icon', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'description' => esc_html__( 'Choose an icon for team member icon 1', 'kitestudio-core' ),
			)
		);
		$this->add_control(
			'team_icon4_url',
			array(
				'label'         => esc_html__( '4th Icon Link', 'kitestudio-core' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'kitestudio-core' ),
				'show_external' => true,
				'default'       => array(
					'url' => '#',
				),
			)
		);
		$this->add_control(
			'team_new_icon5',
			array(
				'label'       => esc_html__( 'Select 5th icon', 'kitestudio-core' ),
				'type'        => \Elementor\Controls_Manager::ICONS,
				'description' => esc_html__( 'Choose an icon for team member icon 1', 'kitestudio-core' ),
			)
		);
		$this->add_control(
			'team_icon5_url',
			array(
				'label'         => esc_html__( '5th Icon Link', 'kitestudio-core' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'kitestudio-core' ),
				'show_external' => true,
				'default'       => array(
					'url' => '#',
				),
			)
		);
		$this->end_controls_section();

	}

	/**
	 * Render Team Member widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( $settings['team_icon1_url']['is_external'] ) {
			$target1 = '_blank';
		} else {
			$target1 = '_self';
		}

		if ( $settings['team_icon2_url']['is_external'] ) {
			$target2 = '_blank';
		} else {
			$target2 = '_self';
		}

		if ( $settings['team_icon3_url']['is_external'] ) {
			$target3 = '_blank';
		} else {
			$target3 = '_self';
		}

		if ( $settings['team_icon4_url']['is_external'] ) {
			$target4 = '_blank';
		} else {
			$target4 = '_self';
		}

		if ( $settings['team_icon5_url']['is_external'] ) {
			$target5 = '_blank';
		} else {
			$target5 = '_self';
		}

		for ( $i = 1; $i < 6; $i++ ) {

			// Check if its already migrated
			$migrated = isset( $settings['__fa4_migrated'][ 'team_new_icon' . $i ] );
			// Check if its a new widget without previously selected icon using the old Icon control
			$is_new = empty( $settings[ 'team_icon' . $i ] );
			if ( $is_new || $migrated ) {
				${ 'team_icon' . $i } = $settings[ 'team_new_icon' . $i ]['library'] == 'svg' ? '' : $settings[ 'team_new_icon' . $i ]['value'];
			} elseif ( isset( $settings[ 'team_icon' . $i ]['value'] ) ) {
				${ 'team_icon' . $i } = $settings[ 'team_icon' . $i ]['library'] == 'svg' ? '' : $settings[ 'team_icon' . $i ]['value'];
			} else {
				${ 'team_icon' . $i } = $settings[ 'team_icon' . $i ];
			}
		}

		$atts = [
			'url' =>  $settings['url']['url']  ,
			'new_tab' =>  $settings['url']['is_external']  ,
			'elementor_url_title' =>  $settings['elementor_url_title']  ,
			'description' =>  $settings['description']  ,
			'name' =>  $settings['name']  ,
			'job_title' =>  $settings['job_title']  ,
			'style' =>  $settings['style']  ,
			'image' =>  $settings['image']['url']  ,
			'signature' =>  $settings['signature']['url']  ,
			'team_color' =>  $settings['team_color']  ,
			'team_color_preset' => 'custom' ,
			'team_icon1' =>  $team_icon1   ,
			'team_icon_url1' =>  $settings['team_icon1_url']['url']  ,
			'team_icon_target1' =>  $target1   ,
			'team_icon2' =>  $team_icon2   ,
			'team_icon_url2' =>  $settings['team_icon2_url']['url']  ,
			'team_icon_target2' =>  $target2   ,
			'team_icon3' =>  $team_icon3   ,
			'team_icon_url3' =>  $settings['team_icon3_url']['url']  ,
			'team_icon_target3' =>  $target3   ,
			'team_icon4' =>  $team_icon4   ,
			'team_icon_url4' =>  $settings['team_icon4_url']['url']  ,
			'team_icon_target4' =>  $target4   ,
			'team_icon5' =>  $team_icon5   ,
			'team_icon_url5' =>  $settings['team_icon5_url']['url']  ,
			'team_icon_target5' =>  $target5   ,
		];

		echo kite_sc_team_member( $atts );
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
		// In plain mode, render without shortcode
		$settings = $this->get_settings_for_display();
		if ( $settings['team_icon1_url']['is_external'] ) {
			$target1 = '_blank';
		} else {
			$target1 = '_self';
		}

		if ( $settings['team_icon2_url']['is_external'] ) {
			$target2 = '_blank';
		} else {
			$target2 = '_self';
		}

		if ( $settings['team_icon3_url']['is_external'] ) {
			$target3 = '_blank';
		} else {
			$target3 = '_self';
		}

		if ( $settings['team_icon4_url']['is_external'] ) {
			$target4 = '_blank';
		} else {
			$target4 = '_self';
		}

		if ( $settings['team_icon5_url']['is_external'] ) {
			$target5 = '_blank';
		} else {
			$target5 = '_self';
		}

		for ( $i = 1; $i < 6; $i++ ) {

			// Check if its already migrated
			$migrated = isset( $settings['__fa4_migrated'][ 'team_new_icon' . $i ] );
			// Check if its a new widget without previously selected icon using the old Icon control
			$is_new = empty( $settings[ 'team_icon' . $i ] );
			if ( $is_new || $migrated ) {
				${ 'team_icon' . $i } = $settings[ 'team_new_icon' . $i ]['library'] == 'svg' ? '' : $settings[ 'team_new_icon' . $i ]['value'];
			} elseif ( isset( $settings[ 'team_icon' . $i ]['value'] ) ) {
				${ 'team_icon' . $i } = $settings[ 'team_icon' . $i ]['library'] == 'svg' ? '' : $settings[ 'team_icon' . $i ]['value'];
			} else {
				${ 'team_icon' . $i } = $settings[ 'team_icon' . $i ];
			}
		}

		echo '[team_member url="' . esc_attr( $settings['url']['url'] ) . '" new_tab="' . esc_attr( $settings['url']['is_external'] ) . '" elementor_url_title="' . esc_attr( $settings['elementor_url_title'] ) . '" description="' . esc_attr( $settings['description'] ) . '" name="' . esc_attr( $settings['name'] ) . '" job_title="' . esc_attr( $settings['job_title'] ) . '" style="' . esc_attr( $settings['style'] ) . '" image="' . esc_attr( $settings['image']['url'] ) . '" signature="' . esc_attr( $settings['signature']['url'] ) . '" team_color="' . esc_attr( $settings['team_color'] ) . '" team_color_preset="custom" team_icon1="' . esc_attr( $team_icon1  ) . '" team_icon_url1="' . esc_attr( $settings['team_icon1_url']['url'] ) . '" team_icon_target1="' . esc_attr( $target1  ) . '" team_icon2="' . esc_attr( $team_icon2  ) . '" team_icon_url2="' . esc_attr( $settings['team_icon2_url']['url'] ) . '" team_icon_target2="' . esc_attr( $target2  ) . '" team_icon3="' . esc_attr( $team_icon3  ) . '" team_icon_url3="' . esc_attr( $settings['team_icon3_url']['url'] ) . '" team_icon_target3="' . esc_attr( $target3  ) . '" team_icon4="' . esc_attr( $team_icon4  ) . '" team_icon_url4="' . esc_attr( $settings['team_icon4_url']['url'] ) . '" team_icon_target4="' . esc_attr( $target4  ) . '" team_icon5="' . esc_attr( $team_icon5  ) . '" team_icon_url5="' . esc_attr( $settings['team_icon5_url']['url'] ) . '" team_icon_target5="' . esc_attr( $target5  ) . '"]';
	}

	protected function content_template() {
		?>
		<# view.addRenderAttribute('team-member-container','class','team-member '+settings.style); #>
		<div {{{view.getRenderAttributeString('team-member-container')}}} >
		<# if (settings.image.url != '') { #>
			<div class="member-pic-container">

				<div class="member-line"></div>

				<div class="member-pic">
					<img class="bg-image" src="{{settings.image.url}}" alt="{{settings.name}}">
				</div>

				<div class="member-plus">
					<span class="member-plus-line"></span>
				</div>
				<#
				let teamIcons = {
					team_icon1 : settings.team_new_icon1.value,
					team_icon2 : settings.team_new_icon2.value,
					team_icon3 : settings.team_new_icon3.value,
					team_icon4 : settings.team_new_icon4.value,
					team_icon5 : settings.team_new_icon5.value
				};
				const hasTeamIcon = (key) => teamIcons[key].length != "";
				if (Object.keys(teamIcons).some(key => hasTeamIcon)) {
					#>
					<ul class="icons">
						<#
						Object.keys(teamIcons).map(key => {
							if (teamIcons[key] != "") {
								let target = (settings[key+'_url']['is_external']) ? "_blank" : "_self";
								view.addRenderAttribute(
									'icon',
									{
										class: settings[key]
									}
								);
								view.addRenderAttribute(
									'icon_url',
									{
										href: settings[key+'_url']['url'],
										title: settings.job_title,
										target: [target]
									}
								);
							#>
							<li>
								<a {{{ view.getRenderAttributeString( 'icon_url' ) }}}>
									<span {{{ view.getRenderAttributeString( 'icon' ) }}}></span>
								</a>
							</li>
							<#
							}
						})
						#>
					</ul>
					<#
				}
				#>
				<div class="overlay"></div>
			</div>
			<div class="member-info">
				<#
				view.addInlineEditingAttributes('job_title','none');
				view.addInlineEditingAttributes('name','none');
				view.addInlineEditingAttributes('description','none');
				view.addRenderAttribute('name','class','member-name');
				#>
				<span {{{ view.getRenderAttributeString('name') }}}>{{{settings.name}}}</span>
				<cite {{{ view.getRenderAttributeString('job_title') }}}>{{settings.job_title}}</cite>
				<div class="member-description">
					<p {{{ view.getRenderAttributeString('description') }}}>{{settings.description}}</p>
					<#
					if (settings.url.url != "") {
						let target = (settings.url.is_external) ? "_blank" : "_self";
						view.addRenderAttribute('url',{href: settings.url.url,target:[target],class:"more-link-arrow",title:settings.elementor_url_title});
					#>
						<a {{{view.getRenderAttributeString('url')}}}>[{{settings.elementor_url_title}}]</a>
					<#
					}
					if (settings.signature.url != '') {
						#>
						<div class="signature">
							<img src="{{{settings.signature.url}}}" alt="{{settings.name}}">
						</div>
						<#
					}
					#>
				</div>
			</div>
		<# } #>
		</div>
		<?php
	}
}
