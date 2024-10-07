<?php

namespace KiteStudioCore;

use WP_Filesystem_Base;

class Media {

    /**
     * @var WP_Filesystem_Base
     */
    public $wp_filesystem = null;

    /**
     * Holds the current instance of the dashboard
     *
     */
    protected static $instance     = null;

    /**
     * Retrieves class instance
     *
     * @return Media
     */
    public static function get_instance() {
        if (!self::$instance) {
            self::$instance     = new self;
        }

        return self::$instance;
    }

    /**
     * __construct method
     */
    public function __construct() {

        global $wp_filesystem;

        if (is_null($wp_filesystem)) {
            require_once(ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        $this->wp_filesystem = $wp_filesystem;

        add_filter('media_upload_tabs', [$this, 'add_new_tab']);
        add_action('media_upload_kite_media', [$this, 'media_tab_form']);
        add_action('wp_ajax_search_kite_photos', [$this, 'search_photos']);
        add_action('wp_ajax_download_media', [$this, 'download_media']);
    }


    public function add_new_tab($tabs) {
        $tabs['kite_media'] = __('Quick Image Importer', 'kitestudio-core');
        return $tabs;
    }

    public function search_photos() {
        if (empty($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'kite_search_photos')) {
            wp_send_json_error(['message' => __('You don\'t have permission to send this request.', 'kitestudio-core')], 403);
        }

        $args = [
            's' => !empty($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : '',
            'page' => !empty($_GET['page']) ? absint($_GET['page']) : '',
            'perPage' => !empty($_GET['per_page']) ? absint($_GET['per_page']) : 40
        ];

        if (empty($args['s'])) {
            wp_send_json_error(['message' => __('Search field is empty.', 'kitestudio-core')], 400);
        }

        try {
            $result = Remote::search_photos($args);
            $markup = '';
            if (!empty($result['photos'])) {
                // $markup .= '<div class="kt-photos">';
                foreach ($result['photos'] as $photo) {
                    $photo['authorUrl'] = add_query_arg([
                        'utm_source' => 'kitestudio_themes_app',
                        'utm_medium' => 'referral'
                    ], $photo['authorUrl']);

                    $photo['html'] = add_query_arg([
                        'utm_source' => 'kitestudio_themes_app',
                        'utm_medium' => 'referral'
                    ], $photo['html']);

                    $markup .= '<div class="kt-photo">';
                    $markup .= "<div class='author'><img src='" . $photo['authorProfileImage'] . "' with='32px' height='32px'><a href='" . $photo['authorUrl'] . "' target='_blank'><span class='author-name'>" . $photo['author'] . "</span></a></div>";
                    $markup .= "<div class='buttons-wrapper'>";
                    $markup .= "<span class='new-tab'><a href='" . $photo['html'] . "' target='_blank'></a><img width='32px' height='32px' src='" . KITE_CORE_URL . 'admin/img/new-tab.svg' . "'></span>";
                    $markup .= "<span class='download' data-id='" . $photo['id'] . "'><img width='32px' height='32px' src='" . KITE_CORE_URL . 'admin/img/download.svg' . "'></span>";
                    $markup .= "</div>";
                    $markup .= '<img src="' . $photo['thumb'] . '" width="' . $photo['width'] . '" height="' . $photo['height'] . '" data-id="' . $photo['id'] . '" blur-hash="' . $photo['blurHash'] . '">';
                    $markup .= '</div>';
                }

                // $markup .= '</div>';
            }

            wp_send_json_success([
                'page' => $result['page'],
                'per_page' => $result['perPage'],
                'total_pages' => $result['totalPages'],
                'markup' => $markup
            ]);
        } catch (\Exception $exception) {
            wp_send_json_error(['message' => $exception->getMessage()], 400);
        }
    }

    public function download_media() {
        if (empty($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'kite_search_photos')) {
            wp_send_json_error(['message' => __('You don\'t have permission to send this request.', 'kitestudio-core')], 403);
        }

        $media_id = !empty($_GET['id']) ? sanitize_text_field($_GET['id']) : '';

        if (empty($media_id)) {
            wp_send_json_error(['message' => __('Media ID required for downloading the media.', 'kitestudio-core')], 400);
        }

        try {
            $response = Remote::download_photo($media_id);
            if (!$response) {
                wp_send_json_error(['message' => __('Media not found.', 'kitestudio-core')], 404);
            }

            $contentType = wp_remote_retrieve_header($response, 'content-type');
            if (!$contentType) {
                wp_send_json_error(['message' => __('Media content issue encountered.', 'kitestudio-core')], 404);
            }

            if ($contentType == 'image/jpeg') {
                $filename = $media_id . '.jpg';
            } elseif ($contentType == 'image/png') {
                $filename = $media_id . '.png';
            } elseif ($contentType == 'image/bmp') {
                $filename = $media_id . '.bmp';
            } elseif ($contentType == 'image/svg+xml') {
                $filename = basename($media_id);
            } else {
                // $parts = parse_url( $url );
                // parse_str( $parts['query'], $query);
                // $filename = isset( $query['filename'] ) ? $query['filename'] : $assetFileName . '.mp4';
                $filename = $media_id . '.mp4';
            }

            $upload_dir = wp_upload_dir();
            if (!$this->wp_filesystem->exists($upload_dir['path'] . '/' . $filename)) {
                $media_body = wp_remote_retrieve_body($response);
                $is_downloaded = $this->wp_filesystem->put_contents($upload_dir['path'] . '/' . $filename, $media_body);
                if (!$is_downloaded) {
                    wp_send_json_error(['message' => __('An issue encountered while downloading the media. Please try again later.', 'kitestudio-core')], 404);
                }

                $attachment = array(
                    'post_mime_type' => $contentType,
                    'post_title' => $filename,
                    'post_content' => '',
                    'post_status' => 'inherit'
                );

                $attachmentId = wp_insert_attachment($attachment, $upload_dir['path'] . '/' . $filename);

                if (is_wp_error($attachmentId) || !$attachmentId) {
                    wp_send_json_error(['message' => __('Error while inserting media in database.', 'kitestudio-core')], 404);
                }

                wp_update_attachment_metadata($attachmentId, wp_generate_attachment_metadata($attachmentId, $upload_dir['path'] . '/' . $filename));
                wp_send_json_success(['message' => __('Media downloaded and successfully imported.', 'kitestudio-core')]);
            } else {
                wp_send_json_error(['message' => sprintf( __('A media with the name %s has been already downloaded.', 'kitestudio-core'), $filename )], 404);
            }
        } catch (\Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()], 400);
        }
    }

    public function media_tab_form() {
?>
        <script src="<?php echo includes_url('js/jquery/jquery.min.js'); ?>"></script>
        <script src="<?php echo KITE_THEME_ASSETS_URI . '/js/isotope.pkgd.min.js'; ?>"></script>
        <script type="text/javascript">
            var kitestudioCore = {
                "ajax_url": "<?php echo esc_url(admin_url('admin-ajax.php')); ?>"
            };
        </script>
        <script src="<?php echo KITE_CORE_URL . 'admin/js/kt-core-admin-media.js'; ?>"></script>
        <style>
            #kt-search-media {
                font-size: 18px;
                line-height: 1.22222222;
                padding: 12px 40px 12px 14px;
                width: 100%;
                min-width: 200px;
                box-shadow: inset 2px 2px 4px -2px rgba(0,0,0,.1);
                border-radius: 4px;
                border: 1px solid #8c8f94;
                background-color: #fff;
                color: #2c3338;
            }
            #kt-search-media:focus {
                border-color: #3582c4;
                box-shadow: 0 0 0 1px #3582c4;
                outline: 2px solid transparent;
            }

