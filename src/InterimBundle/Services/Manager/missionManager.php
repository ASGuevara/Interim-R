<?php
namespace InterimBundle\Services\Manager;

use Doctrine\ORM\EntityManager;


class missionManager
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getMissionByContract($contract)
    {
        return $this->em->getRepository('InterimBundle\Entity\MissionMonitor')->findOneBy(array('contract' => $contract->getId(),
                                                                                                'interim'  => $contract->getInterim()->getId()));
    }
}