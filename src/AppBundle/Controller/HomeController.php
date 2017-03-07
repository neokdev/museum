<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
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
}
