<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SekolahDetail extends Model
{
    protected $table = 'sekolah_detail';

    protected $casts = [
        'lintang' => 'double',
        'bujur' => 'double',
        'luas_tanah_milik' => 'integer',
        'luas_tanah_bukan_milik' => 'integer',
        'daya_listrik' => 'integer',
    ];

    public function statistik()
    {
        return $this->hasOne(SekolahStatistik::class, 'sekolah_id', 'sekolah_id');
    }

    public function kepalaSekolah()
    {
        return $this->hasMany(KepalaSekolah::class, 'sekolah_id', 'sekolah_id');
    }

    /**
     * Scope: filter by provinsi
     */
    public function scopeByProvinsi($query, $provinsi)
    {
        return $query->where('provinsi', $provinsi);
    }

    /**
     * Scope: filter by kabupaten
     */
    public function scopeByKabupaten($query, $kabupaten)
    {
        return $query->where('kabupaten', $kabupaten);
    }

    /**
     * Scope: filter by kecamatan
     */
    public function scopeByKecamatan($query, $kecamatan)
    {
        return $query->where('kecamatan', $kecamatan);
    }
}
