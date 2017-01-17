<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactType
 */
class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Votre nom:',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email:',
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet:',
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
            ])
            ->getForm();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_bundle_contact';
    }
}
