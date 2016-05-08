<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

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
				"required" => true,
				"attr" => array("placeholder"=>"Macchinina")
			))
            ->add('price', MoneyType::class, array(
				"label" => "Prezzo",
				"required" => true,
				"attr" => array("placeholder"=>"40.00")
			))
            ->add('description', TextType::class, array(
				"label" => "Descrizione prodotto",
				"attr" => array("placeholder"=>"L'oggetto è come nuovo ma non è nuovo.")
			))
            ->add('imfile',  FileType::class, array(
				"label" => "Foto del prodotto",
				"required"=>false
			))
            ->add('tags', TextType::class, array(
				"label" => "Elenco Tag (valori separati da virgola)",
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
