<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 12:41
 */
namespace Notadd\Foundation\Permission;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;

/**
 * Class PermissionTypeManager.
 */
class PermissionTypeManager
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $types;

    /**
     * PermissionTypeManager constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->types = new Collection();
        $this->initialize();
    }

    /**
     * @param array $attributes
     */
    public function extend(array $attributes)
    {
        if (PermissionType::validate($attributes) && !$this->types->has($attributes['identification'])) {
            $this->types->put($attributes['identification'], PermissionType::createFromAttributes($attributes));
        }
    }

    public function initialize()
    {
        $this->types->put('global', PermissionType::createFromAttributes([
            'description'    => '全局权限类型。',
            'identification' => 'global',
            'name'           => '全局',
        ]));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function list()
    {
        return $this->types();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function types()
    {
        return $this->types;
    }
}
