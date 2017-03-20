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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
                DateType::class,
                [
                    'label' => 'Date de la visite',
                    'required' => true,
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Le champ date de la visite doit être renseigné',
                            ]
                        ),
                        new DateExceeded(
                            [
                                'message' => 'La date que vous avez choisi est antérieur à la date actuelle',
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
                    'constraints' => [
                        new NotBlank(
                            [
                                'message' => 'Vous devez choisir le type de billet que vous souhaitez, demi-journée ou journée',
                            ]
                        ),
                        new HalfDay(
                            [
                                'message' => 'Vous ne pouvez plus réserver votre billet pour la journée complète car il est 14h00 passée',
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
