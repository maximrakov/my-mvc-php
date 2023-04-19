<?php

namespace App\Test\Unit;

use App\Controllers\SimpleController;
use App\Core\Request;
use App\Core\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function test_is_seraching_callback_correct()
    {
        $request = new Request();
        $router = new Router($request);
        $router->get('/^\/{id}\/aba$/', [SimpleController::class, 'index']);
        $router->get('/^\/[dfs][jkl]\/test$/', [SimpleController::class, 'show']);
        $this->assertEquals($router->findCallback('/123/aba', 'GET'), [[SimpleController::class, 'index'], [123]]);
        $this->assertEquals($router->findCallback('/fl/test', 'GET'), [[SimpleController::class, 'show'], []]);
        $this->assertEquals($router->findCallback('/abacabadaba/test', 'GET'), []);
    }

    public function test_feature(){
        $request = new Request();
        echo $request->normalizeUrl('abacaba/abaca/{dd}/{bb}/aba/?afa=fdd/');
    }
}
