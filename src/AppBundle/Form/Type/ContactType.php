<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ContactType
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class ContactType extends AbstractType
{
    /**
     * Build contact form
     *
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Votre nom:',
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email:',
                'required' => true,
            ])
            ->add('subject', ChoiceType::class, [
                'label' => 'Sujet:',
                'required' => true,
                'choices' => [
                    'Horaires d\'ouverture' => 'Horaires d\'ouverture',
                    'Moyens de paiement' => 'Moyens de paiement',
                    'Autre demande' => 'Autre demande',
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'required' => true,
            ]);
    }
}
