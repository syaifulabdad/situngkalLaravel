<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPendaftaran extends Model
{
    use HasFactory;
    protected $table = 'referensi.jenis_pendaftaran';
    protected $guarded = [];

    public function selectFormInput()
    {
        $data = [];
        foreach ($this->where('expired_at', null)->orderBy('id', 'ASC')->get() as $ref) {
            $data[$ref->id] = $ref->jenis_pendaftaran;
        }
        return $data;
    }
}
