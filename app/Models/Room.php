<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Room extends Model
{
    use HasFactory, Sluggable;

    /**
     * @var string[]
     */
    protected $fillable = ['title', 'user_id', 'slug'];
    /**
     * @var string[]
     */
    protected $appends = [
        'timeAgo',
        'path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * relation with user model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * relation with RoomMember model
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RoomMembers::class, 'room_id')->latest();
    }

    /**
     * relation with message model
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class, 'room_id');
    }

    /**
     * return url room
     * @return string
     */
    public function getPathAttribute()
    {
        return route('room.message.view', $this->slug);
    }

    /**
     * return time ago created
     * @return string
     */
    protected function getTimeAgoAttribute()
    {
        return Carbon::parse($this->created_at)->ago();
    }
}
