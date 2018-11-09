<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityRepository;
use ShopBundle\Form\YoutubeUsernameType;
use Symfony\Component\Form\Extension\Core\Type as Type;

class GetLangType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('page', Type\IntegerType::class , [
                "required" => true
            ])
            ->add('per_page', Type\IntegerType::class, [
                "required" => true
            ])
            ->add('sort', Type\ChoiceType::class , [
                "required" => true, 
                'choices' => ['ASC', 'DESC']
            ])
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