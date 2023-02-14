<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Report
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $guid
 * @property string $user_hash
 * @property int $families_count
 * @property int $family_errors
 * @property Carbon $created_at
 *
 * @property ReportFamily[] $reportFamilies
 */
class Report extends BaseModel
{

    //public $url;

    use SoftDeletes;

    public function reportFamilies()
    {
        return $this->hasMany(ReportFamily::class, 'report_id', 'id');
    }
}
