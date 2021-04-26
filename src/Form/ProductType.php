<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Product $product */
        $product = $options['data'] ?? null;
        $isEdit = $product && $product->getId();

        $imageConstraints = [
            new Image([
                'maxSize' => '5M'
            ])
        ];

        if(!$isEdit) {
            $imageConstraints[] = new NotNull([
                'message' => 'Please upload an image'
            ]);
        }

        $builder
            ->add('title')
            ->add('description')
            ->add('upload_image',FileType::class,[
                'mapped' => false,
                'required' => false,
                'constraints' => $imageConstraints

            ])
            ->add('category',ChoiceType::class,[
                'choices' => array(
                    'food' => 'food',
                    'drink' => 'drink'
                ),
                'placeholder' => 'choice an category'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
