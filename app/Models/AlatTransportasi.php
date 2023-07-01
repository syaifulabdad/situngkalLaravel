<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatTransportasi extends Model
{
    use HasFactory;
    protected $table = 'ref_alat_transportasi';
    protected $guarded = [];

    public function selectFormInput()
    {
        $data = [];
        foreach ($this->where('expired_at', null)->orderBy('id', 'ASC')->get() as $ref) {
            $data[$ref->id] = $ref->alat_transportasi;
        }
        return $data;
    }
}
