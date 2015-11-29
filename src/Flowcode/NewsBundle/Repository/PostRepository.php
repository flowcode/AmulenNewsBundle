<?php

namespace Flowcode\NewsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of PostRepository
 *
 * @author Juan Manuel Agüero <jaguero@flowcode.com.ar>
 */
class PostRepository extends EntityRepository {

    public function findAllEnabled() {
        return $this->createQueryBuilder("p");
    }

}
