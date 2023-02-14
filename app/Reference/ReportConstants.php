<?php

namespace App\Reference;

class ReportConstants
{
    /** @var int Семейство не зарегистрировано */
    public const NOT_REGISTERED = 0;

    /** @var int Семейство зарегистрировано, но не актуально */
    public const REGISTERED_AND_IRRELEVANT = 1;

    /** @var int Семейство зарегистрировано, но устаревшее */
    public const REGISTERED_AND_OUTDATED = 2;

    /** @var int Семейство зарегистрировано, но имена не совпадают */
    public const REGISTERED_WITHOUT_NAME_COINCIDENCE = 3;

    /** @var int Семейство зарегистрировано и валидно */
    public const REGISTERED_AND_RELEVANT = 4;

    /** @var array  */
    public const REPORT_STATUSES = [
        self::NOT_REGISTERED => 'Семейство не зарегистрировано',
        self::REGISTERED_AND_IRRELEVANT => 'Семейство зарегистрировано, но не актуально',
        self::REGISTERED_AND_OUTDATED => 'Семейство зарегистрировано, но устаревшее',
        self::REGISTERED_WITHOUT_NAME_COINCIDENCE => 'Семейство зарегистрировано, но имена не совпадают',
        self::REGISTERED_AND_RELEVANT => 'Семейство зарегистрировано и валидно',
    ];
}
