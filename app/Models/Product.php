<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Product
 * @package App\Models\Product
 * 
 * @author Muhammad Imran Israr (mimranisrar6@gmail.com)
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Get the sizes associated with this item.
     *
     * This function defines a one-to-many relationship with the `Size` model.
     * It returns all the sizes associated with the current item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sizes(): HasMany
    {
        return $this->hasMany(Size::class);
    }
}
