<?php

namespace App\Form;

use App\Entity\Home;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class HomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,["help"=>"le titre de la page", "help_attr"=>["class"=>"text-primary"],"label"=>"le titre","required"=>true])
            ->add('texte' , CKEditorType::class, ["label"=>"le texte","required"=>true])
            ->add('signature',TextType::class, ["label"=>"la signature","required"=>true] )
            ->add('isActive', CheckboxType::class, ["label"=>"Page active ?", "row_attr"=>["class"=>"form-switch"],"required"=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Home::class,
        ]);
    }
}
