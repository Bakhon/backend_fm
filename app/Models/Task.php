<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Task
 * @package App\Models
 *
 * @property int $id
 * @property int $creator_hash
 * @property int $executor_hash
 * @property string $content
 * @property string $title
 * @property int $status_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $comment
 */
class Task extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'creator_hash',
        'executor_hash',
        'content',
        'title',
        'status_id',
    ];
}
