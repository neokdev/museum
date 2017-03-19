<?php

namespace AppBundle\Form\Type;

use AppBundle\Validator\ContainsAlphabeticValidator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Class ContactType.
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class ContactType extends AbstractType
{
    /**
     * Build contact form.
     *
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Votre nom:',
                    'required' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Le champ nom doit être renseigné',
                        ]),
                        new Length([
                            'max' => 38,
                            'maxMessage' => 'Le champ nom fait plus de 38 caractères',
                        ]),
                    ],
                ]

            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Votre email:',
                    'required' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Le champ email doit être renseigné',
                        ]),
                        new Length([
                            'max' => 100,
                            'maxMessage' => 'Le champ email fait plus de 100 caractères',
                        ]),
                    ],
                ]
            )
            ->add(
                'subject',
                ChoiceType::class,
                [
                    'label' => 'Sujet:',
                    'required' => true,
                    'choices' => [
                        'Horaires d\'ouverture' => 'Horaires d\'ouverture',
                        'Moyens de paiement' => 'Moyens de paiement',
                        'Autre demande' => 'Autre demande',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Vous devez faire un choix de sujet dans la liste',
                        ]),
                    ],
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'label' => 'Message',
                    'required' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Le contenu de votre message ne peut-être vide',
                        ]),
                    ],
                ]
            );
    }
}
