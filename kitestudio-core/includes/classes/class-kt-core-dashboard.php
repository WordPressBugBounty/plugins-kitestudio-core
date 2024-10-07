<?php

namespace KiteStudioCore;

use Kite_Plugins_Handler;
class Dashboard {

	/**
	 * Holds the current instance of the dashboard
	 *
	 */
	protected static $instance = null;

	/**
	 * TGMPA Menu url
	 *
	 * @var string
	 */
	protected $tgmpa_url = 'themes.php?page=install-required-plugins';

	/**
	 * Retrieves class instance
	 *
	 * @return Dashboard
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * __construct method
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'dashboard_menus' ) );
		add_action( 'admin_head', array( $this, 'disable_admin_notices' ) );
	}

	/**
	 * Create Dashboard Menus
	 *
	 * @return void
	 */
	public function dashboard_menus() {
		if ( ! defined( 'KITE_PACK_MODE' ) ) {
			define( 'KITE_PACK_MODE', '' );
		}
		// add Menu Pages
		add_menu_page( KITE_THEME_NAME . __( ' Dashboard', 'kitestudio-core' ), KITE_THEME_MAIN_NAME . '. ' . KITE_PACK_MODE, 'manage_options', KITE_THEME_SLUG . '-dashboard', array( $this, 'dashboard_page' ), KITE_THEME_ASSETS_URI . '/img/favicon.png', 2 );
		// add Submenu Pages
		add_submenu_page( KITE_THEME_SLUG . '-dashboard', KITE_THEME_NAME . __( ' Dashboard', 'kitestudio-core' ), __( 'Dashboard', 'kitestudio-core' ), 'manage_options', KITE_THEME_SLUG . '-dashboard', '', 0 );
		add_submenu_page( KITE_THEME_SLUG . '-dashboard', KITE_THEME_NAME . __( ' - Demo Import', 'kitestudio-core' ), __( 'Demo Import', 'kitestudio-core' ), 'manage_options', KITE_THEME_SLUG . '-dashboard-demo-import', array( $this, 'demos_page' ), 5 );
		add_submenu_page( KITE_THEME_SLUG . '-dashboard', KITE_THEME_NAME . __( ' - Plugins', 'kitestudio-core' ), __( 'Plugins', 'kitestudio-core' ), 'manage_options', KITE_THEME_SLUG . '-dashboard-plugins', array( $this, 'plugins_page' ), 10 );

		if ( class_exists( '\KiteProTools\Dashboard' ) ) {
			if ( version_compare( KT_PRO_TOOLS_VERSION, '1.3.7', '>' ) ) {
				add_submenu_page( KITE_THEME_SLUG . '-dashboard', __( 'Template Library', 'kitestudio-core' ), __( 'Template Library', 'kitestudio-core' ), 'manage_options', KITE_THEME_SLUG . '-dashboard-template-library', array( $this, 'template_library_page' ), 11 );
				add_submenu_page( KITE_THEME_SLUG . '-dashboard', KITE_THEME_MAIN_NAME . __( ' - Support', 'kitestudio-core' ), __( 'Support', 'kitestudio-core' ), 'manage_options', KITE_THEME_SLUG . '-dashboard-support', array( $this, 'support_page' ), 15 );
			}
		} else {
			add_submenu_page( KITE_THEME_SLUG . '-dashboard', __( 'Template Library', 'kitestudio-core' ), __( 'Template Library', 'kitestudio-core' ), 'manage_options', KITE_THEME_SLUG . '-dashboard-template-library', array( $this, 'template_library_page' ), 11 );
			add_submenu_page( KITE_THEME_SLUG . '-dashboard', KITE_THEME_MAIN_NAME . __( ' - Support', 'kitestudio-core' ), __( 'Support', 'kitestudio-core' ), 'manage_options', KITE_THEME_SLUG . '-dashboard-support', array( $this, 'support_page' ), 15 );
		}

		do_action( 'kite_add_dashboard_menus' );
	}

	/**
	 * Disable admin noticess
	 */
	public function disable_admin_notices() {
		if ( ! defined( 'KITE_PACK_MODE' ) ) {
			define( 'KITE_PACK_MODE', '' );
		}
		$screen            = get_current_screen();
		if ( false !== strpos( $screen->id,  KITE_THEME_SLUG . '-dashboard' ) ) {
			remove_all_actions( 'admin_notices' );
		}
	}

