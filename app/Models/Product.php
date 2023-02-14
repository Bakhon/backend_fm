<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Product
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class Product extends BaseModel
{
    use SoftDeletes;
}
