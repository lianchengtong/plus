<?php

/*
 * +----------------------------------------------------------------------+
 * |                          ThinkSNS Plus                               |
 * +----------------------------------------------------------------------+
 * | Copyright (c) 2017 Chengdu ZhiYiChuangXiang Technology Co., Ltd.     |
 * +----------------------------------------------------------------------+
 * | This source file is subject to version 2.0 of the Apache license,    |
 * | that is bundled with this package in the file LICENSE, and is        |
 * | available through the world-wide-web at the following url:           |
 * | http://www.apache.org/licenses/LICENSE-2.0.html                      |
 * +----------------------------------------------------------------------+
 * | Author: Slim Kit Group <master@zhiyicx.com>                          |
 * | Homepage: www.thinksns.com                                           |
 * +----------------------------------------------------------------------+
 */

namespace Zhiyi\Component\ZhiyiPlus\PlusComponentMusic\Installer;

use Zhiyi\Plus\Models\Comment;
use Zhiyi\Plus\Support\PackageHandler;
use Illuminate\Support\ServiceProvider;
use Zhiyi\Plus\Support\ManageRepository;
use Illuminate\Database\Eloquent\Relations\Relation;
use Zhiyi\Component\ZhiyiPlus\PlusComponentMusic\Models\Music;
use Zhiyi\Component\ZhiyiPlus\PlusComponentMusic\Models\MusicSpecial;
use function Zhiyi\Component\ZhiyiPlus\PlusComponentMusic\base_path as component_base_path;

class MusicServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Comment::observe(PlusCommentObserver::class);
        // MusicComment::observe(CommentObserver::class);

        $this->loadRoutesFrom(
            component_base_path('/router.php')
        ); // 路由注入

        $this->publishes([
            component_base_path('/resource') => $this->app->PublicPath().'/assets/music',
        ]); // 静态资源

        PackageHandler::loadHandleFrom('music', MusicPackageHandler::class); // 注入安装处理器
    }

    public function register()
    {
        Relation::morphMap([
            'musics' => Music::class,
            'music_specials' => MusicSpecial::class,
        ]);
        $this->app->make(ManageRepository::class)->loadManageFrom('音乐', 'music:list', [
            'route' => true,
            'icon' => 'MU',
        ]);
    }
}
