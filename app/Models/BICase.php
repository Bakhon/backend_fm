<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BICase
 * @package App\Models
 *
 * @property int $id
 * @property int $category_id
 * @property int $section_id
 * @property int $composition_id
 * @property string $user_hash
 * @property int $status
 * @property int $version
 * @property string $name
 * @property string $guid
 * @property string $key
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property Category $category
 * @property Section $section
 */
class BICase extends BaseModel
{
    use SoftDeletes;

    protected $table = 'cases';

    /** @var array */
    public $type_collection;
    /** @var string */
    public $file_size;
    /** @var string */
    public $category_revit;
    /** @var string */
    public $family_placement;
    /** @var string */
    public $shared_parameters;
    /** @var string */
    public $author;
    /** @var string */
    public $family_template;
    /** @var string */
    public $system_parameters;
    /** @var string */
    public $count_subfamily;
    /** @var string */
    public $count_connector;
    /** @var array */
    public $files;
    /** @var array */
    public $caseVersions;
    /** @var array */
    public $caseAllVersions;

    protected $fillable = [
        'category_id',
        'section_id',
        'composition_id',
        'name',
        'guid',
        'creator_id',
        'edition',
        'version',
        'key',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
}
