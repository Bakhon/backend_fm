<?php

namespace App\Exports;

use App\Models\Report;
use App\Reference\Constants;
use App\Services\KeyCloakService;
use App\Services\ReportService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

/**
 * Class ReportExport
 * @package App\Exports
 */
class ReportExport implements FromView
{
    protected $report;
    protected $reportService;

    public function __construct(Report $report, ReportService $reportService)
    {
        $this->report = $report;
        $this->reportService = $reportService;
    }

    public function view(): View
    {
        $data = $this->report->toArray();

        $author = (new KeyCloakService())->getKeyCloakUser($this->report->user_hash);
        $data['author'] = $author->firstName . ' ' . $author->lastName;
        $data['created_at'] = $this->report->created_at->format(Constants::DATE_TIME_FORMAT);

        $data['reportFamilies'] = $this->report->reportFamilies;

        return view('exports.report', [
            'report' => $data
        ]);
    }
}
