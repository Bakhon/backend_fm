<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;


class UserFiles extends BaseModel
{
    use SoftDeletes;

    protected $table = "user_files";

    protected $fillable = [
        'id',
        'file_id',
        'date_download',
        'user_hash'
    ];
    
    public function files()
    {
        return $this->belongsTo(File::class);
    }
}
