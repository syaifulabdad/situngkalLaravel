<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ptk extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'ptk';
    protected $primaryKey = 'ptk_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function selectFormInput($where = null)
    {
        $data = [];
        $data[null] = 'Pilih PTK';

        $builder = $this->orderBy('ptk.nama', 'ASC');
        $builder->join('ptk_terdaftar as reg', 'reg.ptk_id', '=', $this->table . ".ptk_id");
        $builder->select('ptk.*');
        // if ($where) {
        //     foreach ($where as $key => $value) {
        //         $builder->where($where);
        //     }
        // }

        foreach ($builder->get() as $ref) {
            $data[$ref->{$this->primaryKey}] = $ref->nama;
        }
        return $data;
    }

    public function ptkTerdaftar(): HasOne
    {
        return $this->hasOne(PtkTerdaftar::class, 'ptk_id');
    }

    public function agama(): HasOne
    {
        return $this->hasOne(Agama::class, 'id', 'agama_id');
    }

    public function jenisPtk(): HasOne
    {
        return $this->hasOne(JenisPtk::class, 'id', 'jenis_ptk_id');
    }
    public function jenisTpp(): HasOne
    {
        return $this->hasOne(JenisTpp::class, 'jenis_tpp_id', 'jenis_tpp_id');
    }

    public function statusKepegawaian(): HasOne
    {
        return $this->hasOne(StatusKepegawaian::class, 'id', 'status_kepegawaian_id');
    }

    public function riwayatKepangkatan()
    {
        return $this->belongsTo(RiwayatKepangkatan::class, 'ptk_id', 'ptk_id');
    }

    public function selectJenisPtk()
    {
        $data = [];
        foreach ($this->orderBy('jenis_ptk_id', 'asc')->distinct('jenis_ptk_id')->get() as $dt) {
            $ref = JenisPtk::find($dt->jenis_ptk_id);
            $data[$ref->id] = $ref->jenis_ptk;
        }
        return $data;
    }
}
