<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 *
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @param Question $entity
     * @param bool $flush
     * @return void
     */
    public function save(Question $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Question $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Question $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllQuestion1AndQuestion2Count(): array
    {
        return $this
            ->createQueryBuilder('q')
            ->select('
            COUNT(q.email) AS email_count,
            SUM(CASE WHEN q.question1 = 1 THEN 1 ELSE 0 END) AS question1_1_count,
            SUM(CASE WHEN q.question1 = 2 THEN 1 ELSE 0 END) AS question1_2_count,
            SUM(CASE WHEN q.question1 = 3 THEN 1 ELSE 0 END) AS question1_3_count,
            SUM(CASE WHEN q.question1 = 4 THEN 1 ELSE 0 END) AS question1_4_count,
            SUM(CASE WHEN q.question1 = 5 THEN 1 ELSE 0 END) AS question1_5_count,
            SUM(CASE WHEN q.question2 = true THEN 1 ELSE 0 END) AS question2_yes_count,
            SUM(CASE WHEN q.question2 = false THEN 1 ELSE 0 END) AS question2_no_count,
            COUNT(q) - COUNT(q.question2) AS question2_null_count
            ')
        ->getQuery()
        ->getArrayResult();
}



}
