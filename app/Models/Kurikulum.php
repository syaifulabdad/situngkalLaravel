<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kurikulum extends Model
{
    use HasFactory;
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = 'kurikulum';
    protected $primaryKey = 'kurikulum_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function selectFormInput()
    {
        $data = [];
        foreach ($this->orderBy('kurikulum', 'ASC')->get() as $ref) {
            $data[$ref->{$this->primaryKey}] = $ref->{$this->table};
        }
        return $data;
    }
}
