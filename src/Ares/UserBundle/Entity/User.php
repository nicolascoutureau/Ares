<?php

namespace Ares\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="Ares\CoreBundle\Entity\Usertask", mappedBy="user", cascade={"all"} , orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     */    
    private $usertasks;    

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add usertasks
     *
     * @param \Ares\CoreBundle\Entity\Usertask $usertasks
     * @return User
     */
    public function addUsertask(\Ares\CoreBundle\Entity\Usertask $usertasks)
    {
        $this->usertasks[] = $usertasks;

        return $this;
    }

    /**
     * Remove usertasks
     *
     * @param \Ares\CoreBundle\Entity\Usertask $usertasks
     */
    public function removeUsertask(\Ares\CoreBundle\Entity\Usertask $usertasks)
    {
        $this->usertasks->removeElement($usertasks);
    }

    /**
     * Get usertasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsertasks()
    {
        return $this->usertasks;
    }
}