            /* Typing Animation in Search Segment */
            .typing-indicator {
                position: relative;
                margin: 10px auto;
                width: 100%;
                display: flex;
                justify-content: center;
            }

            .typing-indicator span {
                visibility: hidden;
                height: 14px;
                width: 14px;
                float: left;
                margin-right: 4px;
                background-color: #9e9ea1;
                display: block;
                border-radius: 50%;
                opacity: 0.4;
                position: relative;
                top: 22px;
                box-sizing: content-box;
            }

            .kt-media-wrapper.loading .typing-indicator span {
                visibility: visible;
            }

            .typing-indicator span:nth-of-type(1) {
                animation: 1s blink infinite 0.3333s;
            }

            .typing-indicator span:nth-of-type(2) {
                animation: 1s blink infinite 0.6666s;
            }

            .typing-indicator span:nth-of-type(3) {
                animation: 1s blink infinite 0.9999s;
            }

            @keyframes blink {
                50% {
                    opacity: 1;
                }
            }

            .kt-media-wrapper p {
                font-family: 'Inter';
                font-size: 15px;
                font-weight: 400;
                line-height: 18px;
                letter-spacing: 0em;
                text-align: left;
                color: #767676;
            }

            .kt-photos {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                margin-top: 10px;
                max-width: 100%;
            }

