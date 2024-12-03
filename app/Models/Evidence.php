<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    protected $table = 'evidences';
    use HasFactory;

    protected $fillable = ['report_id', 'file_path', 'file_type', 'uploaded_at'];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
