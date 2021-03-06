<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-05-25 15:14
 */
namespace Notadd\Foundation\Setting\Listeners;

use Notadd\Foundation\Permission\Abstracts\PermissionRegister as AbstractPermissionRegister;

/**
 * Class PermissionRegister.
 */
class PermissionRegister extends AbstractPermissionRegister
{
    /**
     * Handle Permission Register.
     */
    public function handle()
    {
        $this->manager->extend([
            'default'        => false,
            'description'    => '获取全局配置项',
            'group'          => 'global',
            'identification' => 'setting.get',
            'module'         => 'global',
        ]);
        $this->manager->extend([
            'default'        => false,
            'description'    => '获取全局配置项',
            'group'          => 'global',
            'identification' => 'setting.set',
            'module'         => 'global',
        ]);
    }
}
