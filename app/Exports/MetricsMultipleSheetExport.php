<?php

namespace App\Exports;


use App\Http\Requests\MetricsSearchRequest;
use App\Services\MetricsService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;
use App\Exports\MetricsAllExport;
use App\Exports\Metrics;
use App\Exports\AllMetrics;

class MetricsMultipleSheetExport implements WithMultipleSheets
{

    use Exportable;

    public function __construct(MetricsSearchRequest $request, MetricsService $metricsService)
    {
        $this->request = $request;
        $this->metricsService = $metricsService;
    }

    public function sheets() : array
    {
        $sheets = [];
        array_push($sheets, new AllMetrics());
        array_push($sheets, new Metrics($this->request, $this->metricsService));
        return $sheets;
    }

}
