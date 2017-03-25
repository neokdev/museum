<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Order;
use AppBundle\Form\Type\TicketType;
use AppBundle\Validator\ClosedHoliday;
use AppBundle\Validator\DateExceeded;
use AppBundle\Validator\DayClosed;
use AppBundle\Validator\HalfDay;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Votre adresse e-mail',
                    'required' => true,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Le champ email doit être renseigné',
                            ]
                        ),
                        new Length(
                            [
                                'max' => 100,
                                'maxMessage' => 'Le champ email fait plus de 100 caractères',
                            ]
                        ),
                    ],
                ]
            )
            ->add(
                'dateVisit',
                DateTimeType::class,
                [
                    'label' => 'Date de la visite',
                    'required' => true,
                    'format' => 'dd/MM/yyyy',
                    'widget' => 'single_text',
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Le champ date de la visite doit être renseigné',
                            ]
                        ),
                        new DayClosed(
                            [
                                'message' => 'Le musée est fermé le mardi et le dimanche',
                            ]
                        ),
                        new ClosedHoliday(
                            [
                                'message' => 'Le musée est fermé les 1er mai, 1er novembre et 25 décembre.',
                            ]
                        ),
                    ],
                ]
            )
            ->add(
                'typeTicket',
                ChoiceType::class,
                [
                    'label' => 'Type de billet:',
                    'required' => true,
                    'choices' => [
                        'Journée' => 0,
                        'Demi-journée' => 1,
                    ],
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Vous devez choisir le type de billet que vous souhaitez, demi-journée ou journée',
                            ]
                        ),
                    ],
                ]
            )
            ->add(
                'numberTickets',
                ChoiceType::class,
                [
                    'label' => 'Nombre de ticket souhaités',
                    'required' => true,
                    'choices' => [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                        '7' => '7',
                        '8' => '8',
                        '9' => '9',
                        '10' => '10',
                    ],
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Vous devez choisir un nombre de billets dans la liste',
                            ]
                        ),
                    ],
                ]
            )
            ->add(
                'tickets',
                CollectionType::class,
                [
                    'entry_type' => TicketType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Order::class,
            ]
        );
    }
}
