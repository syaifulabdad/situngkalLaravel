<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtkTerdaftar extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'ptk_terdaftar';
    protected $primaryKey = 'ptk_terdaftar_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('sekolah_id', function (Builder $builder) {
            $builder->where('ptk_terdaftar.sekolah_id', session('sekolah_id'));
        });
    }

    public function ptk()
    {
        return $this->belongsTo(Ptk::class, 'ptk_id', 'ptk_id');
    }

    public function selectFormInput($where = null)
    {
        $data = [];
        $data[null] = 'Pilih PTK';

        $builder = $this->orderBy('nama', 'ASC');
        foreach ($builder->get() as $ref) {
            $data[$ref->{$this->primaryKey}] = $ref->nama;
        }
        return $data;
    }
}
