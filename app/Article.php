<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $fillable = [
        'title',
        'body'
    ];

    // usersテーブルへの紐付け
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\user');
    }

    // likeテーブルへの紐付け
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    // tagsテーブルへの紐付け
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    // ユーザーがいいね済みかの判定
    public function isLikeBy(?User $user): bool
    {
        return $user
            ? (bool)$this->likes->where('id', $user->id)->count()
            : false;
    }

    // 現在のいいね数を算出する
    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }
}
