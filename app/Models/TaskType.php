<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TaskType
 * @package App\Models
 *
 * @property string $title
 * @property string $key
 * @property string $description
 */
class TaskType extends BaseModel
{
    use SoftDeletes;


    protected $table = 'task_types';
    public $timestamps = true;

    protected $fillable = ['title', 'key', 'description'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

}
