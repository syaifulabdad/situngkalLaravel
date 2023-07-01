<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citacita extends Model
{
    use HasFactory;
    protected $table = 'ref_cita_cita';
    protected $guarded = [];

    public function selectFormInput()
    {
        $data = [];
        foreach ($this->orderBy('id', 'ASC')->get() as $ref) {
            $data[$ref->id] = $ref->hobi;
        }
        return $data;
    }
}
