<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="SocialUsers")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"google_user" = "GoogleUser", "facebook_user" = "FacebookUser"})
 */
abstract class SocialUser
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", name="first_name", length=256, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", name="image_url", length=256, nullable=true)
     */
    private $imageUrl;

    /**
     * @ORM\Column(type="string", name="last_name", length=256, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $locale;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    private $nickname;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $uid;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $urls;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return SocialUser
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return SocialUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return SocialUser
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set gender.
     *
     * @param string $gender
     *
     * @return SocialUser
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set imageUrl.
     *
     * @param string $imageUrl
     *
     * @return SocialUser
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl.
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return SocialUser
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set locale.
     *
     * @param string $locale
     *
     * @return SocialUser
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set location.
     *
     * @param array $location
     *
     * @return SocialUser
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location.
     *
     * @return array
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return SocialUser
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nickname.
     *
     * @param string $nickname
     *
     * @return SocialUser
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname.
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set uid.
     *
     * @param string $uid
     *
     * @return SocialUser
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid.
     *
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set urls.
     *
     * @param array $urls
     *
     * @return SocialUser
     */
    public function setUrls($urls)
    {
        $this->urls = is_array($urls) ? $urls : array($urls);

        return $this;
    }

    /**
     * Get urls.
     *
     * @return array
     */
    public function getUrls()
    {
        return $this->urls;
    }
}
