<?php

// src/Ares/CoreBundle/Services/DateTime.php

namespace Ares\CoreBundle\Services;

class DateTime
{

  /**
   * Convertie des secondes en chaine H:i:s
   *
   * @param string $seconds
   * @return string
   */
  public function secondsToTime($seconds)
  {
    $hours = floor($seconds / 3600);
    $mins = floor(($seconds - ($hours * 3600)) / 60);
    $secs = floor($seconds % 60);
    
    if (strlen($hours) === 1) {
      $hours = '0' . $hours;
    }
    
    if (strlen($mins) === 1) {
      $mins = '0' . $mins;
    }
    
    if (strlen($secs) === 1) {
      $secs = '0' . $secs;
    }    
    
    $time = $hours . ':' . $mins . ':' . $secs;
    
    return $time;
  }

}
