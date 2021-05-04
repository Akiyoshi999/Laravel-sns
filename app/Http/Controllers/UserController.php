<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(string $name)
    {
        $user = User::where('name', $name)->first()
            ->load([
                'articles.user',
                'articles.likes',
                'articles.tags',
            ]);

        $articles = $user->articles->sortByDesc('created_at');

        return view('users.show', [
            'user' => $user,
            'articles' => $articles
        ]);
    }

    // いいねした記事の返却
    public function likes(string $name)
    {
        $user = User::where('name', $name)->first()
            ->load([
                'likes.user',
                'likes.likes',
                'likes.tags',
            ]);
        $articles = $user->likes->sortByDesc('created_at');

        return view('users.likes', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    // フォローユーザー表示
    public function followings(string $name)
    {
        $user = User::where('name', $name)->first()
            ->load([
                'followings.followers'
            ]);
        $followings = $user->followings->sortByDesc('created_at');

        return view('users.followings', [
            'user' => $user,
            'followings' => $followings,
        ]);
    }

    // フォロワーユーザー表示
    public function followers(string $name)
    {
        $user = User::where('name', $name)->first()
            ->load([
                'followers.followers'
            ]);
        $followers = $user->followers->sortByDesc('created_at');

        return view('users.followers', [
            'user' => $user,
            'followers' => $followers,
        ]);
    }

    // フォロー
    public function follow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        // フォロー相手が自身じゃないことの確認
        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself');
        }

        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);

        return ['name' => $name];
    }

    // フォロー解除
    public function unfollow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        // フォロー相手が自身じゃないことの確認
        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself');
        }

        $request->user()->followings()->detach($user);

        return ['name' => $name];
    }
}
