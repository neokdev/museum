<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class SearchOrderType
 *
 * @author Aurélien Morvan <contact@aurelien-morvan.fr>
 */
class SearchOrderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse e-mail :',
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
