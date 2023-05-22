<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanTugasPtk extends Model
{
    use HasFactory;
    protected $table = 'referensi.jabatan_tugas_ptk';
    protected $guarded = [];

    public function selectFormInput($where = null)
    {
        $data = [];
        $query = $this->where('expired_date', null)->orderBy('id', 'ASC');
        if ($where) {
            $query->where($where);
        }
        foreach ($query->get() as $ref) {
            $data[$ref->id] = $ref->jabatan_tugas_ptk;
        }
        return $data;
    }
}
