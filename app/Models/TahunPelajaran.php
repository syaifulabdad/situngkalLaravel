<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahunPelajaran extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'tahun_pelajaran';
    protected $primaryKey = 'tahun_pelajaran_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function selectFormInput()
    {
        $data = [];
        foreach ($this->orderBy('tahun_pelajaran', 'ASC')->get() as $ref) {
            $data[$ref->{$this->primaryKey}] = $ref->tahun_pelajaran;
        }
        return $data;
    }
}
