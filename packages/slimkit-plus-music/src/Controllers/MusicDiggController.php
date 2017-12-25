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

namespace Zhiyi\Component\ZhiyiPlus\PlusComponentMusic\Controllers;

use Illuminate\Http\Request;
use Zhiyi\Plus\Http\Controllers\Controller;
use Zhiyi\Component\ZhiyiPlus\PlusComponentMusic\Models\Music;

class MusicDiggController extends Controller
{
    /**
     * 点赞一个音乐.
     *
     * @author bs<414606094@qq.com>
     * @param  Request $request [description]
     * @param  int     $Music_id [description]
     * @return [type]           [description]
     */
    public function diggMusic(Request $request, Music $music)
    {
        $user = $request->user();
        if ($music->liked($user)) {
            return response()->json(static::createJsonData([
                'code' => 8003,
                'status' => false,
                'message' => '已赞过该歌曲',
            ]))->setStatusCode(422);
        }
        $like = $music->like($user);

        return response()->json(static::createJsonData([
            'status' => true,
            'message' => '点赞成功',
        ]))->setStatusCode(201);
    }

    /**
     * 取消点赞一个动态
     *
     * @author bs<414606094@qq.com>
     * @param  Request $request
     * @param  Music   $Music
     * @return [type]
     */
    public function cancelDiggMusic(Request $request, Music $music)
    {
        $user = $request->user();
        if (! $music->liked($user)) {
            return response()->json(static::createJsonData([
                'code' => 8004,
                'status' => false,
                'message' => '未对该歌曲点赞',
            ]))->setStatusCode(400);
        }

        $music->unlike($user);

        return response()->json(static::createJsonData([
            'status' => true,
            'message' => '取消点赞成功',
        ]))->setStatusCode(204);
    }
}
