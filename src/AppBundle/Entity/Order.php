<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Order.
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 *
 * @ORM\Table(name="order_registration")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 */
class Order
{
    /**
     * @var int order id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime Date of the visit
     *
     * @ORM\Column(name="date_visit", type="date")
     */
    private $dateVisit;

    /**
     * @var string Type of ticket, day or half-day
     *
     * @ORM\Column(name="type_ticket", type="string")
     */
    private $typeTicket;

    /**
     * @var string Email of register
     *
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @var string Unique number of each booking
     *
     * @ORM\Column(name="order_number", type="string", length=30)
     */
    private $orderNumber;

    /**
     * @var string Number of tickets into each order
     *
     * @ORM\Column(name="number_tickets", type="string")
     */
    private $numberTickets;

    /**
     * @var string Total price for each booking
     *
     * @ORM\Column(name="total_price", type="string")
     */
    private $totalPrice;

    /**
     * @var bool Indicate if order is valid
     *
     * @ORM\Column(name="valid", type="boolean")
     */
    private $valid;

    /**
     * @var bool Indicate if order is for half-day or day
     *
     * @ORM\Column(name="reduction", type="boolean", nullable=true)
     */
    private $reduction;

    /**
     * @var \DateTime Indicade date of order
     *
     * @ORM\Column(name="date_order", type="date")
     */
    private $dateOrder;

    /**
     * @var Ticket[] Contains one or many tickets
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
     * Return order id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return date of visit.
     *
     * @return \DateTime
     */
    public function getDateVisit()
    {
        return $this->dateVisit;
    }

    /**
     * Define date of visit.
     *
     * @param \DateTime $dateVisit Date of visit
     *
     * @return Order
     */
    public function setDateVisit(\DateTime $dateVisit)
    {
        $this->dateVisit = $dateVisit;

        return $this;
    }

    /**
     * Return type of ticket for order.
     *
     * @return string
     */
    public function getTypeTicket()
    {
        return $this->typeTicket;
    }

    /**
     * Define type of ticket for order.
     *
     * @param string $typeTicket Type of ticket
     *
     * @return Order
     */
    public function setTypeTicket($typeTicket)
    {
        $this->typeTicket = $typeTicket;

        return $this;
    }

    /**
     * Return email register.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Define email register.
     *
     * @param string $email Email register for order
     *
     * @return Order
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Return unique number generate at the end of order.
     *
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Define unique number.
     *
     * @param string $orderNumber Unique number generate
     *
     * @return Order
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Return number of ticket for order.
     *
     * @return string
     */
    public function getNumberTickets()
    {
        return $this->numberTickets;
    }

    /**
     * Set number of ticket for order.
     *
     * @param string $numberTickets Number of tickets for order
     *
     * @return Order
     */
    public function setNumberTickets($numberTickets)
    {
        $this->numberTickets = $numberTickets;

        return $this;
    }

    /**
     * Return total price for order.
     *
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Define total price for order.
     *
     * @param string $totalPrice Total price for order
     *
     * @return Order
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @param bool $valid
     *
     * @return Order
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * @return bool
     */
    public function isReduction()
    {
        return $this->reduction;
    }

    /**
     * @param bool $reduction
     *
     * @return Order
     */
    public function setReduction($reduction)
    {
        $this->reduction = $reduction;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateOrder()
    {
        return $this->dateOrder;
    }

    /**
     * @param \DateTime $dateOrder
     *
     * @return Order
     */
    public function setDateOrder(\DateTime $dateOrder)
    {
        $this->dateOrder = $dateOrder;

        return $this;
    }

    /**
     * Return all tickets from order.
     *
     * @return Ticket[]
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Add a ticket to order.
     *
     * @param Ticket $ticket Ticket to add to order
     *
     * @return $this
     */
    public function addTicket(Ticket $ticket)
    {
        $this->tickets->add($ticket);

        return $this;
    }

    /**
     * Remove a ticket from order.
     *
     * @param Ticket $ticket Ticket to remove to order
     */
    public function removeTicket(Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }
}
