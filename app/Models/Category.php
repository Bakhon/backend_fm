<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 * @package App\Models
 *
 * @property integer $id
 * @property integer $creator_id
 * @property string $full_name
 * @property string $name
 * @property integer $version
 * @property integer $parent_id
 * @property integer $system
 * @property integer $key
 * @property integer $_ltr
 * @property integer $_rgt
 * @property integer $number
 *
 * @property Section[] $sections
 */
class Category extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'creator_id',
        'full_name',
        'name',
        'system',
        'number',
        '_lft',
        '_rgt',
        'parent_id'
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function sections()
    {
        return $this->belongsToMany(Section::class, SectionCategory::class)->withTimestamps();
    }
}
