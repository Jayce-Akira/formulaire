<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            'label' => 'Prénom',
            'required' => true,
            'attr' => ['placeholder' => 'Votre prénom',
                    'class' => 'form-control'],
            'constraints' => [
                new NotBlank(['message' => 'Veuillez entrer votre prénom.']),
                new Length([
                    'min' => 3,
                    'max' => 200,
                    'minMessage' => 'Le prénom doit avoir au moins {{ limit }} caractères.',
                    'maxMessage' => 'Le prénom ne doit pas dépasser {{ limit }} caractères.',
                ]),
            ],
            
            ])
        ->add('lastname', TextType::class, [
            'label' => 'Nom',
            'required' => true,
            'attr' => ['placeholder' => 'Votre Nom',
            'class' => 'form-control',],
            'constraints' => [
                new NotBlank(['message' => 'Veuillez entrer votre nom.']),
                new Length([
                    'min' => 3,
                    'max' => 200,
                    'minMessage' => 'Le prénom doit avoir au moins {{ limit }} caractères.',
                    'maxMessage' => 'Le prénom ne doit pas dépasser {{ limit }} caractères.',
                ]),
            ],
            ])
        ->add('email', EmailType::class, [
            'label' => 'E-Mail',
            'required' => true,
            'attr' => ['placeholder' => 'Votre E-mail',
            'class' => 'form-control'],
            'constraints' => [
                new NotBlank(['message' => 'Veuillez entrer une adresse email valide.']),
                new Length([
                    'max' => 255,
                    'maxMessage' => 'L\'adresse e-mail ne doit pas dépasser {{ limit }} caractères.',
                ]),
            ],
            ])
        ->add('comment', TextareaType::class, [
            'label' => 'Commentaire',
            'required' => true,
            'attr' => ['placeholder' => 'Votre Commentaire',
            'class' => 'form-control'],
            'constraints' => [
                new NotBlank(['message' => 'Veuillez entrer un commentaire.']),
                new Length([
                    'min' => 10,
                    'max' => 1000,
                    'minMessage' => 'Le commentaire doit avoir au moins {{ limit }} caractères.',
                    'maxMessage' => 'Le commentaire ne doit pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('envoyer', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary'],
            'label' => 'envoyer',
        ])
        ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event): void {
            // $data = $event->getData();
            $form = $event->getForm();

            // dump('data event', $data);
            // dump('form event', $form);
            
            

            $form->add('envoyer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary',
                            'style' => 'display: none'],
            ]);
            $form->add('confirmer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
                'label' => 'confirmer',
            ]);
        });
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
