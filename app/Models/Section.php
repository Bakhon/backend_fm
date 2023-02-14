<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Section
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property string $order
 * @property integer $parent_id
 * @property integer $creator_id
 *
 * @property Category[] $category
 */
class Section extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'creator_id',
        'name',
        'short_name',
        'order',
        'parent_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class,'section_category')->orderBy('name');
    }
}
