<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hari extends Model
{
    use HasFactory;
    protected $table = 'ref_hari';
    protected $guarded = [];

    public function selectFormInput()
    {
        $data = [];
        foreach ($this->orderBy('id', 'ASC')->get() as $ref) {
            $data[$ref->id] = $ref->hari;
        }
        return $data;
    }
}
