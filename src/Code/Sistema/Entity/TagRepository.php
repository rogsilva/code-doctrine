<?php
/**
 * Created by PhpStorm.
 * User: rogerio
 * Date: 08/01/15
 * Time: 11:47
 */

namespace Code\Sistema\Entity;


use Doctrine\ORM\EntityRepository;


class TagRepository extends EntityRepository
{

    public function removeAssociationProduto($idTag)
    {
        $sql = "DELETE FROM produtos_tags WHERE tag_id = :id";
        $params = array('id' => $idTag);

        return $this->getEntityManager()->getConnection()->prepare($sql)->execute($params);
    }

} 