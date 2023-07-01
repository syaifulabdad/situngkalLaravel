<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghasilan extends Model
{
    use HasFactory;
    protected $table = 'ref_penghasilan';
    protected $guarded = [];

    public function selectFormInput()
    {
        $data = [];
        foreach ($this->where('expired_at', null)->orderBy('id', 'ASC')->get() as $ref) {
            $data[$ref->id] = $ref->penghasilan;
        }
        return $data;
    }
}
