<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisTpp extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'jenis_tpp';
    protected $primaryKey = 'jenis_tpp_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function selectFormInput()
    {
        $data = [];
        $data[null] = 'Pilih Jenis TPP';
        foreach ($this->where('deleted_at', null)->orderBy('jenis_tpp', 'ASC')->get() as $ref) {
            $data[$ref->{$this->primaryKey}] = $ref->jenis_tpp;
        }
        return $data;
    }
}
