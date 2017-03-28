<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class TicketType.
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom :',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ prénom doit être renseigné',
                    ]),
                    new Length([
                        'max' => 38,
                        'maxMessage' => 'Le champ prénom dépasse 38 caractères',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom :',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ nom doit être renseigné',
                    ]),
                    new Length([
                        'max' => 38,
                        'maxMessage' => 'Le champ nom dépasse 38 caractères',
                    ]),
                ],
            ])
            ->add('birthDate', BirthdayType::class, [
                'label' => 'Votre date de naissance :',
                'required' => true,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'invalid_message' => 'Format demandé: 18-02-1985',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ date de naissance doit être renseigné',
                    ]),
                ],
            ])
            ->add('nationality', CountryType::class, [
                'label' => 'Votre nationalité :',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ nationalité doit être renseigné',
                    ]),
                ],
            ])
            ->add('reduction', CheckboxType::class, [
                'label' => 'Disposez-vous d\'un tarif réduit :',
                'required' => false,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
