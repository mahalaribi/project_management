<?php

namespace App\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\File;
use App\Entity\Project;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Champ texte simple
            ->add('title', TextType::class, [
                'required' => false,
                'attr' => ['novalidate' => 'novalidate'],
                'constraints' => [

                    new Assert\Length(['min' => 3]),
                ],
            ])
           ->add('image', FileType::class, [
                    'label' => 'Choisir une image',
                    'mapped' => false, 
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '2M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/jpg',
                            ],
                            'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG)',
                        ])
                    ],
                ])
            ->add('filenameOrUrl', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Length(['max' => 255]),
                ],
            ])
            ->add('numberOfTasks', IntegerType::class, [
                'required' => false,
                'constraints' => [
            
                    new Assert\Positive(),
                ],
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'constraints' => [
                   
                    new Assert\Length(['min' => 10]),
                ],
            ])
           ->add('status', ChoiceType::class, [
                'choices' => [
                    'En cours' => 'in_progress',
                    'Terminé' => 'completed',
                    'En attente' => 'pending',
                ],
                'placeholder' => 'Choisir un statut',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
