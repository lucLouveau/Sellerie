<?php

namespace App\Form;

use App\Entity\Equipement;
use App\Entity\Historiques;
use App\Entity\Mouvements;
use App\Entity\Zone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HistoriquesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('zone', EntityType::class, [
                'class' => Zone::class,
                'choice_label' => 'nom',
            ])
            ->add('save', SubmitType::class,['label'=>'Enregistrer les changements'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Historiques::class,
        ]);
    }
}