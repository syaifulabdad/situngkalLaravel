<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TingkatKelas extends Model
{
    use HasFactory;
    protected $table = 'ref_tingkat_kelas';
    protected $guarded = [];

    public function selectFormInput()
    {
        $data = [];
        foreach ($this->orderBy('id', 'ASC')->get() as $ref) {
            $data[$ref->id] = $ref->{$this->table};
        }
        return $data;
    }
}