	/**
	 * Create Page Header
	 */
	public function header_page_section() {
		$header_sections = array();
		$header_sections = apply_filters( 'kite_dashboard_header_page_sections', $header_sections );
		ob_start();
		?>

		<div class='kt-dashboard-page-container'>
			<div class='kt-pack-info'>
				<div class="kt-welcome">
					<span class='kt-dashboard-title'><?php echo sprintf( __( 'Welcome To <strong> %s Dashboard </strong>', 'kitestudio-core' ) , KITE_THEME_MAIN_NAME . '. ' . KITE_PACK_MODE ); ?></span>
					<div class="kt-welcome-info">
						<span class="kt-version"><?php echo esc_html__( 'Version', 'kitestudio-core' ) . ' ' . esc_html( KITE_THEME_VERSION ); ?></span>
						<?php do_action( 'kite_dashboard_welcome_info' ); ?>
					</div>
				</div>
				<?php if ( file_exists( get_template_directory() . '/lib/admin/img/main-logo.png' ) ) { ?>
					<img class="kt-logo" src="<?php echo esc_url( KITE_THEME_LIB_URI ) . '/admin/img/main-logo.png'; ?>">
				<?php } ?>
			</div>
			<?php
			foreach ( $header_sections as $section_order => $method ) {
				if ( ! empty( $method['class'] ) ) {
					echo call_user_func( array( $method['class'], $method['func'] ) );
				} else {
					echo call_user_func( $method['func'] );
				}
			}

			$banners = Updater::get_instance()->get_banners_list();
			if ( ! empty( $banners ) ) {
				foreach ( $banners as $banner ) {
					$start_date   = strtotime( $banner['meta']['start_date'] );
					$end_date     = ! empty( $banner['meta']['end_date'] ) ? strtotime( $banner['meta']['end_date'] ) : '';
					$current_date = strtotime( 'now' );
					if ( $banner['meta']['banner_type'] !== 'above_tabs' || $current_date < $start_date || empty( $end_date ) || $end_date < $current_date ) {
						continue;
					}
					?>
					<div class="kt-banner-link">
						<a href="<?php echo esc_url( $banner['meta']['link'] ); ?>" target="_blank">
							<img src="<?php echo esc_url( $banner['meta']['featured_image'] ); ?>" alt="">
						</a>
					</div>
					<?php
				}
			}

			echo $this->add_tab_section();
			echo ob_get_clean();
	}

	/**
	 * Create Page Footer
	 */
	public function footer_page_section() {
		echo '</div>'; // tabs page finish
		// after tabs section
		$footer_page_sections = array();
		$footer_page_sections = apply_filters( 'kite_dashboard_footer_page_sections', $footer_page_sections );
		ob_start();
		foreach ( $footer_page_sections as $section_order => $method ) {
			if ( ! empty( $method['class'] ) ) {
				echo call_user_func( array( $method['class'], $method['func'] ) );
			} else {
				echo call_user_func( $method['func'] );
			}
		}
		?>
		</div>
		<?php
		echo ob_get_clean();
	}

