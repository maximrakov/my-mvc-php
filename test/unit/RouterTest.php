<?php

namespace app\test\unit;
use app\controllers\Controller;
use app\core\Request;
use app\core\Router;
use \PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function test_is_seraching_callback_correct() {
        $request = new Request();
        $router = new Router($request);
        $router->get('/{id}\/aba/', [Controller::class, 'index']);
        $router->get('/[dfs][jkl]\/test/', [Controller::class, 'show']);
        $this->assertEquals($router->findCallback('/123/aba','GET'), [[Controller::class, 'index'], [123]]);
        $this->assertEquals($router->findCallback('/fl/test','GET'), [[Controller::class, 'show'], []]);
        $this->assertEquals($router->findCallback('/abacabadaba/test','GET'), []);
    }
}