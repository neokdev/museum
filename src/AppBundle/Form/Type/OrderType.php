<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class OrderType
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class OrderType extends AbstractType
{
    /**
     * Build order form to start command
     *
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse e-mail',
                'required' => true,
            ])
            ->add('dateVisit', DateType::class, [
                'label' => 'Date de la visite',
                'required' => true,
            ])
            ->add('typeTicket', ChoiceType::class, [
                'label' => 'Type de billet:',
                'required' => true,
            ])
            ->add('numberTickets', ChoiceType::class, [
                'label' => 'Nombre de ticket souhaités',
                'required' => true,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
