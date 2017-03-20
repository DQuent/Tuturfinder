<?php

namespace AnnoncesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateDep')->add('dateArr')->add('id_annonceur')->add('titre')->add('description')->add('nbPlaces')->add('dureeDetour')->add('prix')->add('villeDep')->add('villeArr')->add('adresseDep')->add('adresseArr')->add('id_conducteur')->add('array_passagers')        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AnnoncesBundle\Entity\Annonce'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'annoncesbundle_annonce';
    }


}
