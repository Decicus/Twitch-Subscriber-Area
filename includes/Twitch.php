<?php
namespace Decicus;


class Twitch {
    const API_URL = 'https://api.twitch.tv/kraken/';
    private $API_KEY;
    private $API_SECRET;
    public $REDIRECT_URL;

    public function __construct( $key, $secret, $redirect_url ) {
        $this->API_KEY = $key;
        $this->API_SECRET = $secret;
        $this->REDIRECT_URL = $redirect_url;
    }

    function get( $url = '', $header = [] ) {
        $header[] = 'Client-ID: ' . $this->API_KEY;
        $curl = curl_init();
        curl_setopt( $curl, CURLOPT_URL, $this::API_URL . $url );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false ); // This is an issue on most Windows hosts, and it seems to be the easiest solution.
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $header );
        $o = curl_exec( $curl );
        $resp = json_decode( $o, true );
        curl_close( $curl );

        return $resp;
    }

    function getUserID( $name = '' ) {
        $data = $this->get( 'users/' . $name );
        return ( isset( $data['_id'] ) ? $data['_id'] : false );
    }
}
?>
