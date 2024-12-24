<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ReportAttachment;
use App\Models\ReportComment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($report) {
            $report->code = $report->generateCode();
        });
    }
    protected $fillable = [
        'code',
        'user_id',
        'category_id',
        'title',
        'description',
        'note_rejected',
        'region',
        'latitude',
        'longitude',
        'priority',
        'status',
    ];

    protected $hidden = [
        'code',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id', 'categories');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'users');
    }

    public function comments()
    {
        return $this->hasMany(ReportComment::class, 'report_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(ReportAttachment::class, 'report_id', 'id');
    }

    private function generateCode()
    {
        $prefix = 'LP';
        $date = Carbon::now()->format('Ymd'); // Current date in YYYYMMDD format

        // Find the latest order for the current date
        $lastReport = self::where('code', 'LIKE', "$prefix/$date/%")
            ->latest('created_at')
            ->first();

        if ($lastReport) {
            // Extract the last sequence number and increment it
            $lastSequence = (int) str_replace("$prefix/$date/", '', $lastReport->code);
            $nextSequence = $lastSequence + 1;
        } else {
            // Initialize sequence number if no previous order
            $nextSequence = 1;
        }

        // Format the next sequence number to ensure it is zero-padded
        $formattedSequence = str_pad($nextSequence, 4, '0', STR_PAD_LEFT);

        return "$prefix/$date/$formattedSequence";
    }

}
