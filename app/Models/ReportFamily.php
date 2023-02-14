<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ReportFamily
 * @package App\Models
 *
 * @property int $id
 * @property int $report_id
 * @property int $family_id
 * @property string $name
 * @property string $version
 * @property string $guid
 * @property string $current_version
 * @property string $url
 * @property string $status_id
 *
 * @property Report $report
 * @property BICase $BICase
 */
class ReportFamily extends BaseModel
{
    use SoftDeletes;

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function BICase()
    {
        return $this->belongsTo(BICase::class, 'family_id', 'id')->withTrashed();
    }
}
