<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class)
                ->add('firstname', TextType::class)
                ->add('job', TextType::class)
                ->add('age', NumberType::class)
                ->add('diplomes', EntityType::class, array(
                    'class' => 'AppBundle\Entity\Diplome',
                    'choice_label' => 'designation',
                    'expanded' => false,
                    'multiple' => true,
                    'attr' => array(
                        'class' => 'select2'
                    )
                ))
                ->add('image',EntityType::class, array(
                    'class' => 'AppBundle\Entity\Image',
                    'choice_label' => 'alt',
                    'expanded' => false,
                    'multiple' => false,
                    'attr' => array(
                        'class' => 'select2'
                    )
                ))
                ->add('Ajouter', SubmitType::class, array(
                    'attr' => array(
                        'class' => 'btn btn-danger'
                    )
                    )
                );

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Personne',
            'attr'=>array('novalidate'=>'novalidate')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_personne';
    }


}
