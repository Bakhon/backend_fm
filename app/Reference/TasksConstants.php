<?php

namespace App\Reference;

class TasksConstants
{
    /** @var int */
    public const STATUS_NEW = 1;
    /** @var int  */
    public const STATUS_IN_PROCESS = 2;
    /** @var int  */
    public const STATUS_DONE = 3;
    /** @var int  */
    public const STATUS_REJECTED = 4;

    /** @var int  */
    public const PRIORITY_LOW = 1;
    /** @var int  */
    public const PRIORITY_NORMAL = 5;
    /** @var int  */
    public const PRIORITY_HIGH = 9;

    /** @var array */
    public const TASK_STATUS_IDS = [
        self::STATUS_NEW,
        self::STATUS_IN_PROCESS,
        self::STATUS_DONE,
        self::STATUS_REJECTED,
    ];

    /** @var array */
    public const TASK_STATUSES = [
        self::STATUS_NEW => 'Создана',
        self::STATUS_IN_PROCESS => 'В работе',
        self::STATUS_DONE => 'Исполнено',
        self::STATUS_REJECTED => 'Отказано',
    ];

    /** @var string  */
    public const ERROR_TASK_ALREADY_DONE = 'TASK_ALREADY_DONE';
    /** @var string  */
    public const ERROR_TASK_ALREADY_REJECTED = 'TASK_ALREADY_REJECTED';
    /** @var string  */
    public const ERROR_EXECUTOR_ALREADY_SET = 'EXECUTOR_ALREADY_SET';

}
