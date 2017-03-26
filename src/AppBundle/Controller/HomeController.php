<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController.
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class HomeController extends Controller
{
    /**
     * @param Request $request Contain user request
     *
     * @Route("/", name="homepage")
     *
     * @return Response Return an http response
     */
    public function indexAction(Request $request)
    {
        $form = $this->get('app.contact_service')->sendEmailFromContactForm($request);

        return $this->render('default/index.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @param Request $request
     *
     * @Route("/order", name="order")
     *
     * @return Response
     */
    public function orderAction(Request $request)
    {
        $this->get('app.ticket_manager')->isUnderLimitTicket();

        $formSearchOrder = $this->get('app.order_manager')->searchOrder($request);
        $formStartOrder = $this->get('app.order_manager')->startOrder($request);

        return $this->render('default/order_page.html.twig', [
            'formStartOrder' => $formStartOrder,
            'formSearchOrder' => $formSearchOrder,
        ]);
    }

    /**
     * @param Request $request
     *
     * @Route("/ticket", name="ticket")
     *
     * @return Response
     */
    public function registerTicketAction(Request $request)
    {
        $form = $this->get('app.order_manager')->registerTickets($request);

        return $this->render('default/ticket_page.html.twig', [
            'form' => $form,
        ]);
    }
}
