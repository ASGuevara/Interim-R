<?php

namespace InterimBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * MissionMonitor
 *
 * @ORM\Table(name="mission_monitor")
 * @ORM\Entity(repositoryClass="InterimBundle\Repository\MissionMonitorRepository")
 */
class MissionMonitor
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @OneToOne(targetEntity="Interim")
     * @JoinColumn(name="interim_id", referencedColumnName="id")
     */
    private $interim;

    /**
     * @var string
     *
     * @OneToOne(targetEntity="Contract")
     * @JoinColumn(name="contract_id", referencedColumnName="id")
     */
    private $contract;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer")
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string")
     */
    private $status;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set interim
     *
     * @param Interim $interim
     *
     * @return MissionMonitor
     */
    public function setInterim($interim)
    {
        $this->interim = $interim;

        return $this;
    }

    /**
     * Get interim
     *
     * @return Interim
     */
    public function getInterim()
    {
        return $this->interim;
    }

    /**
     * Set contract
     *
     * @param Contract $contract
     *
     * @return MissionMonitor
     */
    public function setContract($contract)
    {
        $this->contract = $contract;

        return $this;
    }

    /**
     * Get contract
     *
     * @return Contract
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * Set note
     *
     * @param integer $note
     *
     * @return MissionMonitor
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set status
     *
     * @param String $status
     *
     * @return MissionMonitor
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return String
     */
    public function getStatus()
    {
        return $this->status;
    }
}

