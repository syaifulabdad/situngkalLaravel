<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TppPerbulan extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'tpp_perbulan';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function jenisTpp()
    {
        return $this->belongsTo(JenisTpp::class, 'jenis_tpp_id', 'jenis_tpp_id');
    }
}
