<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PangkatGolongan extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'ref_pangkat_golongan';
    protected $primaryKey = 'id';

    public function selectFormInput()
    {
        $data = [];
        $data[] = 'Pangkat/Golongan';
        foreach ($this->where('deleted_at', null)->orderBy('sub_golongan', 'ASC')->get() as $ref) {
            $data[$ref->{$this->primaryKey}] = $ref->pangkat . ", " . $ref->sub_golongan;
        }
        return $data;
    }
}
