<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Http\Server\GoldServer;
use App\Image;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function getPostsByCateId(Request $request)
    {

        $posts = Post::where(['cate_id' => $request->cate_id, 'status' => 1])->with(['user', 'images'])->get();
        $user = Auth::user();
        if (!$user) {
            $posts->map(function ($item, $key) {
                return $item->links = null;
            });
        } else {
            $posts->map(function ($post) use ($user) {
                if ($user->id != $post->user->id) {
                    if (!$post->buyers->contains($user)) {
                        return $post->links = null;
                    }
                }
            });
        }
        return new PostCollection(new PostResource($posts));
    }

    public function addPost(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $posts = $user->post;

            if ($posts) {
                $newPosts = $posts->filter(function ($post) {
                    return $post->status == 0;
                });
                if ($newPosts->count() > 3) {
                    $msg = '你有还有' . $newPosts->count() . '条投稿没通过，请等待';
                    return response()->json(['msg' => $msg], 444);
                }
            }

        }
        $this->validate($request, [
            'title' => 'required|unique:posts|max:255|min:3',
            'gold' => 'int|between:40,120'
        ], [
            'title.required' => '不能没有标题',
            'title.unique' => '标题已经存，请更换',
            'title.max' => '标题长度不能超过255',
            'title.min' => '标题长度不能短于3',
            'gold.int' => '金币必须是整数',
            'gold.between' => '40 < 金币 < 120',
        ]);
        $post = new Post();
        $post->fill($request->all());
        if ($post->save()) {
            return response()->json(['post_id' => $post->id]);
        }
    }

    public function addPostImages(Request $request)
    {
        $disk = Storage::disk('qiniu');
        $image = $request->image;
        $r = $disk->put('postImage', $image);               //上传文件
        if ($r) {
            $image = new Image();
            $image->url = $r;
            $image->post_id = $request->post_id;
            if ($image->save()) {
                return;
            };
            $disk->delete($r);
        }
    }

    public function delPost(Post $post)
    {
        if ($post->delete()) {
            $this->delPostImages($post->id);
        }
    }

    public function delPostImages($post_id)
    {
        $imges = Image::where('post_id', $post_id)->get();
        $imges->map(function ($v) {
            $this->removeQiniuImage($v->name);
            $v->delete();
        });
    }

    public function removeQiniuImage($name)
    {
        $disk = Storage::disk('qiniu');
        $disk->delete($name);
    }

    public function getLinks(Request $request)
    {
        $post_id = $request->post_id;
        $user = Auth::user();
        $post = Post::find($post_id);

        if ($post) {

            if ($post->buyers->contains($user)) {
                return response()->json(['msg' => '获取成功', 'links' => $post->links, 'status' => true]);
            }
            $residue_gold = $user->gold - $post->gold;
            if ($residue_gold >= 0) {

                $user->gold = $residue_gold;
                $post->buyers()->attach($user);
                if ($user->save()) {
                    GoldServer::addGold($post->user_id, $post->gold * 0.7);
                    $messages = '获取成功';
                    return response()->json(['msg' => $messages, 'links' => $post->links, 'status' => true]);
                }

            } else {
                $messages = '金币不够, 你只有' . $user->gold . '积分！  相差' . -$residue_gold;
                return response()->json(['msg' => $messages, 'status' => false]);

            }
        }


    }

    function PostNotice()
    {
        return [
            'bar1' => [
                'text' => '仅供学习交流使用，请在安装后24小时内删除请勿用于商业及非法用途！产生一切非法后果与作者无关！如不接受，请勿下载',
                'scrollable' =>true,
                'delay' => 1000
            ],
            'bar2' => [
                'text' => '本站所有资源均是网上搜集或网友上传提供,本站内容仅供观摩学习交流之用，将不对任何资源负法律责任，如有侵权请及时联系 ',
                'scrollable' =>true,
                'delay' => 1000
            ]
        ];


    }
}
