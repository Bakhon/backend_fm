<?php


namespace App\Reference;


class CaseConstants
{
    /** @var int  */
    public const STATUS_WITHOUT_TRASHED = 1;
    /** @var int  */
    public const STATUS_WITH_TRASHED = 2;
    /** @var int  */
    public const STATUS_ONLY_TRASHED = 3;

    /** @var string  */
    public const ERROR_FAMILY_COMPOSITION_NOT_FOUND = 'FAMILY_COMPOSITION_NOT_FOUND';
    /** @var string  */
    public const ERROR_FORBIDDEN_UPLOAD_RFA_FILE = 'FORBIDDEN_UPLOAD_RFA_FILE';
}
