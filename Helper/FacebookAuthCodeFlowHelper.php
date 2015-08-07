<?php

namespace UserBundle\Helper;

use Facebook\Facebook;
use League\OAuth2\Client\Provider\Facebook as FacebookProvider;

class FacebookAuthCodeFlowHelper extends OAuthFlowHelper
{
    public $graphApiVersion;

    public function __construct($clientId, $clientSecret, $redirectUri = '', array $scopes = array(), $graphApiVersion = Facebook::DEFAULT_GRAPH_VERSION)
    {
        parent::__construct($clientId, $clientSecret, $redirectUri, $scopes);
        $this->graphApiVersion = $graphApiVersion;
    }

    public function getProvider()
    {
        $provider = new FacebookProvider(array(
            'clientId' => "{$this->clientId}",
            'clientSecret' => "{$this->clientSecret}",
            'redirectUri' => $this->redirectUri,
            'scopes' => $this->scopes,
            'graphApiVersion' => $this->graphApiVersion,
        ));

        return $provider;
    }
}
