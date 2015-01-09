<?php
/**
 * Created by PhpStorm.
 * User: rogerio
 * Date: 08/01/15
 * Time: 11:47
 */

namespace Code\Sistema\Entity;


use Doctrine\ORM\EntityRepository;

class ProdutoRepository extends EntityRepository
{

    public function search($inicio, $limit, $busca)
    {
        return $this
            ->createQueryBuilder("p")
            ->where('p.nome LIKE :busca')
            ->orWhere('p.descricao LIKE :busca')
            ->setParameter('busca', "%{$busca}%")
            ->setFirstResult($inicio)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findAllSearch($busca)
    {
        return $this
            ->createQueryBuilder("p")
            ->where('p.nome LIKE :busca')
            ->orWhere('p.descricao LIKE :busca')
            ->setParameter('busca', "%{$busca}%")
            ->getQuery()
            ->getResult();
    }

    public function listProdutos($inicio, $limit)
    {
        return $this
                ->createQueryBuilder("p")
                ->setFirstResult($inicio)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
    }

} 