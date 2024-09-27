<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(
    fields: ['Fname', 'Sname', 'Pname'],
    message: 'Автор с таким ФИО уже существует.'
)]

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Fname = null;

    #[ORM\Column(length: 255)]
    private ?string $Sname = null;

    #[ORM\Column(length: 255)]
    private ?string $Pname = null;

    #[ORM\ManyToMany(targetEntity: Book::class, mappedBy: 'authors')]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFname(): ?string
    {
        return $this->Fname;
    }

    public function setFname(string $Fname): static
    {
        $this->Fname = $Fname;

        return $this;
    }

    public function getSname(): ?string
    {
        return $this->Sname;
    }

    public function setSname(string $Sname): static
    {
        $this->Sname = $Sname;

        return $this;
    }

    public function getPname(): ?string
    {
        return $this->Pname;
    }

    public function setPname(string $Pname): static
    {
        $this->Pname = $Pname;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addAuthor($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            $book->removeAuthor($this);
        }

        return $this;
    }
}
