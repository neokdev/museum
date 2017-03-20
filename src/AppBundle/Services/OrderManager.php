<?php

namespace AppBundle\Services;

use AppBundle\Entity\Order;
use AppBundle\Entity\Ticket;
use AppBundle\Form\Type\OrderType;
use AppBundle\Form\Type\SearchOrderType;
use Doctrine\ORM\EntityManager;
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
     * @return FormView
     */
    public function startOrder(Request $request)
    {
        $order = new Order();
        $order->setDateOrder(new \DateTime());

        $form = $this->formFactory->create(OrderType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();
            $numberTickets = $datas['numberTickets'];
            $remainingTickets = 1000 - $this->getTicketsRegistered();

            if ($numberTickets > $remainingTickets) {
                $this->session->getFlashBag()->add(
                    'NoEnoughTicket',
                    'Il n\'y a pas suffisamment de billet disponible pour le jour demandé'
                );

                $response = new RedirectResponse('/');
                $response->send();
            }

            while ($numberTickets > 0) {
                $order->addTicket(new Ticket());
            }

            $this->session->set('order', $order);
            $this->session->getFlashBag()->add(
                'success',
                'La commande a commencé...'
            );

            $response = new RedirectResponse('/ticket');
            $response->send();
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
                    'email' => $emailSearch['email'],
                ]
            );

            if (!$order) {
                $this->session->getFlashBag()->add(
                    'error',
                    'L\'adresse email indiqué ne correspond pas à une commande'
                );
                exit;
            }

            $this->session->getFlashBag()->add(
                'success',
                sprintf(
                    'Votre commande a bien été trouvée, vous allez recevoir vos billets à l\'adresse %s',
                    $emailSearch['email']
                )
            );

            $this->mailerService->sendTickets(
                'E-Billet - Musée du Louvre - N°'.$order->getOrderNumber(),
                $emailSearch['email'],
                'email/confirm_order.html.twig',
                $order
            );
        }

        return $form->createView();
    }

    /**
     * Return number of ticket is register for selected day
     *
     * @return int
     */
    public function getTicketsRegistered()
    {
        return count($this->em->getRepository(Ticket::class)->getTicketsByDay());
    }
}