	/**
	 * Genrate Tabs Section
	 */
	public function add_tab_section() {
		$tabs_menus = array(
			'0'  => array(
				'title' => __( 'Dashboard', 'kitestudio-core' ),
				'link'  => add_query_arg( array( 'page' => KITE_THEME_SLUG . '-dashboard' ) ),
				'class' => 'kt-dashboard ' . ( ( $_GET['page'] === KITE_THEME_SLUG . '-dashboard' ) ? 'active' : '' ),
			),
			'5'  => array(
				'title' => __( 'Plugins', 'kitestudio-core' ),
				'link'  => add_query_arg( array( 'page' => KITE_THEME_SLUG . '-dashboard-plugins' ) ),
				'class' => 'kt-plugins ' . ( ( $_GET['page'] == KITE_THEME_SLUG . '-dashboard-plugins' ) ? 'active' : '' ),
			),
			'10' => array(
				'title' => __( 'Demo Import', 'kitestudio-core' ),
				'link'  => add_query_arg( array( 'page' => KITE_THEME_SLUG . '-dashboard-demo-import' ) ),
				'class' => 'kt-demo-import ' . ( ( $_GET['page'] == KITE_THEME_SLUG . '-dashboard-demo-import' ) ? 'active' : '' ),
			),
		);

		if ( class_exists( '\KiteProTools\Dashboard' ) ) {
			if ( version_compare( KT_PRO_TOOLS_VERSION, '1.3.7', '>' ) ) {
				$tabs_menus['11'] = array(
					'title' => __( 'Template Library', 'kitestudio-core' ),
					'link'  => add_query_arg( array( 'page' => KITE_THEME_SLUG . '-dashboard-template-library' ) ),
					'class' => 'kt-support ' . ( ( $_GET['page'] == KITE_THEME_SLUG . '-dashboard-template-library' ) ? 'active' : '' ),
				);

				$tabs_menus['15'] = array(
					'title' => __( 'Support', 'kitestudio-core' ),
					'link'  => add_query_arg( array( 'page' => KITE_THEME_SLUG . '-dashboard-support' ) ),
					'class' => 'kt-support ' . ( ( $_GET['page'] == KITE_THEME_SLUG . '-dashboard-support' ) ? 'active' : '' ),
				);

				if ( ! kite_is_license_verified() ) {
					$tabs_menus['15']['title'] = __( 'Support', 'kitestudio-core' ) . '<span class="kt-pro-badge"><span class="icon icon-lock2"></span>PRO</span>';
				}
			}
		} else {

			$tabs_menus['11'] = array(
				'title' => __( 'Template Library', 'kitestudio-core' ),
				'link'  => add_query_arg( array( 'page' => KITE_THEME_SLUG . '-dashboard-template-library' ) ),
				'class' => 'kt-support ' . ( ( $_GET['page'] == KITE_THEME_SLUG . '-dashboard-template-library' ) ? 'active' : '' ),
			);

			$tabs_menus['15'] = array(
				'title' => __( 'Support', 'kitestudio-core' ) . '<span class="kt-pro-badge"><span class="icon icon-lock2"></span>PRO</span>',
				'link'  => add_query_arg( array( 'page' => KITE_THEME_SLUG . '-dashboard-support' ) ),
				'class' => 'kt-support ' . ( ( $_GET['page'] == KITE_THEME_SLUG . '-dashboard-support' ) ? 'active' : '' ),
			);
		}

		$tabs_menus = apply_filters( 'kite_dashboard_tabs_menu', $tabs_menus );

		?>
		<div class="kt-tabs-section">
			<ul class="kt-tabs-container">
				<?php
				foreach ( $tabs_menus as $key => $menu ) {
					?>
					<li class="kt-tabs-item
					<?php
					if ( strpos( $menu['class'], 'active' ) ) {
						echo 'active';
					}
					?>
					">
						<a href="<?php echo esc_url( $menu['link'] ); ?>" class="<?php echo esc_attr( $menu['class'] ); ?>"><?php echo wp_kses( $menu['title'], kite_allowed_html() ); ?></a>
					</li>
					<?php
				}
				?>
			</ul>
		<?php
	}

