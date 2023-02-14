<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FamilyComposition
 * @package App\Models
 *
 * @property int $id
 * @property string $item_name
 * @property string $description
 * @property string $extension
 * @property string $template
 * @property boolean $required
 */
class FamilyComposition extends BaseModel
{
    use SoftDeletes;

    protected $table = "family_compositions";
    public $timestamps = true;
    protected $fillable = ['item_name', 'description', 'extension', 'template', 'required'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];


}
