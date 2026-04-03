<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SekolahStatistik extends Model
{
    protected $table = 'sekolah_statistik';

    protected $casts = [
        'rasio_rombel_ruang_kelas' => 'float',
        'rasio_siswa_guru' => 'float',
        'persentase_guru_klasifikasi' => 'float',
        'persentase_guru_sertifikasi' => 'float',
        'persentase_guru_asn' => 'float',
        'persentase_ruang_kelas_layak' => 'float',
    ];

    public function sekolah()
    {
        return $this->belongsTo(SekolahDetail::class, 'sekolah_id', 'sekolah_id');
    }
}
