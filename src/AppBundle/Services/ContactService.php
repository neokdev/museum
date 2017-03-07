<?php

namespace AppBundle\Services;

use AppBundle\Form\Type\ContactType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContactService
 *
 * This service has been used to send a mail from contact form
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class ContactService
{
    /** @var FormFactory Service to build form */
    private $formFactory;

    /** @var MailerService Service to send generic mail */
    private $mailerService;

    /**
     * ContactService constructor.
     *
     * @param FormFactory   $formFactory   Service build form
     * @param MailerService $mailerService Service send mail
     */
    public function __construct(FormFactory $formFactory, MailerService $mailerService)
    {
        $this->formFactory = $formFactory;
        $this->mailerService = $mailerService;
    }

    /**
     * This method allows to send an email from the contact form.
     *
     * @param Request $request Current request
     *
     * @return FormView Return a view corresponding to the form
     */
    public function sendEmailFromContactForm(Request $request)
    {
        $form = $this->formFactory->create(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();

//            try {
            $this->mailerService->sendEmail(
                $datas['subject'],
                $datas['message'],
                $datas['name'],
                $datas['email']
            );

            $this->mailerService->automaticReplyContactForm(
                $datas['email'],
                $datas['name']
            );

//            } catch (\Exception $exception) {
//                $exception->getMessage();
//            }
        }

        return $form->createView();
    }
}
