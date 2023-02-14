<?php

namespace App\Exports;

use App\Http\Requests\ReportSearchRequest;
use App\Services\ReportService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

/**
 * Class ReportsExport
 * @package App\Exports
 */
class ReportsExport implements FromCollection, WithHeadings
{
    protected $request;
    protected $reportService;

    public function __construct(ReportSearchRequest $request, ReportService $reportService)
    {
        $this->request = $request;
        $this->reportService = $reportService;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = $this->reportService->_list($this->request);
        return $data['list'];
    }

    public function headings() :array
    {
        return ["id", "guid", "Название", "Автор", "Семейства", "Ошибок", "Дата и время создания"];
    }
}
