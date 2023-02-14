<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Class File
 * @package App\Models
 *
 * @property int $id
 * @property string $hash
 * @property string $name
 * @property string $extension
 * @property string $original_name
 * @property string $mime_type
 * @property string $path
 * @property string $user_hash
 * @property int $case_file_id
 * @property Carbon $created_at
 *
 * @property CaseVersion[] $caseVersions
 */
class File extends BaseModel
{
    protected $fillable = [
        'id',
        'hash',
        'name',
        'extension',
        'original_name',
        'mime_type',
        'path',
        'count',
    ];

    public function caseVersions()
    {
        return $this->hasMany(CaseVersion::class, 'hash', 'hash');
    }
    
    public function userFiles()
    {
        return $this->hasMany(UserFiles::class, 'file_id', 'id');
    }

}