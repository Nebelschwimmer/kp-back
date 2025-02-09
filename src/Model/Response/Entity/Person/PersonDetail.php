<?php
namespace App\Model\Response\Entity\Person;

use OpenApi\Attributes as OA;

class PersonDetail
{
  #[OA\Property(example: 1)]
  public ?int $id;
  #[OA\Property(example: 'John')]
  public ?string $firstname;
  #[OA\Property(example: 'Doe')]
  public ?string $lastname;
  #[OA\Property(example: '')]
  public ?array $photos = [];
  #[OA\Property(example: 'male')]
  public ?string $gender;
  #[OA\Property(example: '1984-01-01')]
  public ?string $birthday;
  
  #[OA\Property(example: [1, 2])]
  public ?array $specialtyIds = [];

  #[OA\Property(example: ['actor', 'director'])]
  public ?array $specialtyNames = [];

  #[OA\Property(example: [2, 3])]
  public array $actedInFilms = [];
  #[OA\Property(example: 25)]
  public int $age = 0;
  #[OA\Property(example: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.')]
  public ?string $bio;
  #[OA\Property(example: 'cover.jpg')]
  public ?string $cover = null;

  #[OA\Property(example: 'avatar.jpg')]
  public ?string $avatar = null;

  public ?int $genderId = null;


  public function getId(): int
  {
    return $this->id;
  }

  public function setId(int $id): static
  {
    $this->id = $id;

    return $this;
  }
  public function getFirstname(): string
  {
    return $this->firstname;
  }
  public function setFirstname(string $firstname): static
  {
    $this->firstname = $firstname;

    return $this;
  }
  public function getLastname(): string
  {
    return $this->lastname;
  }

  public function setLastname(string $lastname): static
  {
    $this->lastname = $lastname;

    return $this;
  }

  public function getPhotos(): array
  {
    return $this->photos;
  }
  public function setPhotos(array $photos): static
  {
    $this->photos = $photos;

    return $this;
  }

  public function getGender(): string
  {
    return $this->gender;
  }
  public function setGender(string $gender): static
  {
    $this->gender = $gender;

    return $this;
  }

  public function getBirthday(): string
  {
    return $this->birthday;
  }
  public function setBirthday(string $birthday): static
  {
    $this->birthday = $birthday;

    return $this;
  }

  public function getActedInFilms(): array
  {
    return $this->actedInFilms;
  }
  public function setActedInFilms(array $actedInFilms): static
  {
    $this->actedInFilms = $actedInFilms;

    return $this;
  }
  public function getSpecialtyIds(): array
  {
    return $this->specialtyIds;
  }
  public function setSpecialtyIds(array $specialtyIds): static
  {
    $this->specialtyIds = $specialtyIds;

    return $this;
  }

  public function getSpecialtyNames(): array
  {
    return $this->specialtyNames;
  }
  public function setSpecialtyNames(array $specialtyNames): static
  {
    $this->specialtyNames = $specialtyNames;

    return $this;
  }

  public function getAge(): int
  {
    return $this->age;
  }

  public function setAge(int $age): static
  {
    $this->age = $age;

    return $this;
  }

  public function getBio(): string
  {
    return $this->bio;
  }
  public function setBio(string $bio): static
  {
    $this->bio = $bio;

    return $this;
  }

  public function getCover(): string
  {
    return $this->cover;
  }
  public function setCover(string $cover): static
  {
    $this->cover = $cover;

    return $this;    
  }

  public function getAvatar(): string
  {
    return $this->avatar;
  }
  public function setAvatar(string $avatar): static
  {
    $this->avatar = $avatar;

    return $this;    
  }

  public function getGenderId(): int
  {
    return $this->genderId;
  }
  public function setGenderId(int $genderId): static
  {
    $this->genderId = $genderId;

    return $this;    
  }

}