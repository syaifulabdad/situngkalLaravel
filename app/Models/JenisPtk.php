<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPtk extends Model
{
    use HasFactory;
    protected $table = 'ref_jenis_ptk';
    protected $guarded = [];

    public function selectFormInput($where = null)
    {
        $data = [];
        $query = $this->where('expired_at', null)->orderBy('id', 'ASC');
        if ($where) {
            $query->where($where);
        }
        foreach ($query->get() as $ref) {
            $data[$ref->id] = $ref->jenis_ptk;
        }
        return $data;
    }
}
