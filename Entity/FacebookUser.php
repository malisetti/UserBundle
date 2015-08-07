<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class FacebookUser extends SocialUser
{
    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="facebook_user")
     * @ORM\JoinColumn(name="app_user_id", referencedColumnName="id")
     */
    private $app_user;

    /**
     * Set app_user.
     *
     * @param \UserBundle\Entity\User $appUser
     *
     * @return FacebookUser
     */
    public function setAppUser(\UserBundle\Entity\User $appUser = null)
    {
        $this->app_user = $appUser;

        return $this;
    }

    /**
     * Get app_user.
     *
     * @return \UserBundle\Entity\User
     */
    public function getAppUser()
    {
        return $this->app_user;
    }
}
