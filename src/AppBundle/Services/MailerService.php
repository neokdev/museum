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
    private $recipientAdress;

    /** @var  string */
    private $recipientName;

    /** @var TwigEngine */
    private $templating;

    /**
     * MailerService constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param string        $recipientAdress
     * @param string        $recipientName
     * @param TwigEngine    $templating
     */
    public function __construct(\Swift_Mailer $mailer, $recipientAdress, $recipientName, TwigEngine $templating)
    {
        $this->mailer = $mailer;
        $this->recipientAdress = $recipientAdress;
        $this->recipientName = $recipientName;
        $this->templating = $templating;
    }

    /**
     * @param string $sender
     * @param string $subject
     * @param string $emailSender
     * @param string $message
     */
    public function sendEmailByFormContact($sender, $subject, $emailSender, $message)
    {
        $mail = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($emailSender, $sender)
            ->setTo($this->recipientAdress, $this->recipientName)
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
            ->setFrom($this->recipientAdress, $this->recipientName)
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
