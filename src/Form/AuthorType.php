<?php

namespace App\Form;

use App\Entity\Author;
use App\Form\BookType;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,["label"=>"Nom","required"=>false])
            ->add('firstName',TextType::class,["label"=>"Prenom","required"=>false] )
            ->add('pseudo',TextType::class,["label"=>"Pseudo","required"=>false])
            ->add('imageFile',FileType::class,["label"=>"Image","required"=>false])
            ->remove('imageName')
            ->remove('updatedAt')
            ->add('biography',CKEditorType::class,["label"=>"Biographie","required"=>false])
            ->add('birthdate',DateTimeType::class,["label"=>"Date de naissance","widget"=>"single_text", "required"=>false])
            ->add('dateOfDeath', DateTimeType::class,["label"=>"Décédé le ","widget"=>"single_text","required"=>false])
            ->remove('slug')
            
        ;
        if($options['hasBooks']){
        $builder
        ->add('books',CollectionType::class,
        ["entry_type"=>BookType::class,
        "entry_options"=>["fromAuthor"=>true], 
        "allow_add"=>true,
        "allow_delete"=>true,
        "by_reference"=>false,
         "label"=>false]);
        }
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
            'hasBooks'=>true
        ]);
    }
}
