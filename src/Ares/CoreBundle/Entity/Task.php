<?php
namespace Ares\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Task
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ares\CoreBundle\Entity\TaskRepository")
 */
class Task
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    /**
     * @ORM\Column(name="deadline", type="datetime")
     */
    private $deadline;
    /**
     * @ORM\Column(name="datecreated", type="datetime")
     */
    private $datecreated;
    /**
     * @ORM\Column(name="estimated_time", type="integer")
     */
    private $estimated_time;
    /**
     * @ORM\Column(name="state", type="string")
     */
    private $state;
    /**
     * @ORM\Column(name="timespent", type = "integer")
     */
    private $timespent;
    /**
     * @ORM\OneToMany(targetEntity="Ares\CoreBundle\Entity\Usertask", mappedBy="task", cascade={"all"} , orphanRemoval=true)
     */
    private $usertasks;
    private $users;
    public function __construct()
    {
        $this->datecreated = new \Datetime();
        $this->usertasks = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->timespent = 0;
    }
    public function __toString()
    {
        return $this->name;
    }
    public function getUsertasks()
    {
        return $this->usertasks;
    }
    public function getUsers()
    {
        $users = new ArrayCollection();
        foreach($this->usertasks as $ut)
        {
            if(!$users->contains($ut->getUser())){
                $users[] = $ut->getUser();
            }
        }
        return $users;
    }
    public function setUsers($users)
    {
        foreach($users as $u)
        {
            $ut = new Usertask();
            $ut->setTask($this);
            $ut->setUser($u);
            $this->addUsertask($ut);
        }
    }
    public function getTask()
    {
        return $this;
    }
    public function addUsertask($Usertask)
    {
        $this->usertasks[] = $Usertask;
    }
    public function removeUsertask($usertask)
    {
        return $this->usertasks->removeElement($usertask);
    }
    
    /**
     * @param mixed $datecreated
     */
    public function setDatecreated($datecreated)
    {
        $this->datecreated = $datecreated;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getDatecreated()
    {
        return $this->datecreated;
    }
    /**
     * @param mixed $deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getDeadline()
    {
        return $this->deadline;
    }
    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @param mixed $estimated_time
     */
    public function setEstimatedTime($estimated_time)
    {
        $this->estimated_time = $estimated_time;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getEstimatedTime()
    {
        return $this->estimated_time;
    }
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }
    /**
     * @param mixed $timespent
     */
    public function setTimespent($timespent)
    {
        $this->timespent = $timespent;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getTimespent()
    {
        return $this->timespent;
    }
}