	/**
	 * generate dashboard page
	 */
	public function dashboard_page() {
		$this->header_page_section();
		$banners = Updater::get_instance()->get_banners_list();
		?>
		<div class="kt-dashboard-page">
			<div class="kt-useful-links">
				<div class="kt-link">
					<a href="https://support.kitestudio.co/knowledge-base/" target="_blank">
						<img src="<?php echo esc_url( KITE_CORE_URL ) . 'admin/img/knowledge.png'; ?>" alt="">
						<span><?php echo sprintf( esc_html__( '%1$sKnowledge%2$s Base', 'kitestudio-core' ), '<strong>', '</strong>' ); ?></span>
					</a>
				</div>
				<div class="kt-link">
					<a href="https://www.youtube.com/channel/UClMTrd24MN9c8u34z5edeLA" target="_blank">
						<img src="<?php echo esc_url( KITE_CORE_URL ) . 'admin/img/tutorial.png'; ?>" alt="">
						<span><?php echo sprintf( esc_html__( '%1$sVideo%2$s Tutorial', 'kitestudio-core' ), '<strong>', '</strong>' ); ?></span>
					</a>
				</div>
				<div class="kt-link">
					<a href="https://kitestudio.co/agency" target="_blank">
						<img src="<?php echo esc_url( KITE_CORE_URL ) . 'admin/img/customization.png'; ?>" alt="">
						<span><?php echo sprintf( esc_html__( '%1$sCustomization%2$s', 'kitestudio-core' ), '<strong>', '</strong>' ); ?></span>
					</a>
				</div>
				<?php
				if ( ! empty( $banners ) ) {
					foreach ( $banners as $banner ) {
						$start_date   = strtotime( $banner['meta']['start_date'] );
						$end_date     = ! empty( $banner['meta']['end_date'] ) ? strtotime( $banner['meta']['end_date'] ) : '';
						$current_date = strtotime( 'now' );
						if ( $banner['meta']['banner_type'] != 'in_dashboard' || $current_date < $start_date || empty( $end_date ) || $end_date < $current_date ) {
							continue;
						}
						?>
						<div class="kt-banner-link">
							<a href="<?php echo esc_url( $banner['meta']['link'] ); ?>" target="_blank">
								<img src="<?php echo esc_url( $banner['meta']['featured_image'] ); ?>" alt="">
							</a>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>
		<?php
		$this->footer_page_section();
	}
	/**
	 * generate demos page
	 */
	public function demos_page() {
		$this->header_page_section();
		if ( ! empty( $_POST['demo_name'] ) && class_exists( 'KiteStudioCore\Demo_Installer' ) ) {
			$demo_importer = new Demo_Installer();
			$demo_importer->importer_start();
		} else {
			?>
		<form id="kt-demo-import" method="post">
			<ul id="kt-demos-list">
				<?php
				$demos_list = Updater::get_instance()->download_dummy_data();
				if ( is_array( $demos_list ) ) {
					$is_license_verified = kite_is_license_verified();
					foreach ( $demos_list as $demo_id => $demo_info ) {
						$classes   = 'kt-demo-item kt-lazy';
						$demo_item = '<li class="' . esc_attr( $classes ) . '">';
						if ( $demo_info['pro_state'] == 'pro' && ! $is_license_verified ) {
							$demo_item .= '<span class="kt-pro-badge"><span class="icon icon-lock2"></span>PRO</span>';
						}
						$demo_item .= '<input type="radio" name="demo_name" value="' . esc_attr( $demo_id ) . '" id="demo' . esc_attr( $demo_id ) . '" class="input-hidden"/>
                            <img src="data:image/gif;base64,R0lGODlhCQAHAIAAAP///wAAACH5BAEAAAEALAAAAAAJAAcAAAIHjI+py+1cAAA7" data-src="' . $demo_info['image'] . '" alt="Demo' . $demo_id . '" />
                            <div class="kt-demo-info">
                                <div class="kt-demo-title">
                                    <span class="kt-demo-name">' . esc_html( $demo_info['Name'] ) . '</span>
                                </div>
                                <div class="kt-demo-buttons">';

						if ( ( $demo_info['pro_state'] == 'pro' && kite_is_license_verified() ) || $demo_info['pro_state'] == 'free' ) {
							$demo_item .= '<a href="#" class="kt-import">' . __( 'Import', 'kitestudio-core' ) . '</a> ';
						}

								$demo_item .= '<a href="' . esc_url( $demo_info['url'] ) . '" class="kt-preview" target="_blank">' . __( 'Preview', 'kitestudio-core' ) . '</a>
                                </div>
                            </div>
                        </li>';
						echo apply_filters( 'kite_demo_item', $demo_item, $demo_id, $demo_info );
					}
				}
				?>
			</ul>
			<a href="<?php echo esc_url( add_query_arg( 'force-check', '1' ) ); ?>"
					   class="kt-fetch-demos"><?php esc_html_e( 'Fetch Demo List', 'kitestudio-core' ); ?></a>
			<input type="hidden" name="kt-importer" value='1'>
		</form>
			<?php
		}
		$this->footer_page_section();
	}

	/**
	 * generate Plugins page
	 */
	public function plugins_page() {
		$this->header_page_section();

		tgmpa_load_bulk_installer();
		// install plugins with TGM.
		if ( ! class_exists( 'TGM_Plugin_Activation' ) || ! isset( $GLOBALS['tgmpa'] ) ) {
			die( 'Failed to find TGM' );
		}
		$url = wp_nonce_url( add_query_arg( array( 'plugins' => 'go' ) ), KITE_THEME_SLUG . '-dashboard-plugins' );

		// copied from TGM

		$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
		$fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.

		if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
			return true; // Stop the normal page form from displaying, credential request form will be shown.
		}

		// Now we have some credentials, setup WP_Filesystem.
		if ( ! WP_Filesystem( $creds ) ) {
			// Our credentials were no good, ask the user for them again.
			request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );

			return true;
		}

		if ( ! class_exists( 'Kite_Plugins_Handler' ) ) {
			die( esc_html__( 'We have released new version of theme with so many improvements. To get all improvements and get access to this page please update the theme.', 'kitestudio-core' ) );
		}
		/* If we arrive here, we have the filesystem */
		$plugins = Kite_Plugins_Handler::get_instance()->_get_plugins();

		?>
		<form method="post" class="kt-plugins-page">
			<span class="kt-plugins-page-title"><?php echo esc_html__( 'Default Plugins', 'kitestudio-core' ); ?></span>
			<br>
			<?php
			if ( count( $plugins['all'] ) ) {
				?>
				<span class="kt-plugins-page-desc"><?php echo esc_html__( 'Your website needs a few essential plugins. The following plugins will be installed or updated:', 'kitestudio-core' ); ?></span>
				<?php
			} else {
				?>
				<span class="kt-plugins-page-desc"><?php echo esc_html__( 'Good news. All essentials plugins are active and up to date.', 'kitestudio-core' ); ?></span>
				<?php
			}
			?>
			<?php
			if ( count( $plugins['all'] ) ) {
				?>
				<ul class="kt-plugins-form" data-redirect="<?php echo esc_url( admin_url( 'admin.php?page=' . KITE_THEME_SLUG . '-dashboard-plugins' ) ); ?>">
					<?php if ( ! empty( $_COOKIE['pluginFailed'] ) ) { ?>
					<li style="color: red;border: 1px dashed;padding: 5px;"><?php esc_html_e( 'It Seems that some plugins have failed.Please try again.', 'kitestudio-core' ); ?></li>
					<?php } ?>
					<?php
					$required = array_filter(
						$plugins['all'],
						function( $el ) {
							return $el['required'];
						}
					);
					if ( ! empty( $required ) ) {
						?>
						<li class="kt-plugins-title"><?php esc_html_e( 'Required', 'kitestudio-core' ); ?></li>
						<?php
					}
					?>
					<?php foreach ( $required as $slug => $plugin ) { ?>
						<li data-slug="<?php echo esc_attr( $slug ); ?>" class="plugin-to-install">
							<?php
							$keys    = array();
							$actions = array(
								'install'  => '',
								'update'   => '',
								'activate' => '',
							);
							if ( isset( $plugins['install'][ $slug ] ) ) {
								$keys[]             = __( 'Installation', 'kitestudio-core');
								$actions['install'] = 'install';
							}
							if ( isset( $plugins['update'][ $slug ] ) ) {
								$keys[]            = __( 'Update', 'kitestudio-core');
								$actions['update'] = 'update';
							}
							if ( isset( $plugins['activate'][ $slug ] ) ) {
								$keys[]              = __( 'Activation', 'kitestudio-core');
								$actions['activate'] = 'activate';
							}
							?>
							<input
								type="checkbox"
								name="plugin-import[<?php echo esc_attr( $slug ); ?>]"
								id="plugin-import[<?php echo esc_attr( $slug ); ?>]"
								checked="checked"
								disabled="disabled"
								data-actions="<?php echo esc_attr( wp_json_encode( $actions ) ); ?>"
								data-slug="<?php echo esc_attr( $slug ); ?>"
								data-wpnonce="<?php echo wp_create_nonce( 'bulk-plugins' ); ?>"
							/><?php echo esc_html( $plugin['name'] ); ?>
							<span class='kt-error'> <?php echo esc_html( implode( __( ' and ', 'kitestudio-core' ), $keys ) . __( ' required', 'kitestudio-core' ) ); ?></span>
							<div class="spinner"></div>
						</li>
						<?php
					}
					$recommended = array_filter(
						$plugins['all'],
						function( $el ) {
							return ( ! $el['required'] );
						}
					);
				if ( ! empty( $recommended ) ) {
					?>
						<li class="kt-plugins-title"><?php esc_html_e( 'Recommended', 'kitestudio-core' ); ?></li>
						<?php
				}
				foreach ( $recommended as $slug => $plugin ) {
					?>
						<?php
						$keys         = array();
						$actions      = array(
							'install'  => '',
							'update'   => '',
							'activate' => '',
						);
						$data_install = admin_url( $this->tgmpa_url );
						if ( isset( $plugins['install'][ $slug ] ) ) {
							$keys[]             = __( 'Installation', 'kitestudio-core' );
							$actions['install'] = 'install';
						}
						if ( isset( $plugins['update'][ $slug ] ) ) {
							$keys[]            = __( 'Update', 'kitestudio-core' );
							$actions['update'] = 'update';
						}
						if ( isset( $plugins['activate'][ $slug ] ) ) {
							$keys[]              = __( 'Activation', 'kitestudio-core' );
							$actions['activate'] = 'activate';
						}
						?>
						<li data-slug="<?php echo esc_attr( $slug ); ?>" class="plugin-to-install">
							<input
								type="checkbox"
								name="plugin-import[<?php echo esc_attr( $slug ); ?>]"
								id="plugin-import[<?php echo esc_attr( $slug ); ?>]"
								data-install="<?php echo esc_attr( $data_install ); ?>"
								data-actions="<?php echo esc_attr( wp_json_encode( $actions ) ); ?>"
								data-slug="<?php echo esc_attr( $slug ); ?>"
								data-wpnonce="<?php echo wp_create_nonce( 'bulk-plugins' ); ?>"
							/><?php echo esc_html( $plugin['name'] ); ?>
							<span class='kt-error'>
							<?php echo esc_html( implode( __( ' and ', 'kitestudio-core' ), $keys ) . __( ' recommended', 'kitestudio-core' ) ); ?>
							</span>
							<div class="spinner"></div>
						</li>
					<?php } ?>
				</ul>
				<?php
			} else {
				echo '<p><strong>' . esc_html_e( 'Good news! All plugins are already installed and up to date. Please continue.', 'kitestudio-core' ) . '</strong></p>';
			}
			?>
			<button class='kt-install-plugins'><?php esc_html_e( 'Install Plugins', 'kitestudio-core' ); ?></button>
		</form>
		<?php
		$this->footer_page_section();
	}

