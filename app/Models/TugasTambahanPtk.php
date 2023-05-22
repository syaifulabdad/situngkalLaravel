<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TugasTambahanPtk extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'ptk_tugas_tambahan';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];


    public function jabatanTugas(): HasOne
    {
        return $this->hasOne(JabatanTugasPtk::class, 'id', 'jabatan_id');
    }
}
