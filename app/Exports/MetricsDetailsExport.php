<?php

namespace App\Exports;

use App\Services\MetricsService;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Reference\Constants;
use App\Services\KeyCloakService;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Http\Requests\MetricsSearchRequest;
use App\Http\Requests\MetricIdRequest;

class MetricsDetailsExport implements FromCollection, WithHeadings
{

    public function __construct(MetricIdRequest $request, MetricsService $metricService)
    {
        $this->request = $request;
        $this->metricsService = $metricService;
    }

    public function collection()
    {
        $data = $this->metricsService->show_one_details($this->request);
        return $data['list'];
    }

    public function headings() :array
    {
        return [ "ID",  "Семейство",  "Раздел", "Категория", "Пользователь" , "Email", "Дата загрузки", "Количество загрузок" ];
    }
}
