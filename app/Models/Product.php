<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var $fillable
     */
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query)
    {
        if (request('product_name')) {
            $query->where('name', 'like', '%'.request('product_name').'%');
        }

        if (request('created_date')) {
            $query->whereDate('created_at', request('created_date'));
        }

        return $query;
    }
}
