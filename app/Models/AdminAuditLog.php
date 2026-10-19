<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAuditLog extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = ['target_ids' => 'array', 'created_at' => 'datetime'];
}
