<?php
/**
 * Created by PhpStorm.
 * User: rogerio
 * Date: 27/11/14
 * Time: 21:43
 */

namespace Code\Sistema\Service;

use Code\Sistema\Entity\Interfaces\ProdutoInterface;
use Code\Sistema\Entity\Produto;
use Doctrine\ORM\EntityManager;
use \Code\Sistema\Service\Interfaces\ProdutoServiceInterface;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;

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
            return $this->toArray($repository->findAll());
        }

        public function getProdutos($page, $limitRegs)
        {
            $inicial = ($page > 1) ? ($page - 1) * $limitRegs : 0;

            $repository = $this->em->getRepository('Code\Sistema\Entity\Produto');
            return $this->toArray($repository->listProdutos($inicial, $limitRegs));
        }

        public function search($page, $limitRegs, $search)
        {
            $inicial = ($page > 1) ? ($page - 1) * $limitRegs : 0;

            $repository = $this->em->getRepository('Code\Sistema\Entity\Produto');
            return $this->toArray($repository->search($inicial, $limitRegs, $search));
        }

        public function findById($id)
        {
            try
            {
                $repository = $this->em->getRepository('Code\Sistema\Entity\Produto');
                $produto = $repository->find($id);
                if(!$produto)
                    throw new InvalidArgumentException("Produto nao existe!");

                return $this->getData($produto);
            }
            catch(\Exception $e)
            {
                return array(
                    'message', $e->getMessage(),
                    'id' => 0,
                    'nome' => '',
                    'descricao' => '',
                    'valor' => ''
                );
            }
        }

        private function toArray(array $arrayObject)
        {
            $newArray = array();
            foreach($arrayObject as $key => $object){
                $newArray[$key]['id'] = $object->getId();
                $newArray[$key]['nome'] = $object->getNome();
                $newArray[$key]['descricao'] = $object->getDescricao();
                $newArray[$key]['valor'] = $object->getValor();
            }

            return $newArray;
        }

        public function getNumProdutos()
        {
            $repository = $this->em->getRepository('Code\Sistema\Entity\Produto');
            return count($repository->findAll());
        }

        public function getNumProdutosSearch($search)
        {
            $repository = $this->em->getRepository('Code\Sistema\Entity\Produto');
            return count($repository->findAllSearch($search));
        }

        private function getData(Produto $produto)
        {
            $arrayProduto['id'] = $produto->getId();
            $arrayProduto['nome'] = $produto->getNome();
            $arrayProduto['descricao'] = $produto->getDescricao();
            $arrayProduto['valor'] = $produto->getValor();

            return $arrayProduto;
        }

} 