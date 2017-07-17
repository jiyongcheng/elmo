<?php

namespace AppBundle\Service;

use AppBundle\Entity\Trace;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;

class UserRecorder
{
    private $logger;
    private $em;

    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->em = $em;
    }

    public function recordLogin($user)
    {
        $trace = new Trace();
        $trace->setUserId($user->getId());
        $currentTime = new \DateTime();
        $trace->setCreatedAt($currentTime);
        $this->em->persist($trace);
        $this->em->flush();
    }
}