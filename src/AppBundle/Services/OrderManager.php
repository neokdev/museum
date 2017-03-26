<?php

namespace AppBundle\Services;

use AppBundle\Entity\Order;
use AppBundle\Entity\Ticket;
use AppBundle\Form\Type\OrderType;
use AppBundle\Form\Type\SearchOrderType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class OrderManager
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class OrderManager
{
    /** @var FormFactory Service to create form */
    private $formFactory;

    /** @var EntityManager Service to interact with repository */
    private $em;

    /** @var Session Service to manage session */
    private $session;

    /** @var MailerService Service to send email */
    private $mailerService;

    /**
     * OrderManager constructor.
     *
     * @param FormFactory   $formFactory   Service to create form
     * @param EntityManager $em            Service to interact with repository
     * @param Session       $session       Service to manage session
     * @param MailerService $mailerService Service to send email
     */
    public function __construct(
        FormFactory $formFactory,
        EntityManager $em,
        Session $session,
        MailerService $mailerService
    ) {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->session = $session;
        $this->mailerService = $mailerService;
    }

    /**
     * Start booking of order
     *
     * @param Request $request
     *
     * @return FormView|RedirectResponse
     */
    public function startOrder(Request $request)
    {
        $order = new Order();
        $order->setDateOrder(new \DateTime());

        $form = $this->formFactory->create(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();

            $numberTickets = $datas->getNumberTickets();
            try {
                if (!$this->isEnoughtTicketsForSelectedDay($numberTickets, $datas->getDateVisit())) {
                    throw new \Exception(
                        sprintf(
                            'Il n\'y a pas assez de billets disponible pour le jour demandé: %s',
                            $datas->getDateVisit()->format('d-m-Y')
                        )
                    );
                }

                while ($numberTickets > 0) {
                    $order->addTicket(new Ticket());
                    $numberTickets--;
                }

                $this->session->set('order', $order);
                $this->session->getFlashBag()->add(
                    'success',
                    'La commande a commencé...'
                );

                $response = new RedirectResponse('/ticket');

                return $response->send();
            } catch (\Exception $exception) {
                $this->session->getFlashBag()->add(
                    'error',
                    $exception->getMessage()
                );
            }
        }

        return $form->createView();
    }

    /**
     * Return a form to search an specific order by email
     *
     * @param Request $request
     *
     * @return FormView
     */
    public function searchOrder(Request $request)
    {
        $form = $this->formFactory->create(SearchOrderType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailSearch = $form->getData();

            $order = $this->em->getRepository(Order::class)->findOneBy(
                [
                    'email' => $emailSearch->getEmail(),
                ]
            );

            try {
                if (!$order) {
                    throw new EntityNotFoundException(
                        sprintf(
                            'L\'adresse email indiquée \'%s\' ne correspond pas à une commande',
                            $emailSearch->getEmail()
                        )
                    );
                }

                $this->session->getFlashBag()->add(
                    'success',
                    sprintf(
                        'Votre commande a bien été trouvée, vous allez recevoir vos billets à l\'adresse %s',
                        $emailSearch->getEmail()
                    )
                );

                //TODO Modale confirmation envoi mail à faire

                $this->mailerService->sendTickets(
                    'E-Billet - Musée du Louvre - N°'.$order->getOrderNumber(),
                    $emailSearch->getEmail(),
                    'email/confirm_order.html.twig',
                    $order
                );
            } catch (EntityNotFoundException $exception) {
                $this->session->getFlashBag()->add(
                    'error',
                    $exception->getMessage()
                );
            }
        }

        return $form->createView();
    }

    /**
     * Checks if there are enough tickets available for the requested day
     *
     * @param int       $numberTickets Number of tickets selected
     * @param \DateTime $date
     *
     * @return bool
     */
    private function isEnoughtTicketsForSelectedDay($numberTickets, \DateTime $date)
    {
        $remainingTickets = 0 - $this->getTicketsRegistered($date);

        if ($numberTickets > $remainingTickets) {
            return false;
        }

        return true;
    }

    /**
     * Return number of ticket is register for selected day
     *
     * @param \DateTime $date Date of selected day
     *
     * @return int
     */
    private function getTicketsRegistered(\DateTime $date)
    {
        return count($this->em->getRepository(Ticket::class)->getTicketsByDay($date));
    }
}
