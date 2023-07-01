<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobi extends Model
{
    use HasFactory;
    protected $table = 'ref_hobi';
    protected $guarded = [];

    public function selectFormInput()
    {
        $data = [];
        foreach ($this->where('expired_at', null)->orderBy('id', 'ASC')->get() as $ref) {
            $data[$ref->id] = $ref->hobi;
        }
        return $data;
    }
}
