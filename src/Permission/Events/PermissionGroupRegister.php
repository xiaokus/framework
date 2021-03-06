<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-05-26 10:57
 */
namespace Notadd\Foundation\Permission\Events;

use Illuminate\Container\Container;
use Notadd\Foundation\Permission\PermissionManager;

/**
 * Class PermissionGroupRegister.
 */
class PermissionGroupRegister
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Notadd\Foundation\Permission\PermissionManager
     */
    protected $permission;

    /**
     * PermissionRegister constructor.
     *
     * @param \Illuminate\Container\Container                 $container
     * @param \Notadd\Foundation\Permission\PermissionManager $permission
     */
    public function __construct(Container $container, PermissionManager $permission)
    {
        $this->container = $container;
        $this->permission = $permission;
    }
}
