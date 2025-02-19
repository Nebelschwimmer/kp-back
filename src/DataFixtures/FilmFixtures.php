<?php
namespace App\DataFixtures;

use App\Entity\Film;
use App\Enum\Genres;
use App\Repository\UserRepository;
use App\Service\Entity\PersonService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FilmFixtures extends Fixture
{
    public function __construct(
        private readonly PersonService $personService,
        private UserRepository $userRepository,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $admin = $this->userRepository->findOneBy(['role' => 'ROLE_ADMIN']);
        $genres = [
            'drama' => 1,
            'action' => 2,
            'comedy' => 3,
            'thriller' => 4,
            'romance' => 5,
            'fantasy' => 6,
            'science_fiction' => 7,
            'horror' => 8,
            'documentary' => 9,
        ];
        $actors = $this->personService->listActors();
        $directors = $this->personService->listDirectors();
        $producers = $this->personService->listProducers();
        $writers = $this->personService->listWriters();
        $composers = $this->personService->listComposers();

        $filmData = [
            [
                'name' => 'Star Wars',
                'slogan' => 'The Empire Strikes Back',
                'genres' => Genres::matchIdAndGenre($genres['science_fiction']),
                'releaseYear' => 1977,
                'description' => 'Star Wars is a 1977 American epic space opera film directed by George Lucas and produced by Lucasfilm',
                'actors' => [$actors[0], $actors[1], $actors[2]],
                'directedBy' => $directors[0],
                'producer' => $producers[0],
                'writer' => $writers[0],
                'composer' => $composers[0],
                'publisher' => $admin,
            ],
            [
                'name' => 'Star Trek',
                'slogan' => 'The Next Generation',
                'genres' => Genres::matchIdAndGenre($genres['science_fiction']),
                'releaseYear' => 1982,
                'description' => 'Star Trek is a 2009 American science fiction film directed by J.J. Abrams and produced by Lucasfilm',
                'actors' => [$actors[0], $actors[1]],
                'directedBy' => $directors[1] ?? $directors[0],
                'producer' => $producers[1] ?? $producers[0],
                'writer' => $writers[1] ?? $writers[0],
                'composer' => $composers[1] ?? $composers[0],
                'publisher' => $admin,
            ],
            [
                'name' => 'Titanic',
                'slogan' => 'The heart will go on',
                'genres' => [Genres::matchIdAndGenre($genres['romance']), Genres::matchIdAndGenre($genres['drama'])],
                'releaseYear' => 1997,
                'description' => 'Titanic is a 1997 American epic romance and drama film directed by James Cameron and produced by 20th Century Fox',
                'actors' => [$actors[1], $actors[2]],
                'directedBy' => $directors[2] ?? $directors[0],
                'producer' => $producers[2] ?? $producers[0],
                'writer' => $writers[2] ?? $writers[0],
                'composer' => $composers[2] ?? $composers[0],
                'publisher' => $admin,
            ]
        ];

        foreach ($filmData as $film) {
            $filmEntity = new Film();
            $filmEntity->setName($film['name']);
            $filmEntity->setSlogan($film['slogan']);
            $filmEntity->setReleaseYear($film['releaseYear']);
            $filmEntity->setDescription($film['description']);
            $filmEntity->setGenres($film['genres']);
            $filmEntity->addActor($film['actors']);
            $filmEntity->setDirectedBy($film['directedBy']);
            $filmEntity->setProducer($film['producer']);
            $filmEntity->setWriter($film['writer']);
            $filmEntity->setComposer($film['composer']);
            $filmEntity->setPublisher($film['publisher']);

            $manager->persist($filmEntity);
            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            PersonFixtures::class,
        ];
    }
}
