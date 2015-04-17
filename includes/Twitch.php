<?php
namespace Decicus;

/*
    This is a heavily modified version of another project of mine:
    https://github.com/The-Blacklist/Twitch-API-PHP
*/
class Twitch {
    const API_URL = 'https://api.twitch.tv/kraken/';
    private $API_KEY;
    private $API_SECRET;
    public $REDIRECT_URL;
    
    // Initiliazes
    public function __construct( $key, $secret, $redirect_url ) {
        $this->API_KEY = $key;
        $this->API_SECRET = $secret;
        $this->REDIRECT_URL = $redirect_url;
    }
    
    // Generic get() method for communication with the kraken API.
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
    
    // Returns a formatted authentication URL with the scopes given
    function authenticateURL( $scope = [] ) {
        $s_scope = implode( "+", $scope );
        $url = $this::API_URL . 'oauth2/authorize?response_type=code&client_id=' . $this->API_KEY . '&redirect_uri=' . $this->REDIRECT_URL . '&scope=' . $s_scope;
        return $url;
    }
    
    // Returns access token after authorizing the application via the URL returned from authenticateURL().
    function getAccessToken( $c ) {
        $curl = curl_init( $this::API_URL . 'oauth2/token' );
        curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $curl, CURLOPT_POST, 1 );
        $f = [
            'client_id' => $this->API_KEY,
            'client_secret' => $this->API_SECRET,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->REDIRECT_URL,
            'code' => $c
        ];
        curl_setopt( $curl, CURLOPT_POSTFIELDS, $f );
        $d = curl_exec( $curl );
        $resp = json_decode( $d, true );
        if( isset( $resp[ 'access_token' ] ) ) {
            return $resp[ 'access_token' ];
        }
        else {
            return false;
        }
    }

    // Returns user ID, which is a unique numeric ID. This should work, even after name changes arrive.
    function getUserID( $name = '' ) {
        $data = $this->get( 'users/' . $name );
        return ( isset( $data['_id'] ) ? $data['_id'] : false );
    }
    
    // Returns lowercase name
    function getName( $at = '' ) {
        $header = [ 'Authorization: OAuth ' . $at ];
        $data = $this->get( 'user', $header );
        return ( isset( $data['name'] ) ? $data['name'] : NULL );
    }
    
    // This is different from getName(), because this includes capitalization (and possibly spaces for some odd reason - read: http://ask.fm/Xangold/answer/125800359321)
    function getDisplayName( $at = '' ) {
        $header = [ 'Authorization: OAuth ' . $at ];
        $data = $this->get( 'user', $header );
        return ( isset( $data['display_name'] ) ? $data['display_name'] : NULL );
    }
    
    // Requires access token with user_read scope
    function getUserIDFromAT( $at = '' ) {
        $header = [ 'Authorization: OAuth ' . $at ];
        $data = $this->get( 'user', $header );
        return ( isset( $data['_id'] ) ? $data['_id'] : NULL );
    }
    
    // Gets partner status of $name (channel name).
    function isPartner( $name = '' ) {
        $data = $this->get( 'channels/' . $name );
        return ( isset( $data['error'] ) ? NULL : $data['partner'] );
    }
    
    // 401 = invalid access token/no access, 404 = not subscribed, 100 = subscribed.
    function isSubscribed( $at = '', $name = '', $chan = '' ) {
        $header = [ 'Authorization: OAuth ' . $at ];
        $data = $this->get( 'users/' . $name . '/subscriptions/' . $chan, $header );
        if( isset( $data['created_at'] ) ) {
            return 100;
        } else {
            return $data['status'];
        }
    }
    
    // Does not require access token, only the name (usually lowercase) itself. See: getDisplayName().
    function getDisplayNameNoAT( $name = '' ) {
        $data = $this->get( 'users/' . $name );
        return ( isset( $data['display_name'] ) ? $data['display_name'] : false );
    }
    
}
?>
