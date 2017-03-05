<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 */
class HomeController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->get('app.contact_service')->sendEmailFromContactForm($request);

        return $this->render('default/index.html.twig', [
            'form' => $form,
        ]);
    }
}
