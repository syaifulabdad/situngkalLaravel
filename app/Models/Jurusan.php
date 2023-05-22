<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurusan extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'jurusan';
    protected $primaryKey = 'jurusan_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function kurikulum()
    {
        return $this->hasOne(Kurikulum::class, 'kurikulum_id', 'kurikulum_id');
    }

    public function selectFormInput()
    {
        $data = [];
        $builder = $this->orderBy('no_urut', 'ASC')->orderBy('jurusan', 'ASC');
        $builder->join('kurikulum', 'kurikulum.kurikulum_id', '=', 'jurusan.kurikulum_id');

        foreach ($builder->get() as $ref) {
            $data[$ref->{$this->primaryKey}] = $ref->{$this->table} . " ($ref->kurikulum)";
        }
        return $data;
    }
}
