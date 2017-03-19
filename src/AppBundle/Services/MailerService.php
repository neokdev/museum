<?php

namespace AppBundle\Services;

use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * Class MailerService.
 *
 * This service has been used to send generic email
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class MailerService
{
    /** @var \Swift_Mailer Swift mailer service */
    private $mailer;

    /** @var string Email of museum define in parameters file */
    private $emailMuseum;

    /** @var string Name email of museum define in parameters file */
    private $nameEmailMuseum;

    /** @var TwigEngine Twig engine service */
    private $templating;

    /**
     * MailerService constructor.
     *
     * @param \Swift_Mailer $mailer          Service Swift mailer
     * @param string        $emailMuseum     Email of museum
     * @param string        $nameEmailMuseum Name for email of museum
     * @param TwigEngine    $templating      Service twig engine
     */
    public function __construct(
        \Swift_Mailer $mailer,
        $emailMuseum,
        $nameEmailMuseum,
        TwigEngine $templating
    ) {
        $this->mailer = $mailer;
        $this->emailMuseum = $emailMuseum;
        $this->nameEmailMuseum = $nameEmailMuseum;
        $this->templating = $templating;
    }

    /**
     * This method allows to send a mail generically according to the parameters passed during the call.
     *
     * @param string $subject         Subject of email
     * @param string $message         Content of email
     * @param null   $senderName      Name of sender
     * @param null   $emailSender     Email of sender
     * @param null   $recipientTo     Email of recipient
     * @param null   $recipientToName Name of recipient
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
     * This method send an automatic mail for each mail send from contact form.
     *
     * @param string $emailSender Email of sender
     * @param string $sender      Name of sende r
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
