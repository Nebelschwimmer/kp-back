<?php

namespace App\Repository;

use App\Dto\Entity\Query\FilmQueryDto;
use App\Entity\Film;
use App\Repository\Traits\ActionTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Film>
 */
class FilmRepository extends ServiceEntityRepository
{
	use ActionTrait;

	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Film::class);
	}

	public function filterByQueryParams(FilmQueryDto $filmQueryDto): array
	{
		$search = $filmQueryDto->search;
		$offset = $filmQueryDto->offset;
		$limit = $filmQueryDto->limit;
		$sortBy = $filmQueryDto->sortBy;
		$order = $filmQueryDto->order;

		$queryBuilder = $this->createQueryBuilder('f')->where('1 = 1');;

		if (!empty($search)) {
			$search = trim(strtolower($search));
			$queryBuilder
				->where($queryBuilder->expr()->like('LOWER(f.name)', ':search'))
				->orWhere($queryBuilder->expr()->like('f.releaseYear', ':search'))
				->setParameter('search', "%{$search}%");
		}
		$queryBuilder
			->orderBy("f.{$sortBy}", $order)
			->setFirstResult($offset)
			->setMaxResults($limit);
		return $queryBuilder->getQuery()->getResult();
	}

	public function total(): int
	{
		return $this
			->createQueryBuilder('f')
			->select('COUNT(f.id)')
			->getQuery()
			->getSingleScalarResult();
	}

	public function findLatest(int $count): array
	{
		return $this
			->createQueryBuilder('f')
			->orderBy('f.releaseYear', 'DESC')
			->setMaxResults($count)
			->getQuery()
			->getResult();
	}

	// public function findWithSimilarGenres(array $genreIds): array
	// {
	// 	$queryBuilder = $this->createQueryBuilder('f');
	
	// 	$orX = $queryBuilder->expr()->orX();
	// 	foreach ($genreIds as $genreId) {
	// 		$orX->add("JSON_CONTAINS(f.genres, :genre_$genreId) = 1");
	// 		$queryBuilder->setParameter("genre_$genreId", $genreId);
	// 	}
	
	// 	$queryBuilder->where($orX);
	
	// 	return $queryBuilder->getQuery()->getResult();
	// }
}
