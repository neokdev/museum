<?php

namespace AppBundle\Services;

use AppBundle\Entity\Order;
use AppBundle\Form\Type\SearchOrderType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormView;
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
}