	/**
	 * generate template library page
	 */
	public function template_library_page() {
		$this->header_page_section();
		$template_importing = ! empty( $_POST['template_id'] ) ? true : false;

		$is_license_verified = kite_is_license_verified();

		?>
		<div
		<?php
		if ( $template_importing ) {
			echo 'id="kt-importer-box"';}
		?>
		 class='kt-template-library-page'>
		<?php

		// Check if template is importing or not
		if ( $template_importing ) {
			if ( class_exists( '\KiteProTools\Dashboard' ) ) {
				\KiteProTools\Dashboard::get_instance()->import_template();
			}
			return;
		}

		// Check if header/footer ID received, set the imported template as default one
		if ( ! empty( $_POST['template-id'] ) && ! empty( $_POST['template-type'] ) && class_exists( '\Redux' ) ) {

			\Redux::set_option( KITE_OPTIONS_KEY, 'is_' . sanitize_text_field( $_POST['template-type'] ) . '_build_with_elementor', true );
			\Redux::set_option( KITE_OPTIONS_KEY, 'elementor_' . sanitize_text_field( $_POST['template-type'] ) . '_template_id', sanitize_text_field( $_POST['template-id'] ) );

			?>
			<div class="iziToast success"
				data-title="<?php esc_attr_e( 'Success', 'kitestudio-core' ); ?>"
				data-message="<?php echo sprintf( esc_attr__( 'The imported template was set as your default %s.', 'kitestudio-core' ), esc_attr( $_POST['template-type'] ) ); ?>">
			</div>
			<?php
		}

		$template_library = Updater::get_instance()->get_templates_library();
		$template_types   = array(
			'header'  => array( 'headers', __( 'Headers', 'kitestudio-core' ) ),
			'footer'  => array( 'footers', __( 'Footers', 'kitestudio-core' ) ),
			// 'product-description'   => [ 'product-description' , __( 'Product Description', 'kitestudio-core' ) ],
			'section' => array( 'sections', __( 'Sections', 'kitestudio-core' ) ),
		);
		?>
			<form id="kt-template-import" method="post">
				<ul class="kt-template-tabs">
					<?php
					foreach ( $template_types as $type => $detail ) {
						$counter = 0;
						array_walk_recursive(
							$template_library,
							function( $value, $key ) use ( &$counter, $type ) {
								if ( ! is_array( $value ) && $key == 'template_type' && $value == $type ) {
									$counter++;
								}
							}
						);

						$classes = ( $type == 'header' ) ? 'active' : '';

						if ( ! $counter ) {
							$classes .= ' disable';
						}

						echo "<li data-panel='#" . esc_attr( $detail[0] ) . "' class='" . esc_attr( $classes ) . "' >" . esc_html( $detail[1] ) . "<span class='kt-template-number'>" . esc_html( $counter ) . '</span></li>';
					}
					?>
				</ul>
				<?php
				foreach ( $template_types as $type => $detail ) {
					?>
					<ul id='<?php echo esc_attr( $detail[0] ); ?>' class="<?php echo ( $type == 'header' ? 'active' : '' ); ?>">
						<?php
						if ( !empty( $template_library ) ) {
							foreach ( $template_library as $template ) {
								if ( $template['meta']['template_type'] == $type ) {
									?>
										<li data-template_ID="<?php echo esc_attr( $template['id'] ); ?>" class="kt-template-item kt-lazy" >
											<div class="kt-item-head"><?php echo esc_html( $template['title'] ); ?><?php echo ( $is_license_verified ) ? '' : '<span class="kt-pro-badge"><span class="icon icon-lock2"></span>' . esc_html__( 'PRO', 'kitestudio-core' ) . '</span>'; ?></div>
											<input type="radio" name="template_id" value="<?php echo esc_attr( $template['id'] ); ?>" class="input-hidden"/>
											<img src="data:image/gif;base64,R0lGODlhCQAHAIAAAP///wAAACH5BAEAAAEALAAAAAAJAAcAAAIHjI+py+1cAAA7" data-src="<?php echo esc_url( $template['meta']['featured_image'] ); ?>" alt="<?php echo esc_attr( $template['title'] ); ?>">
											<div class="kt-item-footer">
												<div class="kt-template-buttons">
													<a href="#" class="kt-import
													<?php
													if ( ! $is_license_verified ) {
														echo 'disable';}
													?>
													"><?php echo esc_html__( 'Import', 'kitestudio-core' ); ?></a>
												</div>
											</div>
										</li>
									<?php
								}
							}
						}
						?>
					</ul>
					<?php
				}
				?>
				<a href="<?php echo esc_url( add_query_arg( 'force-check', '1' ) ); ?>"
					   class="kt-fetch-demos"><?php esc_html_e( 'Fetch Templates List', 'kitestudio-core' ); ?></a>
				<input type="hidden" name="kt-importer" value='1'>
			</form>
		</div>
		<?php
		$this->footer_page_section();
	}

