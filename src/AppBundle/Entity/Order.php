<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Order
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 *
 * @ORM\Table(name="order")
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
     * @Assert\Date(
     *     message="Vous devez choisir une date"
     * )
     *
     * @ORM\Column(name="date_visit", type="datetime")
     */
    private $dateVisit;

    /**
     * @var string Type of ticket, day or half-day
     *
     * @Assert\NotBlank(
     *     message="Vous devez choisir un type de ticket"
     * )
     *
     * @ORM\Column(name="type_ticket", type="string")
     */
    private $typeTicket;

    /**
     * @var string Email of register
     *
     * @Assert\NotBlank(
     *     message="Veuillez saisir une adresse mail"
     * )
     * @Assert\Email(
     *     message="L'adresse mail contient des caractères non autorisés"
     * )
     * @Assert\Length(
     *     max="100",
     *     maxMessage="L'adresse mail saisie ne peut pas faire plus de 100 caractères"
     * )
     *
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="order_number", type="string", length=30)
     */
    private $orderNumber;

    /**
     * @var string Unique number of each order
     *
     * @Assert\NotBlank(
     *     message="Vous devez choisir le nombre de ticket souhaités"
     * )
     *
     * @ORM\Column(name="number_tickets", type="string")
     */
    private $numberTickets;

    /**
     * @var string Total price for each order
     *
     * @ORM\Column(name="total_price", type="string")
     */
    private $totalPrice;

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
     * Return order id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return date of visit
     *
     * @return \DateTime
     */
    public function getDateVisit()
    {
        return $this->dateVisit;
    }

    /**
     * Define date of visit
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
     * Return type of ticket for order
     *
     * @return string
     */
    public function getTypeTicket()
    {
        return $this->typeTicket;
    }

    /**
     * Define type of ticket for order
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
     * Return email register
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Define email register
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
     * Return unique number generate at the end of order
     *
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Define unique number
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
     * Return number of ticket for order
     *
     * @return string
     */
    public function getNumberTickets()
    {
        return $this->numberTickets;
    }

    /**
     * Set number of ticket for order
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
     * Return total price for order
     *
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Define total price for order
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
     * Return all tickets from order
     *
     * @return Ticket[]
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Add a ticket to order
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
     * Remove a ticket from order
     *
     * @param Ticket $ticket Ticket to remove to order
     */
    public function removeTicket(Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }
}
