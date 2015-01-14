<?php

namespace Code\Sistema\Entity;

use \Code\Sistema\Entity\Interfaces\ProdutoInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Code\Sistema\Entity\Categoria;

/**
 * @ORM\Entity(repositoryClass="Code\Sistema\Entity\ProdutoRepository")
 * @ORM\Table(name="produtos")
 */

class Produto implements ProdutoInterface
{
        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue
         */
        private $id;

        /**
         * @ORM\Column(type="string", length=255)
         */
        private $nome;

        /**
         * @ORM\Column(type="string", length=255)
         */
        private $descricao;

        /**
         * @ORM\Column(type="float")
         */
        private $valor;

        /**
         * @ORM\ManyToOne(targetEntity="Code\Sistema\Entity\Categoria")
         * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
         */
        private $categoria;

        /**
         * @ORM\ManyToMany(targetEntity="Code\Sistema\Entity\Tag")
         * @ORM\JoinTable(name="produtos_tags",
         *      joinColumns={@ORM\JoinColumn(name="produto_id", referencedColumnName="id")},
         *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
         *      )
         **/
        private $tags;

        public function __construct()
        {
            $this->tags = new ArrayCollection();
        }

        public function addTag($tags)
        {
            $this->tags->add($tags);
        }

        public function getTags()
        {
            return $this->tags;
        }

        public function setCategoria(Categoria $categoria)
        {
            $this->categoria = $categoria;
        }


        public function getCategoria()
        {
            return $this->categoria;
        }


        public function setId($id)
        {
            $this->id = $id;
            return $this;
        }

        public function getId()
        {
            return $this->id;
        }

        public function setDescricao($descricao)
        {
            $this->descricao = $descricao;
            return $this;
        }

        public function getDescricao()
        {
            return $this->descricao;
        }

        public function setNome($nome)
        {
            $this->nome = $nome;
            return $this;
        }

        public function getNome()
        {
            return $this->nome;
        }

        public function setValor($valor)
        {
            $this->valor = $valor;
            return $this;
        }

        public function getValor()
        {
            return $this->valor;
        }



} 