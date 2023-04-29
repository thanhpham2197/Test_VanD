<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        "store_id"
    ];

    /**
     * Condition search list
     */
    public function scopeSearchList($query, $request)
    {
        if($request->has('name')) {
            $name = $request->name;
            $query->where('name', 'like', "%{$name}%");
        }

        if($request->has('description')) {
            $description = $request->description;
            $query->where('description', 'like', "%{$description}%");
        }

    }
}
