<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sekolah extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'sekolah';
    protected $primaryKey = 'sekolah_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('sekolah_id', function (Builder $builder) {
            if (session('sekolah_id'))
                $builder->where('sekolah_id', session('sekolah_id'));

            if (session('op')) {
                if (session('akses_kecamatan_id')) {
                    $whereIn = [];
                    foreach (json_decode(session('akses_kecamatan_id')) as $kecamatan_id) {
                        $whereIn[] = $kecamatan_id;
                    }
                    $builder->whereIn('kecamatan_id', $whereIn);
                } else {
                    $builder->where('kecamatan_id', '#');
                }
            }
        });
    }

    public function wilayah(): HasOne
    {
        return $this->hasOne(Wilayah::class, 'kode_wilayah', 'kecamatan_id');
    }

    public function selectFormInput($where = null)
    {
        $data = [];
        $builder = $this->orderBy('nama', 'ASC');
        if (session('op')) {
            if (session('akses_kecamatan_id')) {
                $whereIn = [];
                foreach (json_decode(session('akses_kecamatan_id')) as $kecamatan_id) {
                    $whereIn[] = $kecamatan_id;
                }
                $builder->whereIn('kecamatan_id', $whereIn);
            } else {
                $builder->where('kecamatan_id', '#');
            }
        }

        if ($where)
            $builder->where($where);
        foreach ($builder->get() as $ref) {
            $data[$ref->{$this->primaryKey}] = $ref->nama;
        }
        return $data;
    }
}
