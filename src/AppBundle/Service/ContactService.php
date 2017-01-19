<?php

namespace AppBundle\Service;

use AppBundle\Form\Type\ContactType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContactService
 */
class ContactService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var TwigEngine
     */
    private $templating;

    /**
     * ContactService constructor.
     *
     * @param EntityManager $em
     * @param FormFactory   $formFactory
     * @param \Swift_Mailer $mailer
     * @param TwigEngine    $templating
     */
    public function __construct(EntityManager $em, FormFactory $formFactory, \Swift_Mailer $mailer, TwigEngine $templating)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\Form\FormView
     */
    public function sendFormByMail(Request $request)
    {
        $form = $this->formFactory->create(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();

                $mail = \Swift_Message::newInstance()
                    ->setSubject($datas['subject'])
                    ->setFrom($datas['email'])
                    ->setTo('morvan.aurelien@gmail.com')
                    ->setBody($datas['message']);

                $this->mailer->send($mail);

        }

        return $form->createView();
    }
}
