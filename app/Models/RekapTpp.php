<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekapTpp extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'rekap_tpp';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];


    public function getRekapTpp_array($where = null)
    {
        $builder = $this->select('*');


        if (session('op')) {
            if (session('akses_kecamatan_id')) {
                $whereIn = [];
                foreach (json_decode(session('akses_kecamatan_id')) as $code) {
                    $whereIn[] = $code;
                }
                $builder->whereIn('sekolah.kecamatan_id', $whereIn);
            } else {
                $builder->where('sekolah.kecamatan_id', '#');
            }
        }


        if (session('ops'))
            $builder->where('sekolah_id', session('sekolah_id'));

        return $builder->where($where)->get();
    }

    public function jumlahRekapTpp($where = null, $whereIn = null)
    {
        $data['jumlah_pegawai'] = $this->whereIn('jenis_ptk_id', $whereIn)->where($where)->count();
        $data['jumlah_tpp_disiplin'] = $this->where($where)->whereIn('jenis_ptk_id', $whereIn)->sum("jumlah_tpp_disiplin");
        $data['pph21'] = $this->where($where)->whereIn('jenis_ptk_id', $whereIn)->sum("pph21");
        $data['bpjs4'] = $this->where($where)->whereIn('jenis_ptk_id', $whereIn)->sum("bpjs4");
        $data['jumlah_tpp_kotor'] = $this->where($where)->whereIn('jenis_ptk_id', $whereIn)->sum("jumlah_tpp_kotor");
        $data['bpjs1'] = $this->where($where)->whereIn('jenis_ptk_id', $whereIn)->sum("bpjs1");
        $data['jumlah_potongan'] = $this->where($where)->whereIn('jenis_ptk_id', $whereIn)->sum("jumlah_potongan");
        $data['total_tpp_diterima'] = $this->where($where)->whereIn('jenis_ptk_id', $whereIn)->sum("total_tpp_diterima");
        $data['zakat'] = $this->where($where)->whereIn('jenis_ptk_id', $whereIn)->sum("zakat");

        return $data;
    }

    public function penerimaTpp($where = [])
    {
        $builder = $this->select('*');
        if (session('ops'))
            $builder->where('sekolah_id', session('sekolah_id'));

        $builder->where($where);
        return $builder->count();
    }
}
