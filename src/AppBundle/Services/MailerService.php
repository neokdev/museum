<?php

namespace AppBundle\Services;

use AppBundle\Entity\Order;
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
     * @param string $subject      Subject of email
     * @param string $message      Content of email
     * @param string $templateMail Name of template mail
     * @param string $senderName   Name of sender
     * @param string $emailSender  Email of sender
     */
    public function sendEmail(
        $subject,
        $message,
        $templateMail,
        $senderName,
        $emailSender
    ) {
        $mail = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom('musee@aurelien-morvan.fr')
            ->setTo('musee@aurelien-morvan.fr', $this->nameEmailMuseum)
            ->setBody(
                $this->templating->render(
                    $templateMail,
                    [
                        'subject' => $subject,
                        'senderName' => $senderName,
                        'senderAddress' => $emailSender,
                        'message' => $message,
                        'date' => new \DateTime(),

                    ]
                ),
                'text/html'
            );

        $this->mailer->send($mail);
    }

    /**
     * This method send an automatic mail for each mail send from contact form.
     *
     * @param string $emailSender  Email of sender
     * @param string $sender       Name of sender
     * @param string $subject      Subject of the application
     * @param string $templateMail Template for this automatic reply
     */
    public function automaticReplyContactForm($emailSender, $sender, $subject, $templateMail)
    {
        $mail = \Swift_Message::newInstance();
        $mail
            ->setSubject('Confirmation de réception')
            ->setFrom('contact@aurelien-morvan.fr')
            ->setTo($emailSender)
            ->setBody(
                $this->templating->render(
                    $templateMail,
                    [
                        'image' => \Swift_Image::fromPath('http://musee.aurelien-morvan.fr/images/logo.png'),
                        'sender' => $sender,
                        'subject' => $subject,
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($mail);
    }

    /**
     * @param string $subject        Subject of mail
     * @param string $emailRecipient Email recipient of mail
     * @param string $templateMail   Template has been load
     * @param Order  $order          Order
     */
    public function sendTickets($subject, $emailRecipient, $templateMail, Order $order)
    {
        $mail = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->emailMuseum, $this->nameEmailMuseum)
            ->setTo($emailRecipient)
            ->setBody(
                $this->templating->render(
                    $templateMail,
                    [
                        'order' => $order,
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($mail);
    }
}
