<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use FOS\UserBundle\Doctrine\UserManager;
use UserBundle\Helper\UserLoginHelper;
use UserBundle\Helper\OAuthFlowHelper;
use League\OAuth2\Client\Provider\FacebookUser as FBUser;
use UserBundle\Entity\FacebookUser;
use UserBundle\Entity\SocialUser;
use UserBundle\Entity\User as AppUser;

class OAuthSecurityController
{
    const OAUTH2_STATE = 'oauth2state';

    private $userManager;
    private $fbAuth;
    private $userLoginHelper;
    private $router;

    public function __construct(OAuthFlowHelper $fbAuth, UserManager $userManager, UserLoginHelper $userLoginHelper, RouterInterface $router)
    {
        $this->fbAuth = $fbAuth;
        $this->userManager = $userManager;
        $this->userLoginHelper = $userLoginHelper;
        $this->router = $router;
    }

    public function facebookLoginAction(Request $request)
    {
        $scope = array('email', 'user_hometown', 'user_about_me');
        $session = $request->getSession();
        $this->fbAuth->redirectUri = $this->router->generate('facebook_login', array(), true);
        $this->fbAuth->scopes = $scope;
        $provider = $this->fbAuth->getProvider();
        if (!$request->query->has('code')) {
            $authUrl = $provider->getAuthorizationUrl(array('scope' => $scope));
            $session->set(self::OAUTH2_STATE, $provider->getState());

            return new RedirectResponse($authUrl);
        } elseif (empty($request->query->get('state')) || $request->query->get('state') !== $session->get(self::OAUTH2_STATE)) {
            $session->remove(self::OAUTH2_STATE);
            
            throw new \RuntimeException('Invalid state');
        } else {
            try {
                $token = $this->fbAuth->getAccessToken($provider, $request->query->get('code'));
                $userDetails = $provider->getResourceOwner($token);
                $email = $userDetails->getEmail();
                $user = $this->userManager->findUserByEmail($email);
                if ($user) {
                    $fbUser = $user->getFacebookUser();
                    if (!$fbUser) {
                        $fbUser = $this->createSocialUser($userDetails, new FacebookUser());
                        $fbUser->setAppUser($user);
                        $user->setFacebookUser($fbUser);
                    }
                    //update access token
                    $tokenExpiry = new \DateTime();
                    $tokenExpiry->setTimestamp($token->getExpires());
                    $user->setFacebookAccessToken($token->getToken())
                         ->setFacebookAccessTokenExpires($tokenExpiry)
                         ->setLoggedInWith(AppUser::LOGGEDIN_WITH_FACEBOOK);
                } else {
                    $tokenExpiry = new \DateTime();
                    $tokenExpiry->setTimestamp($token->getExpires());
                    //create a user
                    $user = $this->userManager->createUser();

                    $user = $this->createAppUser($userDetails, $user);
                    $user->setFacebookAccessToken($token->getToken());
                    $user->setFacebookAccessTokenExpires($tokenExpiry);

                    $fbUser = $this->createSocialUser($userDetails, new FacebookUser());
                    $user->setFacebookUser($fbUser);
                    $fbUser->setAppUser($user);
                    $user->setLoggedInWith(AppUser::LOGGEDIN_WITH_FACEBOOK);
                }
                $this->userManager->updateUser($user);
                //login
                $this->userLoginHelper->interactiveLogin($user, $request);
            } catch (\Exception $e) {
                throw $e;
            }
            return new RedirectResponse($this->router->generate('homepage'));
        }
    }
    
    protected function createAppUser(FBUser $userDetails, AppUser $user)
    {
        if (!$user) {
            $user = new AppUser();
        }
        $user->setFirstName($userDetails->getFirstName())
                ->setLastName($userDetails->getLastName())
                ->setUsername($userDetails->getEmail())
                ->setEmail($userDetails->getEmail())
                ->setPlainPassword(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36))
                ->setIsPasswordValid(false)
                ->addRole(AppUser::ROLE_DEFAULT)
                ->setEnabled(true);

        return $user;
    }

    protected function createSocialUser(FBUser $userDetails, SocialUser $user)
    {
        $user->setFirstName($userDetails->getFirstName())
                ->setLastName($userDetails->getLastName())
                ->setGender($userDetails->getGender())
                ->setImageUrl($userDetails->getPictureUrl())
                ->setLocale($userDetails->getLocale())
                ->setLocation($userDetails->getHometown())
                ->setName($userDetails->getName())
                ->setUid($userDetails->getId())
                ->setUrls($userDetails->getLink())
                ->setEmail($userDetails->getEmail())
                ->setDescription($userDetails->getBio());

        return $user;
    }
}
