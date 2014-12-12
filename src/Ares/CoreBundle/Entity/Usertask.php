<?php
namespace Ares\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity(repositoryClass="Ares\CoreBundle\Entity\UsertaskRepository")
 */
class Usertask
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\OneToMany(targetEntity="Ares\CoreBundle\Entity\Chronometer", mappedBy="usertask")
     * @ORM\JoinColumn(nullable=true)
     */
    private $chronometers;
    /**
     * @ORM\ManyToOne(targetEntity="Ares\CoreBundle\Entity\Task", inversedBy="usertasks")
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id", nullable=false)
     */
    private $task;
    /**
     * @ORM\ManyToOne(targetEntity="Ares\CoreBundle\Entity\User", inversedBy="usertasks")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;
    public function __construct() {
        $this->chronometers = new ArrayCollection();
    }
    public function addChronometer(\Ares\CoreBundle\Entity\Chronometer $chronometer)
    {
        $this->chronometers[] = $chronometer;
        $chronometer->setUsertask($this);
        return $this;
    }
    public function removeChronometer(\Ares\CoreBundle\Entity\Chronometer $chronometer)
    {
        $this->chronometers->removeElement($chronometer);
        return $this;
    }
    public function getChronometers(){
        return $this->chronometers;
    }
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param mixed $task
     */
    public function setTask($task)
    {
        $this->task = $task;
    }
    /**
     * @return mixed
     */
    public function getTask()
    {
        return $this->task;
    }
    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }


}