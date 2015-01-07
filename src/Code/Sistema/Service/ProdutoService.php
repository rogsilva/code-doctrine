<?php
/**
 * Created by PhpStorm.
 * User: rogerio
 * Date: 27/11/14
 * Time: 21:43
 */

namespace Code\Sistema\Service;

use Code\Sistema\Entity\Interfaces\ProdutoInterface;
use Doctrine\ORM\EntityManager;
use \Code\Sistema\Service\Interfaces\ProdutoServiceInterface;

class ProdutoService implements ProdutoServiceInterface
{

        private $produto;
        private $em;

        public function __construct(ProdutoInterface $produto, EntityManager $em)
        {
            $this->produto = $produto;
            $this->em = $em;
        }

        public function insert(array $data)
        {
            $this->produto->setNome($data['nome']);
            $this->produto->setDescricao($data['descricao']);
            $this->produto->setValor($data['valor']);

            $this->em->persist($this->produto);
            $this->em->flush();

            return $this->produto;
        }

        public function update(array $data)
        {
            $this->produto = $this->em->getReference('Code\Sistema\Entity\Produto', $data['id']);

            $this->produto->setNome($data['nome']);
            $this->produto->setDescricao($data['descricao']);
            $this->produto->setValor($data['valor']);

            $this->em->persist($this->produto);
            $this->em->flush();

            return $this->produto;
        }

        public function delete($id)
        {
            $this->produto = $this->em->getReference('Code\Sistema\Entity\Produto', $id);

            $this->em->remove($this->produto);
            $this->em->flush();

            return true;
        }

        public function findAll()
        {
            $repository = $this->em->getRepository('Code\Sistema\Entity\Produto');
            return $repository->findAll();
        }

        public function findById($id)
        {
            $repository = $this->em->getRepository('Code\Sistema\Entity\Produto');
            return $repository->find($id);
        }

} 