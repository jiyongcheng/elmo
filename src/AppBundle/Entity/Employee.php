<?php

namespace AppBundle\Entity;

use AppBundle\Annotation\InternalUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @InternalUser(type=1)
 */
class Employee extends User
{

}