<?php

namespace App\Form;

use App\Entity\Cars;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CarsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => "Titre",
            'attr' => [
                'placeholder' => "Nom de votre voiture",
            ]
        ])
           
        ->add('slug', TextType::class, $this->getConfiguration('Slug', 'Adresse web (automatique)',[
            'required' => false
        ]))
        ->add('marque',TextType::class, $this->getConfiguration('Marque','Donnez la marque de votre voiture'))
        ->add('coverImage', UrlType::class, $this->getConfiguration("Url de l'image", "Donnez l'adresse de votre image"))
        ->add('introduction', TextType::class, $this->getConfiguration('Introduction','Donnez une description globale de la voiture'))
        ->add('content', TextareaType::class, $this->getConfiguration('Description détaillée','Donnez une description de votre voiture'))
        ->add('km',IntegerType::class, $this->getConfiguration('Nombre de kilomètres','Donnez le nombre de km de la voiture'))
        ->add('price', MoneyType::class, $this->getConfiguration('Prix par jour','Indiquer le prix que vous voulez pour une journée'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cars::class,
        ]);
    }

    private function getConfiguration(string $label, string $placeholder, array $options=[]):array
    {
        return array_merge_recursive([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ],
        ], $options
        );

    }
}
