<?php

namespace Ares\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AresUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }    
}
