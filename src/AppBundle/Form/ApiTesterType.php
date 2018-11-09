<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityRepository;
use ShopBundle\Form\YoutubeUsernameType;
use Symfony\Component\Form\Extension\Core\Type as Type;

class ApiTesterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('baseUrl', null , ["required" => true, 'constraints' => new Assert\NotBlank()])
            ->add('sort', Type\ChoiceType::class , [
                "required" => true, 
                'choices' => [
                    "Etape 1" => 'V2S1C', 
                    "Etape 2" => 'V2S2C', 
                    "Etape 3" => 'V2S3C', 
                    "Etape 4" => 'V2S4C', 
                    "Etape 5" => 'V2S5C', 
                    "Etape 6" => 'V2S6C', 
                    "Etape 7" => 'V2S7C', 
                    "Etape 8" => 'V2S8C' 
                ]
            ])
            ->add('test', Type\SubmitType::class)
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([]);
    }

    public function getBlockPrefix() { return ''; }
}