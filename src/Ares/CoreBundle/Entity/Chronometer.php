<?php
namespace Ares\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Chronometer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ares\CoreBundle\Entity\ChronometerRepository")
 */
class Chronometer
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
     * @ORM\ManyToOne(targetEntity="Ares\CoreBundle\Entity\Usertask", inversedBy="chronometers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usertask;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdate", type="datetime")
     */
    private $startdate;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stopdate", type="datetime", nullable=true)
     */
    private $stopdate =  null;
    public function __construct()
    {
        $this->startdate = new \Datetime();
    }
    /**
     * @param mixed $usertask
     */
    public function setUsertask($usertask)
    {
        $this->usertask = $usertask;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getUsertask()
    {
        return $this->usertask;
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
     * Set startdate
     *
     * @param \DateTime $startdate
     * @return Chronometer
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;
        return $this;
    }
    /**
     * Get startdate
     *
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }
    /**
     * Set stopdate
     *
     * @param \DateTime $stopdate
     * @return Chronometer
     */
    public function setStopdate($stopdate)
    {
        $this->stopdate = $stopdate;
        return $this;
    }
    /**
     * Get stopdate
     *
     * @return \DateTime
     */
    public function getStopdate()
    {
        return $this->stopdate;
    }
}