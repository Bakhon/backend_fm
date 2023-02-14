<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder query()
 * @method static \Illuminate\Database\Eloquent\Builder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder where($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder create($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder leftJoin($table, $first, $operator = null, $second = null)
 */
class BaseModel extends Model
{

    /**
     * @return string
     */
    public static function tableName()
    {
        return ((new static)->getTable());
    }

}
