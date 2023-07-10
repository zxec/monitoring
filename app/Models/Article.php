<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'published_at',
        'user_id',
    ];

    protected $dates = ['published_at'];

    /**
     * Scope queries to atricles that have been published.
     *
     * @param Builder $query
     * @return void
     */
    protected function scopePublished(Builder $query): void
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    /**
     * Scope queries to atricles that have been unpublished.
     *
     * @param Builder $query
     * @return void
     */
    protected function scopeUnPublished(Builder $query): void
    {
        $query->where('published_at', '>', Carbon::now());
    }

    /**
     * Get and set the published_at attribute.
     *
     * @return Attribute
     */
    protected function publishedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($date) => Carbon::parse($date)->format('Y-m-d'),
            set: fn ($date) => Carbon::createFromFormat('Y-m-d', $date),
        );
    }

    /**
     * An article is owned by user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * An tags is owned by articles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}
