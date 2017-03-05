<?php

namespace AppBundle\Services;

use AppBundle\Form\Type\ContactType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContactService
 */
class ContactService
{
    /** @var FormFactory */
    private $formFactory;

    /** @var MailerService */
    private $mailerService;

    /**
     * ContactService constructor.
     *
     * @param FormFactory   $formFactory
     * @param MailerService $mailerService
     */
    public function __construct(FormFactory $formFactory, MailerService $mailerService)
    {
        $this->formFactory = $formFactory;
        $this->mailerService = $mailerService;
    }

    /**
     * @param Request $request
     *
     * @throws \LogicException
     *
     * @return FormView
     */
    public function sendEmailFromContactForm(Request $request)
    {
        $form = $this->formFactory->create(ContactType::class);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $datas = $form->getData();

            try {
                if (!$datas) {
                    throw new \LogicException(
                        sprintf(
                            'No datas found'
                        )
                    );
                }
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

            } catch (\LogicException $exception) {
                $exception->getMessage();
            }
        }

        return $form->createView();
    }
}
