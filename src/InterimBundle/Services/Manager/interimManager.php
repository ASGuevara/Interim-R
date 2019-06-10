<?php
namespace InterimBundle\Services\Manager;

use Doctrine\ORM\EntityManager;


class interimManager
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getNoteByInterim($id)
    {
        return $this->em->getRepository('InterimBundle\Entity\Interim')->findGlobalNoteByInterim($id);
    }
}