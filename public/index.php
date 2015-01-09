<?php

//Inclui o arquivo de configuração
require_once __DIR__ . "/../bootstrap.php";

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


$app['produtoService'] = function() use ($em){
    $produtoEntity = new \Code\Sistema\Entity\Produto();

    return new \Code\Sistema\Service\ProdutoService($produtoEntity, $em);
};


/************ROTAS DA API**************/

$app->get('/api/produtos', function () use ($app) {
    $produtos = $app['produtoService']->findAll();
    return $app->json($produtos);
});

$app->get('/api/produtos/{id}', function ($id) use ($app) {
    $produto = $app['produtoService']->findById($id);
    return $app->json($produto);
});

$app->post('/api/produtos', function(Request $request) use ($app){
    $data['nome'] = $request->get('nome');
    $data['descricao'] = $request->get('descricao');
    $data['valor'] = $request->get('valor');

    if($app['produtoService']->insert($data)){
        return $app->json(['success'=>true, 'messages' => ['Inserido com sucesso']]);
    }

    $errors = [
        'success' => false,
        'messages' => [
            'Não foi possível efetuar o cadastro',
        ],
    ];
    return $app->json($errors);
});

$app->put('/api/produtos/{id}', function(Request $request, $id) use ($app){
    $data['id'] = $id;
    $data['nome'] = $request->get('nome');
    $data['descricao'] = $request->get('descricao');
    $data['valor'] = $request->get('valor');

    if($app['produtoService']->update($data)){
        return $app->json(['success'=>true, 'messages' => ['Alterado com sucesso']]);
    }

    $errors = [
        'success' => false,
        'messages' => [
            'Não foi possível alterar o cadastro',
        ],
    ];
    return $app->json($errors);
});

$app->delete('/api/produtos/{id}', function($id) use ($app){

    if($app['produtoService']->delete($id)){
        return $app->json(['success'=>true, 'messages' => ['Removido com sucesso']]);
    }

    $errors = [
        'success' => false,
        'messages' => [
            'Não foi possível remover o cadastro',
        ],
    ];
    return $app->json($errors);
});

/**********FIM ROTAS DA API************/



//Cria rota para a index
$app->get('/', function () use ($app) {

    return $app['twig']->render('home/index.twig', array(

    ));

})->bind('home');



//Cria a rota /produtos
$app->get('/produtos/listar/{page}', function (Request $request, $page) use ($app) {

    //Limite de registros
    $limitRegs = 2;

    $numProdutos = $app['produtoService']->getNumProdutos();

    $paginator = new \Code\Sistema\Helper\Paginator($page, $limitRegs, $numProdutos, $app['url_generator']->generate('produtos'));

    $produtos = $app['produtoService']->getProdutos($page, $limitRegs);

    return $app['twig']->render('produtos/index.twig', array(
        'produtos' => $produtos,
        'paginacao' => $paginator->createLinks()
    ));
})  ->bind('produtos')
    ->value('page', '');

//Cria a rota /produtos/buscar
$app->get('/produtos/buscar/{page}', function (Request $request, $page) use ($app) {

    $search = $request->get('search');

    //Limite de registros
    $limitRegs = 2;

    $numProdutos = $app['produtoService']->getNumProdutosSearch($search);

    $paginator = new \Code\Sistema\Helper\Paginator($page, $limitRegs, $numProdutos, $app['url_generator']->generate('buscar-produtos'), array('search' => $search));

    $produtos = $app['produtoService']->search($page, $limitRegs, $search);
    return $app['twig']->render('produtos/search.twig', array(
        'produtos' => $produtos,
        'paginacao' => $paginator->createLinks(),
        'search' => $search
    ));
})  ->bind('buscar-produtos')
    ->value('page', '');

//Cria a rota /produtos/novo
$app->get('/produtos/novo', function () use ($app) {
    return $app['twig']->render('produtos/novo.twig', array(

    ));
})->bind('novo-produto');

//Cria a rota /produtos/novo
$app->get('/produtos/editar/{id}', function ($id) use ($app) {
    return $app['twig']->render('produtos/editar.twig', array(
        'produto' => $app['produtoService']->findById($id),
    ));
})->bind('editar-produto');

//Cria a rota /produtos/novo
$app->get('/produtos/remover/{id}', function ($id) use ($app) {
    return $app['twig']->render('produtos/remover.twig', array(
        'produto' => $app['produtoService']->findById($id),
    ));
})->bind('remover-produto');



//Cria a rota de cadastro
$app->post('/produtos/cadastrar', function(Request $request) use ($app){

    $data = iterator_to_array($request->request->getIterator());
    if($app['produtoService']->insert($data)){
        $app['session']->getFlashBag()->add('messageSuccess', 'Cadastro efetuado com sucesso.');
        return $app->redirect('/produtos/listar');
    }

    $app['session']->getFlashBag()->add('messageFail', 'Houve um erro ao cadastrar.');
    return $app->redirect('/produtos/listar');

})->bind('cadastrar-produto');

//Cria a rota de edição
$app->put('/produtos/alterar', function(Request $request) use ($app){

    $data = iterator_to_array($request->request->getIterator());
    if($app['produtoService']->update($data)){
        $app['session']->getFlashBag()->add('messageSuccess', 'Cadastro alterado com sucesso.');
        return $app->redirect('/produtos/listar');
    }

    $app['session']->getFlashBag()->add('messageFail', 'Houve um erro ao alterar o registro.');
    return $app->redirect('/produtos/listar');

})->bind('alterar-cadastro-produto');

//Cria a rota de remocção
$app->delete('/produtos/delete', function(Request $request) use ($app){

    $data = iterator_to_array($request->request->getIterator());
    if($app['produtoService']->delete($data['id'])){
        $app['session']->getFlashBag()->add('messageSuccess', 'Cadastro removido com sucesso.');
        return $app->redirect('/produtos/listar');
    }

    $app['session']->getFlashBag()->add('messageFail', 'Houve um erro ao remover o registro.');
    return $app->redirect('/produtos/listar');

})->bind('remover-cadastro-produto');



Request::enableHttpMethodParameterOverride();
//Roda a aplicação
$app->run();