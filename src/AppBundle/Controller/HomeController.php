<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 *
 * @package AppBundle\Controller
 * @author  Aurélien Morvan <contact@aurelien-morvan.fr>
 *
 * @Route("/")
 */
class HomeController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("", name="homepage")
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('order/index.html.twig');
    }
}
