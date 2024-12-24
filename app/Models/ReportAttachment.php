<?php

namespace App\Models;

use App\Models\Report;
use Illuminate\Database\Eloquent\Model;

class ReportAttachment extends Model
{
    protected $fillable = [
        'report_id',
        'path',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id', 'id', 'reports');
    }
}
