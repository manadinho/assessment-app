<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Option
 * @package App\Models\Option
 * 
 * @author Muhammad Imran Israr (mimranisrar6@gmail.com)
 */
class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price'
    ];

    /**
     * Get the sizes associated with the model.
     *
     * This function establishes a many-to-many relationship between the current model
     * and the `Size` model. It retrieves all the sizes associated with the current model
     * through an intermediate pivot table, which contains the foreign keys of both models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * An instance of the `BelongsToMany` relationship, allowing you to work with the
     * associated `Size` models for the current model.
     */
    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class);
    }
}
