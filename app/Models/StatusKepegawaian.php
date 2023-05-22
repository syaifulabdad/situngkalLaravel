<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusKepegawaian extends Model
{
    use HasFactory;
    protected $table = 'referensi.status_kepegawaian';
    protected $guarded = [];

    public function selectFormInput()
    {
        $data = [];
        foreach ($this->where('expired_at', null)->orderBy('id', 'ASC')->get() as $ref) {
            $data[$ref->id] = $ref->status_kepegawaian;
        }
        return $data;
    }
}
