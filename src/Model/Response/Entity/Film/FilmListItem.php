<?php
namespace App\Model\Response\Entity\Film;

use OpenApi\Attributes as OA;

class FilmListItem
{
  public function __construct(?int $id, ?string $name = null, int $releaseYear = null, ?string $cover = null, ?string $description = null, ?string $rating = null, array $assessments = [])
  {
    $this->id = $id;
    $this->name = $name;
    $this->releaseYear = $releaseYear;
    $this->cover = $cover;
    $this->description = $description;
    $this->rating = $rating;
    $this->assessments = $assessments;

  }
  #[OA\Property(example: 1)]
  public ?int $id;
  #[OA\Property(example: 'Star Wars')]
  public ?string $name;

  public ?array $gallery = [];
  #[OA\Property(example: 1997)]
  public int $releaseYear;
  
  #[OA\Property(example: 'cover.jpg')]
  public string $cover = '';

  #[OA\Property(example: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.')]
  public string $description = '';

  #[OA\Property(example: '4')]
  public string $rating = '';

  public array $assessments = [];

  public function getId(): int
  {
    return $this->id;
  }
  public function setId(int $id): static
  {
    $this->id = $id;

    return $this;
  }
  public function getName(): string
  {
    return $this->name;
  }
  public function setName(string $name): static
  {
    $this->name = $name;

    return $this;
  }

  public function getGallery(): array
  {
    return $this->gallery;
  }

  public function setGallery(array $gallery): static
  {
    $this->gallery = $gallery;

    return $this;
  }

  public function getReleaseYear(): int
  {
    return $this->releaseYear;
  }

  public function setReleaseYear(int $releaseYear): static
  {
    $this->releaseYear = $releaseYear;

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

  public function getDescription(): string
  {
    return $this->description;
  }

  public function setDescription(string $description): static
  {
    $this->description = $description;

    return $this;
  }

  public function getRating(): string
  {
    return $this->rating;
  }

  public function setRating(string $rating): static
  {
    $this->rating = $rating;

    return $this;
  }

  public function setAssessments(array $assessments): static
  {
    $this->assessments = $assessments;

    return $this;
  }

  public function getAssessments(): array
  {
    return $this->assessments;
  }



}