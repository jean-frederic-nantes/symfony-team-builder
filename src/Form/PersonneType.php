<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom',null,['label'=> ' ','attr'=>['placeholder'=>'Prénom']])
            ->add('nom',null,['label'=> ' ','attr'=>['placeholder'=>'Nom']])
            ->add('equipes',null, 
            [
                'choice_label'=>'nom',
                'placeholder'=>'Pas d\'équipes',
                'label'=> ' ',
                'mapped'=>false,  // je detache des attricut de l'entity => pas d hydration auto
                'multiple'=>false // pas de select multiple
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