	/**
	 * generate support page
	 */
	public function support_page() {
		$this->header_page_section();
		?>
		<div class='kt-support-page'>
			<h1><?php esc_html_e( 'Help and Support', 'kitestudio-core' ); ?></h1>
			<p>
			<?php
			esc_html_e(
				'This theme comes with 6 months item support from purchase date (with the option to extend this period).
                This license allows you to use this theme on a single website. Please purchase an additional license to
                use this theme on another website.',
				'kitestudio-core'
			);
			?>
				</p>
			<p><?php echo sprintf( esc_html__( 'For item support, please contact us via email by sharing your purchase code at: %s. Support includes: ', 'kitestudio-core' ), '<a href="mailto:help.kitestudio@gmail.com" target = "_blank" > help.kitestudio@gmail.com </a>' ); ?></p>
			<ul class="kt-supports-item">
				<li><?php esc_html_e( 'Availability of the author to answer questions', 'kitestudio-core' ); ?></li>
				<li><?php esc_html_e( 'Answering technical questions about item features', 'kitestudio-core' ); ?></li>
				<li><?php esc_html_e( 'Assistance with reported bugs and issues', 'kitestudio-core' ); ?></li>
				<li><?php esc_html_e( 'Help with bundled 3rd party plugins', 'kitestudio-core' ); ?></li>
			</ul>
			<p><?php echo sprintf( esc_html__( 'More details about item support can be found in the ThemeForest %sItem Support Policy%s.', 'kitestudio-core' ), '<a href="http://themeforest.net/page/item_support_policy" target="_blank">','</a>' ); ?></p>
		</div>
		<?php
		$this->footer_page_section();
	}

}
?>
