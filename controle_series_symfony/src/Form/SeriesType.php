<?php

namespace App\Form;

use App\DTO\SeriesCreateationInputDTO;
// use App\Entity\Series;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SeriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('seriesName', options: ['label' => 'Nome:'])
            ->add('seasonsQuantity', NumberType::class, options: ['label' => 'Qtd temporadas:'])
            ->add('episodesPerSeason', NumberType::class, options: ['label' => 'Ep por temporada:'])
            ->add('coverImage', FileType::class, [
                'label' => 'Imagem de capa:',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File(mimeTypes: 'image/*')
                ]
            ])
            // ->add('save', SubmitType::class, ['label' => $options['is_edit'] ? 'Editar' : 'Adicionar'])
            ->add('save', SubmitType::class, ['label' => 'Adicionar'])
            // ->setMethod($options['is_edit'] ? 'PATCH' : 'POST')
            ->setMethod('POST')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Series::class,
            'data_class' => SeriesCreateationInputDTO::class,
            // 'is_edit'=> false,
        ]);
        // $resolver->setAllowedTypes('is_edit', 'bool');
    }
}
