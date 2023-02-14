<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CaseVersion
 * @package App\Models
 *
 * @property int $id
 * @property string $hash
 * @property string $name
 * @property int $type_id
 * @property int $case_id
 * @property int $version
 * @property string $meta_data
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property bool $is_active
 *
 * @property BICase $BLCase
 * @property File $file
 * @property FamilyComposition $familyComposition
 */
class CaseVersion extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'hash',
        'name',
        'type_id',
        'case_id',
        'version',
    ];

    public function BLCase()
    {
        return $this->belongsTo(BICase::class, 'case_id', 'id')->withTrashed();
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'hash', 'hash');
    }

    public function familyComposition()
    {
        return $this->belongsTo(FamilyComposition::class, 'type_id', 'id');
    }
}
