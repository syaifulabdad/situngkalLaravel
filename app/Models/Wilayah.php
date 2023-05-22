<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Wilayah extends Model
{
    use HasFactory;
    protected $table = 'referensi.wilayah';
    protected $primaryKey = 'kode_wilayah';

    public function selectWilayah($level = 1, $where = [], $parent_id = null)
    {
        $data = [];
        $levelArray = [1 => "Provinsi", 2 => "Kabupaten/Kota", 3 => "Kecamatan", 4 => "Desa/Kelurahan"];
        $data[null] = 'Pilih ' . $levelArray[$level];

        $builder = $this->orderBy('nama', 'ASC');
        $builder->where(['id_level_wilayah' => $level, 'expired_date' => null]);

        if (session('op')) {
            if (session('akses_kecamatan_id')) {
                $whereIn = [];
                foreach (json_decode(session('akses_kecamatan_id')) as $code) {
                    $whereIn[] = $code;
                }
                $builder->whereIn('kode_wilayah', $whereIn);
            } else {
                $builder->where('kode_wilayah', '#');
            }
        }

        if ($where) {
            foreach ($where as $key => $value) {
                $builder->where($key, $value);
            }
        }
        if ($parent_id)
            $builder->where('mst_kode_wilayah', $parent_id);

        if (request('q')) {
            $builder->where("nama", 'LIKE', "%" . request("q") . "%");
        }

        foreach ($builder->get() as $ref) {
            // $Kab = $this->find($ref->mst_kode_wilayah);
            $data[$ref->{$this->primaryKey}] = $ref->nama;
        }
        return $data;
    }
}
