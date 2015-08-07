<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="AppUsers")
 */
class User extends BaseUser
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const LOGGEDIN_WITH_FACEBOOK = 'facebook';
    const LOGGEDIN_WITH_GOOGLE = 'google';
    const LOGGEDIN_WITH_APP = 'app';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", name="phone_number", length=20, nullable=true)
     */
    private $phone_number;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $google_access_token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $google_access_token_expires;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $facebook_access_token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $facebook_access_token_expires;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_password_valid;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    protected $logged_in_with;

    /**
     * @ORM\OneToOne(targetEntity="FacebookUser", cascade={"persist", "remove"}, mappedBy="app_user")
     */
    protected $facebook_user;

    /**
     * @ORM\OneToOne(targetEntity="GoogleUser", cascade={"persist", "remove"}, mappedBy="app_user")
     */
    protected $google_user;

    public function getName()
    {
        return ucwords($this->first_name.' '.$this->last_name);
    }

    public function __construct()
    {
        parent::__construct();
    }

    public function isPasswordValid()
    {
        return $this->is_password_valid;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
        $this->username = $email;
        
        return $this;
    }

    /**
     * Set first_name.
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get first_name.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name.
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get last_name.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set google_access_token.
     *
     * @param string $googleAccessToken
     *
     * @return User
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->google_access_token = $googleAccessToken;

        return $this;
    }

    /**
     * Get google_access_token.
     *
     * @return string
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * Set google_access_token_expires.
     *
     * @param \DateTime $googleAccessTokenExpires
     *
     * @return User
     */
    public function setGoogleAccessTokenExpires($googleAccessTokenExpires)
    {
        $this->google_access_token_expires = $googleAccessTokenExpires;

        return $this;
    }

    /**
     * Get google_access_token_expires.
     *
     * @return \DateTime
     */
    public function getGoogleAccessTokenExpires()
    {
        return $this->google_access_token_expires;
    }

    /**
     * Set facebook_access_token.
     *
     * @param string $facebookAccessToken
     *
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebook_access_token = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebook_access_token.
     *
     * @return string
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }

    /**
     * Set facebook_access_token_expires.
     *
     * @param \DateTime $facebookAccessTokenExpires
     *
     * @return User
     */
    public function setFacebookAccessTokenExpires($facebookAccessTokenExpires)
    {
        $this->facebook_access_token_expires = $facebookAccessTokenExpires;

        return $this;
    }

    /**
     * Get facebook_access_token_expires.
     *
     * @return \DateTime
     */
    public function getFacebookAccessTokenExpires()
    {
        return $this->facebook_access_token_expires;
    }

    /**
     * Set is_password_valid.
     *
     * @param bool $isPasswordValid
     *
     * @return User
     */
    public function setIsPasswordValid($isPasswordValid)
    {
        $this->is_password_valid = $isPasswordValid;

        return $this;
    }

    /**
     * Get is_password_valid.
     *
     * @return bool
     */
    public function getIsPasswordValid()
    {
        return $this->is_password_valid;
    }

    /**
     * Set logged_in_with.
     *
     * @param string $loggedInWith
     *
     * @return User
     */
    public function setLoggedInWith($loggedInWith)
    {
        $this->logged_in_with = $loggedInWith;

        return $this;
    }

    /**
     * Get logged_in_with.
     *
     * @return string
     */
    public function getLoggedInWith()
    {
        return $this->logged_in_with;
    }

    /**
     * Set facebook_user.
     *
     * @param \UserBundle\Entity\FacebookUser $facebookUser
     *
     * @return User
     */
    public function setFacebookUser(\UserBundle\Entity\FacebookUser $facebookUser = null)
    {
        $this->facebook_user = $facebookUser;

        return $this;
    }

    /**
     * Get facebook_user.
     *
     * @return \UserBundle\Entity\FacebookUser
     */
    public function getFacebookUser()
    {
        return $this->facebook_user;
    }

    /**
     * Set google_user.
     *
     * @param \UserBundle\Entity\GoogleUser $googleUser
     *
     * @return User
     */
    public function setGoogleUser(\UserBundle\Entity\GoogleUser $googleUser = null)
    {
        $this->google_user = $googleUser;

        return $this;
    }

    /**
     * Get google_user.
     *
     * @return \UserBundle\Entity\GoogleUser
     */
    public function getGoogleUser()
    {
        return $this->google_user;
    }

    /**
     * Set phoneNumber.
     *
     * @param string $phoneNumber
     *
     * @return User
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phone_number = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber.
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }
}
