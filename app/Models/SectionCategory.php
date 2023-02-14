<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class SectionCategory
 * @package App\Models
 *
 * @property int $id
 *
 * @property Section $section
 * @property Category $category
 */
class SectionCategory extends BaseModel
{
    use SoftDeletes;

    protected $table = 'section_category';

    protected $fillable = [
        'section_id',
        'category_id',
    ];

    public function section(): HasOne
    {
        return $this->hasOne(Section::class, 'id', 'section_id');
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
