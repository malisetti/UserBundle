<?php

namespace UserBundle\Helper;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Grant\RefreshToken;
use League\OAuth2\Client\Provider\Facebook;

abstract class OAuthFlowHelper
{
    protected $clientId;
    protected $clientSecret;
    public $redirectUri;
    public $scopes;

    public function __construct($clientId, $clientSecret, $redirectUri = '', array $scopes = array())
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
        $this->scopes = $scopes;
    }

    abstract public function getProvider();

    public function getAccessToken(AbstractProvider $provider, $code)
    {
        $token = $provider->getAccessToken('authorization_code', array('code' => $code));
        $refreshToken = $token->getRefreshToken();
        if (!empty($refreshToken) && !$provider instanceof Facebook) {
            $grant = new RefreshToken();
            $token = $provider->getAccessToken($grant, array('refresh_token' => $refreshToken));
        }
        
        if($provider instanceof Facebook){
            $longLivedToken = null;
            try {
                $longLivedToken = $provider->getLongLivedAccessToken('short-lived-access-token');
            } catch (\Exception $e) {
            }
            
            $token = $longLivedToken ?: $token;
        }

        return $token;
    }

    public function getUserDetails(AbstractProvider $provider, AccessToken $token)
    {
        try {
            $userDetails = $provider->getResourceOwner($token);

            return $userDetails;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
