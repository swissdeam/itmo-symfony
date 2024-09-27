<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\AuthorRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
class Book1Type extends AbstractType
{
    private $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, ['label' => 'Название'])
            ->add('Year', NumberType::class, ['label' => 'Год издания'])
            ->add('ISBN', TextType::class, ['label' => 'ISBN'])
            ->add('Pages', NumberType::class, ['label' => 'Количество страниц'])
            ->add('authors', EntityType::class, [
                'label' => 'Авторы',
                'class' => Author::class,
                'choice_label' => function (Author $author) {
                    return trim(sprintf('%s %s %s', 
                        $author->getFname(), 
                        $author->getSname(), 
                        $author->getPname()
                    ));
                },
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
