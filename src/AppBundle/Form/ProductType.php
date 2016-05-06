<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
				"label" => "Nome prodotto",
				"attr" => array("placeholder"=>"Macchinina")
			))
            ->add('price', MoneyType::class, array(
				"label" => "Prezzo",
				"attr" => array("placeholder"=>"10.20")
			))
            ->add('description', TextType::class, array(
				"label" => "Descrizione prodotto",
				"attr" => array("placeholder"=>"L'oggetto è come nuovo ma non è nuovo.")
			))
           // ->add('image', TextType::class)
           // ->add('created', DateType::class)
            ->add('tags', TextType::class, array(
				"label" => "Elenco Tag",
				"required" => true,
				"attr" => array("placeholder"=>"fragole, acciaieria, peloponneso")
			))
			
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product'
        ));
    }
}
