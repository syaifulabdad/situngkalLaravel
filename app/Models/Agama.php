<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    use HasFactory;
    protected $table = 'ref_agama';
    protected $guarded = [];

    public function selectFormInput()
    {
        $data = [];
        foreach ($this->orderBy('id', 'ASC')->get() as $ref) {
            $data[$ref->id] = $ref->agama;
        }
        return $data;
    }
}
