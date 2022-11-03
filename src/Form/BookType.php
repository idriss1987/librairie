<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\BookCategory;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class, ["label"=>"Titre","required"=>true])
            ->add('description',CKEditorType::class,["label"=>"description","required"=>false])
            ->remove('imageName')
            ->add('imageFile',FileType::class,["label"=>"Image","required"=>false])
            ->remove('updatedAt')
            ->add('isActive', CheckboxType::class, ["label"=>false, "row_attr"=>["class"=>"form-switch"],"required"=>false])
            ->remove('slug')
            ->add('bookCategory',EntityType::class,["label"=>"catégorie","class"=>BookCategory::class,"required"=>true])
        ;
        if (!$options["fromAuthor"]){
        $builder
        ->add('author',EntityType::class,["class"=>Author::class ,"label"=>"Auteur","required"=>true]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'fromAuthor'=>false,
        ]);
    }
}
