<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenjangPendidikan extends Model
{
    use HasFactory;
    protected $table = 'referensi.jenjang_pendidikan';
    protected $guarded = [];

    public function selectFormInput()
    {
        $data = [];
        foreach ($this->where('expired_at', null)->orderBy('id', 'ASC')->get() as $ref) {
            $data[$ref->id] = $ref->jenjang_pendidikan;
        }
        return $data;
    }
}
