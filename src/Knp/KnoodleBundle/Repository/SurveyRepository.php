<?php

namespace Knp\KnoodleBundle\Repository;
use Doctrine\ORM\EntityRepository;

class SurveyRepository extends EntityRepository
{

    public function build()
    {
    }

    function findAllOrderByCreation()
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT s FROM KnpKnoodleBundle:Survey AS s ORDER BY s.createdAt')
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
            ->getEntityManager()
            ->createQuery('SELECT survey FROM KnpKnoodleBundle:Survey survey ORDER BY survey.createdAt DESC')
            ->setMaxResults($limit)
            ->execute()
        ;
    }

}
