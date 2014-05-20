<?php

namespace Knp\KnoodleBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class SurveyRepository extends EntityRepository
{

    const QUERY_ALIAS = 's';

    public function findAllOrderByCreation()
    {
        return $this
            ->buildOrderByCreation()
            ->getQuery()
            ->execute();
        ;
    }


    public function findAllPopular()
    {
        return $this
            ->getEntityManager()
            ->createQuery(<<<DQL
SELECT survey, COUNT(answer) HIDDEN n
FROM KnpKnoodleBundle:Survey survey
LEFT JOIN survey.questions question
LEFT JOIN question.answers answer
GROUP BY survey.id
ORDER BY n DESC
DQL
        )
            ->execute();
    }

    public function findAllOrderByCreationLimitedBy($limit = 10)
    {
        $limit = (int)$limit > 0 ? (int)$limit : 1;

        return $this
            ->buildOrderByCreation()
            ->getQuery()
            ->setMaxResults($limit)
            ->execute()
            ;
    }

    public function findAllOrderByCreationAndNamedLike($name)
    {
        $qb = $this->buildOrderByCreation();
        $qb = $this->buildByNameLike($name, $qb)
        ;

        return $qb
            ->getQuery()
            ->execute()
        ;
    }

    /**
     * build
     *
     * @return QueryBuilder
     */
    private function buildOrderByCreation(QueryBuilder $qb = null)
    {
        if(null === $qb) {
            $qb = $this->createQueryBuilder(self::QUERY_ALIAS);
        }

        return $qb
            ->orderBy('s.createdAt', 'DESC')
        ;
    }

    /**
     * buildByNameLike
     *
     * @param string $name
     * @param QueryBuilder $qb
     * @return void
     */
    private function buildByNameLike($name, QueryBuilder $qb = null){
        if(null === $qb) {
            $qb = $this->createQueryBuilder(self::QUERY_ALIAS);
        }

        return $qb
            ->where('s.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
        ;
    }


}
