<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-16 17:56
 */
namespace Notadd\Foundation\Navigation\Handlers\Item;

use Illuminate\Container\Container;
use Notadd\Foundation\Navigation\Models\Item;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class EditHandler.
 */
class EditHandler extends SetHandler
{
    /**
     * ArticleEditorHandler constructor.
     *
     * @param \Illuminate\Container\Container           $container
     * @param \Notadd\Foundation\Navigation\Models\Item $item
     */
    public function __construct(
        Container $container,
        Item $item
    ) {
        parent::__construct($container);
        $this->model = $item;
    }

    /**
     * Http code.
     *
     * @return int
     */
    public function code()
    {
        return 200;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        return $this->model->structure($this->request->input('group_id'));
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::article.update.fail'),
        ];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $article = $this->model->newQuery()->find($this->request->input('id'));
        $article->update([
            'color'      => $this->request->input('color'),
            'enabled'    => $this->request->input('enabled'),
            'group_id'   => $this->request->input('group_id'),
            'icon_image' => $this->request->input('icon_image'),
            'link'       => $this->request->input('link'),
            'order_id'   => $this->request->input('order_id'),
            'parent_id'  => $this->request->input('parent_id'),
            'target'     => $this->request->input('target'),
            'title'      => $this->request->input('title'),
            'tooltip'    => $this->request->input('tooltip'),
        ]);

        return true;
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans('content::article.update.success'),
        ];
    }
}
