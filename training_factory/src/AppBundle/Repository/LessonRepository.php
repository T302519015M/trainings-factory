<?php

namespace AppBundle\Repository;

/**
 * LessonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LessonRepository extends \Doctrine\ORM\EntityRepository
{
    //maak les aan
    public function createLesson($lesson){
        $this->getEntityManager()->persist($lesson);
        $this->getEntityManager()->flush();
    }

    //update les
    public function updateLesson($lesson){
        $this->getEntityManager()->persist($lesson);
        $this->getEntityManager()->flush();
    }

    //delete les
    public function deleteLesson($lesson){
        $this->getEntityManager()->remove($lesson);
        $this->getEntityManager()->flush();
    }

}
