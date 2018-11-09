<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityRepository;
use ShopBundle\Form\YoutubeUsernameType;
use Symfony\Component\Form\Extension\Core\Type as Type;

class DomainTranslationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', null , ["required" => true, 'constraints' => new Assert\NotBlank()])
            ->add('trans', Type\CollectionType::class, ["required" => true, 'entry_type' => Type\TextType::class, 'allow_add' => true])
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