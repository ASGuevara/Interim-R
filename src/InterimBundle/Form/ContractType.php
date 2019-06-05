<?php

namespace InterimBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('startDate')
            ->add('endDate')
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Wait'    => 'wait',
                    'Process' => 'process',
                    'Over'    => 'over',
                ],
            ])
            ->add('interim', EntityType::class, array(
                'class' => 'InterimBundle\Entity\Interim',
                'choice_label' => 'lastName',
                'multiple' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('interim')
                        ->orderBy('interim.lastName', 'ASC');
                },
            ));;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'InterimBundle\Entity\Contract'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'interimbundle_contract';
    }


}
