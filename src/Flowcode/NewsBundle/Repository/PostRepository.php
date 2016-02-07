<?php

namespace Flowcode\NewsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of PostRepository
 *
 * @author Juan Manuel Agüero <jaguero@flowcode.com.ar>
 */
class PostRepository extends EntityRepository
{

    public function findAllEnabled()
    {
        return $this->createQueryBuilder("p");
    }

    public function findPublishedQueryBuilder($filters = array())
    {
        $qb = $this->createQueryBuilder("p");

        $qb->where("p.enabled <= :enabled")->setParameter("enabled", true);
        $qb->Andwhere("p.published <= :today")->setParameter("today", new \DateTime());

        if(isset($filters['tag'])){
            $qb->join("p.tags", 't');
            $qb->Andwhere("t.slug = :tag")->setParameter("tag", $filters['tag']);
        }

        $qb->orderBy("p.published", "DESC");

        return $qb;
    }

    public function findPublished($filter = null, $max = 20, $page = 1)
    {
        $qb = $this->findPublishedQueryBuilder();

        $qb->setMaxResults($max);
        $qb->setFirstResult($page-1);

        return $qb->getQuery()->getResult();
    }

}
