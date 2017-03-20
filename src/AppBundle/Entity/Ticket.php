<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Ticket
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TicketRepository")
 */
class Ticket
{
    const
        /** @var int Normal ticket price */
        NORMAL_RATE = 16,
        /** @var int Children ticket price */
        CHILD_RATE = 8,
        /** @var int Senior ticket price */
        SENIOR_RATE = 12,
        /** @var int Reduced ticket price */
        REDUCED_RATE = 10;

    /**
     * @var int Ticket id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string Firstname of ticket holder
     *
     * @ORM\Column(name="firstname", type="string", length=38)
     */
    private $firstname;

    /**
     * @var string Lastname of ticket holder
     *
     * @ORM\Column(name="lastname", type="string", length=38)
     */
    private $lastname;

    /**
     * @var \DateTime Birthdate of ticket holder
     *
     * @ORM\Column(name="birth_date", type="datetime")
     */
    private $birthDate;

    /**
     * @var int Price of ticket holder
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string Nationality of ticket owner
     *
     * @ORM\Column(name="nationality", type="string", length=45)
     */
    private $nationality;

    /**
     * @var Order Id of the order attached to the ticket
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Order", inversedBy="tickets")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $order;

    /**
     * Return ticket id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return firstname of the ticket holder
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Define firstname of the ticket holder
     *
     * @param string $firstname Firstname of the ticket holder
     *
     * @return Ticket
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Return lastname of the ticket holder
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Define lastname of the ticket holder
     *
     * @param string $lastname Lastname of the ticket holder
     *
     * @return Ticket
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Return birthdate of the ticket holder
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Define birthdate of the ticket holder
     *
     * @param \DateTime $birthDate Birthdate of the ticket holder
     *
     * @return Ticket
     */
    public function setBirthDate(\DateTime $birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Return price of the ticket holder
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Define price of the ticket holder
     *
     * @param int $price Price of the ticket holder
     *
     * @return Ticket
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param string $nationality
     *
     * @return Ticket
     */
    public function setNationality(string $nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Return order id attached to the ticket
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Define order id attached to the ticket
     *
     * @param Order $order Order id attache to the ticket
     *
     * @return Ticket
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;

        return $this;
    }
}
