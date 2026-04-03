<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepalaSekolah extends Model
{
    protected $table = 'kepala_sekolah';

    public function sekolah()
    {
        return $this->belongsTo(SekolahDetail::class, 'sekolah_id', 'sekolah_id');
    }
}
