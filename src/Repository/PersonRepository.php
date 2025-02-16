<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Dto\Entity\Query\PersonQueryDto;
use App\Repository\Traits\ActionTrait;
/**
 * @extends ServiceEntityRepository<Person>
 */
class PersonRepository extends ServiceEntityRepository
{
	use ActionTrait;

	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Person::class);
	}
	public function filterByQueryParams(PersonQueryDto $personQueryDto): array
	{

		$search = $personQueryDto->search;
		$offset = $personQueryDto->offset ?? 0;
		$limit = $personQueryDto->limit ?? 'all';
		$sortBy = $personQueryDto->sortBy;
		$order = $personQueryDto->order;

		$queryBuilder = $this->createQueryBuilder('p')->where('1 = 1');
		;

		if (!empty($search)) {
			$search = trim(strtolower($search));
			$queryBuilder
				->where($queryBuilder->expr()->like('LOWER(p.firstname)', ':search'))
				->orWhere($queryBuilder->expr()->like('LOWER(p.lastname)', ':search'))
				->setParameter('search', "%{$search}%");
		}
		if ($sortBy === 'age') {
			$queryBuilder
				->andWhere('p.birthday IS NOT NULL');
		}
		$queryBuilder
			->orderBy("p.{$sortBy}", $order);
		if ($limit !== 'all') {
			$queryBuilder
				->setMaxResults($limit)
				->setFirstResult($offset);
		}

		return $queryBuilder->getQuery()->getResult();
	}

	public function total(): int
	{
		return $this->createQueryBuilder('p')
			->select('COUNT(p.id)')
			->getQuery()
			->getSingleScalarResult()
		;
	}
}
