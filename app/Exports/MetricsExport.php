<?php

namespace App\Exports;

use App\Http\Requests\MetricsSearchRequest;
use App\Services\MetricsService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MetricsExport implements FromCollection, WithHeadings
{
    public function __construct(MetricsSearchRequest $request, MetricsService $metricsService)
    {
        $this->request = $request;
        $this->metricsService = $metricsService;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = $this->metricsService->_list($this->request);
        return $data['list'];
    }

    public function headings() :array
    {
        return ["ID", "Семейства", "Версия", "Раздел", "Категория", "Количество загрузок"];
    }
}
