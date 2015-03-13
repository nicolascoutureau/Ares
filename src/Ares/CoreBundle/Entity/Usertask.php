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
    
  /**
   * @ORM\Column(name="assignation", type="boolean")
   */    
    private $assignation = true;
    /**
     * @ORM\Column(name="date_invoke", type="datetime", nullable=true)
     */
    private $dateinvoke;
    /**
     * @ORM\Column(name="date_revoke", type="datetime", nullable=true)
     */
    private $daterevoke;
    
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





    /**
     * Set assignation
     *
     * @param boolean $assignation
     * @return Usertask
     */
    public function setAssignation($assignation)
    {
        $this->assignation = $assignation;

        return $this;
    }

    /**
     * Get assignation
     *
     * @return boolean 
     */
    public function getAssignation()
    {
        return $this->assignation;
    }

    /**
     * Set deadline
     *
     * @param \DateTime $deadline
     * @return Usertask
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline
     *
     * @return \DateTime 
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set datecreated
     *
     * @param \DateTime $datecreated
     * @return Usertask
     */
    public function setDatecreated($datecreated)
    {
        $this->datecreated = $datecreated;

        return $this;
    }

    /**
     * Get datecreated
     *
     * @return \DateTime 
     */
    public function getDatecreated()
    {
        return $this->datecreated;
    }

    /**
     * Set dateinvoke
     *
     * @param \DateTime $dateinvoke
     * @return Usertask
     */
    public function setDateinvoke($dateinvoke)
    {
        $this->dateinvoke = $dateinvoke;

        return $this;
    }

    /**
     * Get dateinvoke
     *
     * @return \DateTime 
     */
    public function getDateinvoke()
    {
        return $this->dateinvoke;
    }

    /**
     * Set daterevoke
     *
     * @param \DateTime $daterevoke
     * @return Usertask
     */
    public function setDaterevoke($daterevoke)
    {
        $this->daterevoke = $daterevoke;

        return $this;
    }

    /**
     * Get daterevoke
     *
     * @return \DateTime 
     */
    public function getDaterevoke()
    {
        return $this->daterevoke;
    }
}
