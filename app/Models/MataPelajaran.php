<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MataPelajaran extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'mata_pelajaran';
    protected $primaryKey = 'mata_pelajaran_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('sekolah_id', function (Builder $builder) {
            $builder->where('sekolah_id', session('sekolah_id'));
        });
    }

    public function jurusan()
    {
        return $this->hasOne(Jurusan::class, 'jurusan_id', 'jurusan_id');
    }

    public function selectFormInput()
    {
        $data = [];
        $builder = $this->orderBy('kelompok', 'ASC')->orderBy('no_urut', 'ASC')->orderBy('mapel', 'ASC');
        $builder->join('jurusan', 'jurusan.jurusan_id', '=', 'mata_pelajaran.jurusan_id', 'left');

        foreach ($builder->get() as $ref) {
            $data[$ref->{$this->primaryKey}] = $ref->mapel . " ($ref->jurusan)";
        }
        return $data;
    }
}
