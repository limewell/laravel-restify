<?php

namespace BhavinGajjar\LaravelRestify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     * @var string[]
     */
    protected $guarded = ['id'];

    protected $fillable = [
        'title',
    ];
}
