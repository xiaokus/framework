<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-18 18:03
 */
namespace Notadd\Foundation\Mail\Controllers;

use Notadd\Foundation\Mail\Handlers\GetHandler;
use Notadd\Foundation\Mail\Handlers\SetHandler;
use Notadd\Foundation\Mail\Handlers\TestHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class MailController.
 */
class MailController extends Controller
{
    /**
     * Get handler.
     *
     * @param GetHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function get(GetHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
    
    /**
     * Set handler.
     *
     * @param \Notadd\Foundation\Mail\Handlers\SetHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse * @throws \Exception
     * @throws \Exception
     */
    public function set(SetHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Test Handler.
     *
     * @param \Notadd\Foundation\Mail\Handlers\TestHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function test(TestHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
