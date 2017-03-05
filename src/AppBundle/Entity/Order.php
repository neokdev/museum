<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Ticket;

/**
 * Class Order
 *
 * @ORM\Table(name="order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 */
class Order
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_visit", type="datetime")
     */
    private $dateVisit;

    /**
     * @var string
     *
     * @ORM\Column(name="type_ticket", type="string")
     */
    private $typeTicket;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="uniq_code", type="string", length=30)
     */
    private $uniqCode;

    /**
     * @var Ticket[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket", cascade={"all"}, mappedBy="order")
     */
    private $tickets;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDateVisit()
    {
        return $this->dateVisit;
    }

    /**
     * @param \DateTime $dateVisit
     *
     * @return Order
     */
    public function setDateVisit(\DateTime $dateVisit)
    {
        $this->dateVisit = $dateVisit;

        return $this;
    }

    /**
     * @return string
     */
    public function getTypeTicket()
    {
        return $this->typeTicket;
    }

    /**
     * @param string $typeTicket
     *
     * @return Order
     */
    public function setTypeTicket($typeTicket)
    {
        $this->typeTicket = $typeTicket;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Order
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getUniqCode()
    {
        return $this->uniqCode;
    }

    /**
     * @param string $uniqCode
     *
     * @return Order
     */
    public function setUniqCode($uniqCode)
    {
        $this->uniqCode = $uniqCode;

        return $this;
    }

    /**
     * @return Ticket[]
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * @param Ticket $ticket
     *
     * @return $this
     */
    public function addTicket(Ticket $ticket)
    {
        $this->tickets->add($ticket);

        return $this;
    }

    /**
     * @param Ticket $ticket
     */
    public function removeTicket(Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }
}
