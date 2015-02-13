<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/02/2015
 * Time: 10:49
 */

namespace Ares\CoreBundle\Twig;

class SecondsToTime extends \Twig_Extension
{

    private $dateTime;

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('toTime', array($this, 'toTime')),
        );
    }

    public function __construct($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function toTime($seconds)
    {
        return $this->dateTime->secondsToTime($seconds);
    }

    public function getName()
    {
        return 'toTime';
    }
}