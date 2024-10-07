<?php

namespace KiteStudioCore;

class Remote {

    const API_URL = 'https://api.kitestudio.co/v1/';

    /**
     * Search photos
     *
     * @param [type] $args
     * @return void
     */
    public static function search_photos( $args ) {

        $endpoint = add_query_arg( $args, self::API_URL . 'media/search/photos' );
        $response = wp_remote_get( $endpoint );

        if ( is_wp_error( $response ) ) {
            throw new \Exception( $response->get_error_message() );
        }

        $body = json_decode( wp_remote_retrieve_body( $response ), true );
        if ( wp_remote_retrieve_response_code( $response ) !== 200 ) {
            throw new \Exception( $body['errors'][0] );
        }

        return $body;
    }

    public static function download_photo( $id ) {
        $endpoint = self::API_URL . 'media/photo/download/' . $id;
        $response = wp_remote_get($endpoint);

        if (is_wp_error($response)) {
            throw new \Exception($response->get_error_message());
        }

        if ( wp_remote_retrieve_response_code( $response ) == 404 ) {
            return false;
        }

        return $response;
    }

}
