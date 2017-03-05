<?php

namespace AppBundle\Services;

use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * Class MailerService
 */
class MailerService
{
    /** @var \Swift_Mailer */
    private $mailer;

    /** @var  string */
    private $emailMuseum;

    /** @var  string */
    private $nameEmailMuseum;

    /** @var TwigEngine */
    private $templating;

    /**
     * MailerService constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param string        $emailMuseum
     * @param string        $nameEmailMuseum
     * @param TwigEngine    $templating
     */
    public function __construct(\Swift_Mailer $mailer, $emailMuseum, $nameEmailMuseum, TwigEngine $templating)
    {
        $this->mailer = $mailer;
        $this->emailMuseum = $emailMuseum;
        $this->nameEmailMuseum = $nameEmailMuseum;
        $this->templating = $templating;
    }

    /**
     * @param string $subject
     * @param string $message
     * @param null   $senderName
     * @param null   $emailSender
     * @param null   $recipientTo
     * @param null   $recipientToName
     */
    public function sendEmail(
        $subject,
        $message,
        $senderName = null,
        $emailSender = null,
        $recipientTo = null,
        $recipientToName = null
    ) {
        $senderName = $senderName ? $senderName : $this->nameEmailMuseum;
        $senderAdress = $emailSender ? $emailSender : $this->emailMuseum;

        $recipientName = $recipientToName ? $recipientToName : $this->nameEmailMuseum;
        $recipientAdress = $recipientTo ? $recipientTo : $this->emailMuseum;

        $mail = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($senderAdress, $senderName)
            ->setTo($recipientAdress, $recipientName)
            ->setBody(
                $this->templating->render(
                    'email/contact_form.html.twig',
                    [
                        'message' => $message,
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($mail);
    }

    /**
     * @param string $emailSender
     * @param string $sender
     */
    public function automaticReplyContactForm($emailSender, $sender)
    {
        $mail = \Swift_Message::newInstance()
            ->setSubject('Confirmation de réception')
            ->setFrom($this->emailMuseum, $this->nameEmailMuseum)
            ->setTo($emailSender)
            ->setBody(
                $this->templating->render(
                    'email/confirm_receive_message_contact.html.twig',
                    [
                        'sender' => $sender,
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($mail);
    }
}
