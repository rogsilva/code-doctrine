<?php
/**
 * Created by PhpStorm.
 * User: rogerio
 * Date: 27/11/14
 * Time: 20:12
 */

namespace Code\Sistema\Entity\Interfaces;


interface ProdutoInterface
{
    public function setId($id);
    public function getId();

    public function setNome($nome);
    public function getNome();

    public function setDescricao($descricao);
    public function getDescricao();

    public function setValor($valor);
    public function getValor();
}