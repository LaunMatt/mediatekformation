<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Formation;
use App\Entity\Playlist;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Classe permettant la création du formulaire d'ajout / de modification d'une formation
 */
class FormationType extends AbstractType
{
    /**
     * Méthode permettant la création du formulaire avec les données à afficher
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('publishedAt', DateType::class, [
                'widget' => 'single_text',
                'data' => isset($options['data']) &&
                    $options['data']->getPublishedAt() != null ? $options['data']->getPublishedAt() : new DateTime('now'),
                'label' => 'Date de publication'
            ])
            ->add('playlist', EntityType::class, [
                'class' =>Playlist::class,
                'choice_label' => 'name',
                'placeholder' => 'Aucune playlist',
                'label' => 'Playlist'
            ])
            
            ->add('categories', EntityType::class, [
                'class'=> Categorie::class,
                'choice_label'=> 'name',
                'multiple'=> true,
                'required'=> false,
                'label' => 'Catégories'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false
            ])
            ->add('videoId', TextType::class, [
                'label' => 'ID de la vidéo'
            ])
            ->add('submit', SubmitType::class, [
                'label'=> 'Enregistrer'
            ]);
    }

    /**
     * Méthode permettant de configurer les options du formulaire
     * 
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
