<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Semester extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'semester';
    protected $primaryKey = 'semester_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];


    public function selectFormInput($where = null)
    {
        $data = [];
        $builder = $this->join('tahun_pelajaran as tp', 'tp.tahun_pelajaran_id', '=', "$this->table.tahun_pelajaran_id");
        $builder->orderBy('tahun_pelajaran', 'DESC');
        $builder->orderBy('semester', 'DESC');

        if ($where) {
            foreach ($where as $key => $value) {
                $builder->where($key, $value);
            }
        }

        foreach ($builder->get() as $ref) {
            $data[$ref->{$this->primaryKey}] = "$ref->tahun_pelajaran " . ($ref->semester == '1' ? "Ganjil" : "Genap");
        }
        return $data;
    }
}
