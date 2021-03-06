<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-16 17:56
 */
namespace Notadd\Foundation\Navigation\Handlers\Item;

use Notadd\Foundation\Navigation\Models\Item;
use Notadd\Foundation\Passport\Abstracts\Handler;

/**
 * Class FetchHandler.
 */
class FetchHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->success()
            ->withData((new Item())->structure($this->request->input('group')))
            ->withMessage('content::category.fetch.success');
    }
}
