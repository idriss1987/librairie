<?php

namespace App\Form;

use App\Entity\Carousel;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CarouselType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->remove('imageName')
            ->add('imageFile',FileType::class,["label"=>"Image","required"=>true])
            ->add('title',TextType::class, ["label"=>"Titre","required"=>false])
            ->add('text',CKEditorType::class,["label"=>"Texte","required"=>false])
            ->add('tag', ChoiceType::class,["label"=>"Tag","choices"=>["home"=>"home","contact"=>"contact","livre"=>"livre","auteur"=>"auteur"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Carousel::class,
        ]);
    }
}
