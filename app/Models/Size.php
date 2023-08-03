<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Size
 * @package App\Models\Size
 * 
 * @author Muhammad Imran Israr (mimranisrar6@gmail.com)
 */
class Size extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'product_id'
    ];

    /**
     * Get the associated product for this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the options associated with this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class);
    }
}
