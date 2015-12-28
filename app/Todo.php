<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Todo extends Model
{
    /**
     * Properties must be mass asignment.
     *
     * @var array
     */
    protected $fillable = ['description', 'owner_id', 'is_done'];

    /**
     * A todo belongs to an user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