            .kt-photo {
                width: calc( 25% - 10px );
                max-width: 400px;
                margin-bottom: 5px;
                background-color: #ccc;
                overflow: hidden;
                border: 4px solid #fff;
                box-sizing: border-box;
            }

            .kt-photo:hover {
                border-color: #2271B1;
            }

            .kt-photo > img {
                max-width: 100%;
                height: auto;
            }

            .kt-photo .author {
                position: absolute;
                z-index: 1;
                top: 14px;
                left: 19px;
                display: flex;
                align-items: center;
            }

            .kt-photo .author img {
                border-radius: 50%;
                margin-right: 7px;
            }

            .kt-photo .author a {
                text-decoration: none;
                color: #fff;
            }

            .kt-photo .buttons-wrapper {
                position: absolute;
                z-index: 1;
                bottom: 14px;
                right: 14px;
            }

            .kt-photo .buttons-wrapper span {
                padding: 6px;
                background-color: #fff;
                display: inline-block;
                border-radius: 7px;
                margin-right: 7px;
                cursor: pointer;
                position: relative;
                /* transform: translateY(44px); */
                opacity: 0;
                transition: all ease-in 300ms;
            }

            .kt-photo .buttons-wrapper span:first-child {
                transition-delay: 50ms;
            }

            .kt-photo:hover .buttons-wrapper span {
                /* transform: translateY(0); */
                opacity: 1;

            }

            .kt-photo .buttons-wrapper a {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
            }

            .kt-photo.downloading:before,
            .kt-photo.downloading:after {
                content: '';
                width: 20px;
                height: 20px;
                position: absolute;
                display: inline-block;
                background-color: <?php echo kite_opt('style-accent-color', '#ff4c2f'); ?>;
                border-radius: 50%;
                top: 50%;
                left: 50%;
                animation: kt-importing 1s infinite linear;
                display: inline-block;
            }

            .kt-photo.downloading:before {
                left: calc(50% - 18px);
                animation-delay: 500ms;
            }

            @keyframes kt-importing {
                0% {
                    opacity: 0;
                    transform: scale(0.5)
                }

                50% {
                    transform: scale(1);
                    opacity: 1;
                }

                100% {
                    opacity: 0;
                    transform: scale(0.5)
                }
            }

            .kt-toast {
                position: fixed;
                bottom: 24px;
                left: 24px;
                z-index: 0;
                background-color: #3DC47E;
                font-size: 16px;
                color: #fff;
                opacity: 0;
                transition: all 300ms ease-in;
                padding: 14px 15px 14px 49px;
            }

            .kt-toast.show {
                z-index: 2;
                opacity: 1;
            }
            .kt-toast .check {
                position: absolute;
                top: 0;
                padding: 0px 8px;
                background-color: #2C8F5C;
                left: 0;
                min-height: 46px;
                display: flex;
                align-items: center;
            }
        </style>
        <div class="kt-media-wrapper">
            <input type="text" name="s" id="kt-search-media" placeholder="<?php echo __('Search For Photos', 'kitestudio-core'); ?>">
            <p><?php esc_html_e('Find high resolution images on Unsplash with ease.', 'kitestudio-core') ?></p>
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('kite_search_photos'); ?>">
            <input type="hidden" name="page-number" value="1">
            <div class="media-results">
                <div class="kt-toast">
                    <span class="check"><img width='25px' height='19px' src='<?php echo KITE_CORE_URL;?>admin/img/check.svg'></span>
                    <span><?php esc_attr_e('“Selected image has been added to your media library.”', 'kitestudio-core'); ?></span>
                </div>
                <div class="kt-photos"></div>
            </div>
            <div class="typing-indicator">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
<?php
    }
}
