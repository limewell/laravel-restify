<?php

namespace Limewell\LaravelRestify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restify extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'restify';

    /**
     * The attributes that aren't mass assignable.
     * @var string[]
     */
    protected $guarded = ['id'];

    protected $fillable = [
        'title',
    ];
}
