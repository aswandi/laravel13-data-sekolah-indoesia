@extends('layouts.app')

@php
    $provClean = str_replace('Prov. ', '', $sekolah->provinsi);
@endphp

@section('title', $sekolah->nama . ' - NPSN ' . $sekolah->npsn . ' | Data Sekolah Indonesia')
@section('meta_description', $sekolah->nama . ' (' . $sekolah->bentuk_pendidikan . ' ' . $sekolah->status_sekolah . ') di ' . $sekolah->kecamatan . ', ' . $sekolah->kabupaten . ', ' . $provClean . '. NPSN: ' . $sekolah->npsn . '. Akreditasi: ' . ($sekolah->akreditasi ?: '-') . '.')
@section('meta_keywords', $sekolah->nama . ', NPSN ' . $sekolah->npsn . ', ' . $sekolah->bentuk_pendidikan . ' ' . $sekolah->kabupaten)

@section('content')
    {{-- Breadcrumb --}}
    <nav class="breadcrumb" data-aos="fade-right">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Beranda</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <a href="{{ route('provinsi', urlencode($sekolah->provinsi)) }}">{{ $provClean }}</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <a href="{{ route('kabupaten', [urlencode($sekolah->provinsi), urlencode($sekolah->kabupaten)]) }}">{{ $sekolah->kabupaten }}</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <a href="{{ route('kecamatan', [urlencode($sekolah->provinsi), urlencode($sekolah->kabupaten), urlencode($sekolah->kecamatan)]) }}">{{ $sekolah->kecamatan }}</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">{{ $sekolah->nama }}</span>
    </nav>

    {{-- School Header --}}
    <div class="page-header" data-aos="fade-up">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 0.8rem;">
            <h1 style="font-size: 1.6rem;">{{ $sekolah->nama }}</h1>
            <span class="badge {{ $sekolah->status_sekolah === 'NEGERI' ? 'badge-negeri' : 'badge-swasta' }}" style="font-size: 0.85rem; padding: 0.3rem 0.8rem;">
                <i class="fas {{ $sekolah->status_sekolah === 'NEGERI' ? 'fa-landmark' : 'fa-building' }}"></i>
                {{ $sekolah->status_sekolah }}
            </span>
            @if($sekolah->akreditasi)
                <span class="badge-akreditasi" style="font-size: 0.85rem; padding: 0.3rem 0.8rem;">
                    <i class="fas fa-award"></i> Akreditasi {{ $sekolah->akreditasi }}
                </span>
            @endif
        </div>
        <p><i class="fas fa-map-marker-alt" style="color: var(--primary);"></i> {{ $sekolah->alamat_jalan }}, {{ $sekolah->kecamatan }}, {{ $sekolah->kabupaten }}, {{ $provClean }}</p>
    </div>

    {{-- Detail Grid --}}
    <div class="detail-grid" data-aos="fade-up" data-aos-delay="100">
        {{-- Left Column --}}
        <div>
            {{-- Informasi Umum --}}
            <div class="detail-card">
                <h2><i class="fas fa-info-circle"></i> Informasi Umum</h2>
                <table class="detail-table">
                    <tr><td>NPSN</td><td>{{ $sekolah->npsn }}</td></tr>
                    <tr><td>Nama Sekolah</td><td>{{ $sekolah->nama }}</td></tr>
                    <tr><td>Bentuk Pendidikan</td><td>{{ $sekolah->bentuk_pendidikan }}</td></tr>
                    <tr><td>Status</td><td>
                        <span class="badge {{ $sekolah->status_sekolah === 'NEGERI' ? 'badge-negeri' : 'badge-swasta' }}">{{ $sekolah->status_sekolah }}</span>
                    </td></tr>
                    <tr><td>Akreditasi</td><td>{{ $sekolah->akreditasi ?: '-' }}</td></tr>
                    <tr><td>Waktu Penyelenggaraan</td><td>{{ $sekolah->waktu_penyelenggaraan ?: '-' }}</td></tr>
                </table>
            </div>

            {{-- Alamat --}}
            <div class="detail-card">
                <h2><i class="fas fa-map-marked-alt"></i> Alamat</h2>
                <table class="detail-table">
                    <tr><td>Alamat</td><td>{{ $sekolah->alamat_jalan }}</td></tr>
                    <tr><td>RT / RW</td><td>{{ $sekolah->rt }} / {{ $sekolah->rw }}</td></tr>
                    <tr><td>Dusun</td><td>{{ $sekolah->nama_dusun ?: '-' }}</td></tr>
                    <tr><td>Kecamatan</td><td>{{ $sekolah->kecamatan }}</td></tr>
                    <tr><td>Kabupaten / Kota</td><td>{{ $sekolah->kabupaten }}</td></tr>
                    <tr><td>Provinsi</td><td>{{ $provClean }}</td></tr>
                    <tr><td>Kode Pos</td><td>{{ $sekolah->kode_pos ?: '-' }}</td></tr>
                    <tr><td>Koordinat</td><td>{{ $sekolah->lintang }}, {{ $sekolah->bujur }}</td></tr>
                </table>
            </div>

            {{-- Kontak --}}
            <div class="detail-card">
                <h2><i class="fas fa-phone-alt"></i> Kontak</h2>
                <table class="detail-table">
                    <tr><td>Telepon</td><td>{{ $sekolah->nomor_telepon ?: '-' }}</td></tr>
                    <tr><td>Email</td><td>{{ $sekolah->email ?: '-' }}</td></tr>
                    <tr><td>Website</td><td>
                        @if($sekolah->website && $sekolah->website !== 'http://')
                            <a href="{{ $sekolah->website }}" target="_blank" style="color: var(--primary);">{{ $sekolah->website }}</a>
                        @else
                            -
                        @endif
                    </td></tr>
                </table>
            </div>

            {{-- Fasilitas --}}
            <div class="detail-card">
                <h2><i class="fas fa-cogs"></i> Fasilitas & Infrastruktur</h2>
                <table class="detail-table">
                    <tr><td>Luas Tanah Milik</td><td>{{ $sekolah->luas_tanah_milik ? number_format($sekolah->luas_tanah_milik, 0, ',', '.') . ' m²' : '-' }}</td></tr>
                    <tr><td>Luas Tanah Bukan Milik</td><td>{{ $sekolah->luas_tanah_bukan_milik ? number_format($sekolah->luas_tanah_bukan_milik, 0, ',', '.') . ' m²' : '-' }}</td></tr>
                    <tr><td>Daya Listrik</td><td>{{ $sekolah->daya_listrik ? number_format($sekolah->daya_listrik, 0, ',', '.') . ' Watt' : '-' }}</td></tr>
                    <tr><td>Sumber Listrik</td><td>{{ $sekolah->sumber_listrik ?: '-' }}</td></tr>
                    <tr><td>Akses Internet</td><td>{{ $sekolah->akses_internet ?: '-' }}</td></tr>
                    <tr><td>Bandwidth Internet</td><td>{{ $sekolah->akses_internet_2 ?: '-' }}</td></tr>
                </table>
            </div>

            {{-- Yayasan (if swasta) --}}
            @if($sekolah->yayasan)
            <div class="detail-card">
                <h2><i class="fas fa-building"></i> Yayasan</h2>
                <table class="detail-table">
                    <tr><td>Nama Yayasan</td><td>{{ $sekolah->yayasan }}</td></tr>
                </table>
            </div>
            @endif

            {{-- Kepala Sekolah --}}
            @if($sekolah->kepalaSekolah->count() > 0)
            <div class="detail-card">
                <h2><i class="fas fa-user-tie"></i> Kepala Sekolah / PTK</h2>
                <table class="detail-table">
                    @foreach($sekolah->kepalaSekolah as $ks)
                    <tr>
                        <td>{{ $ks->jenis_ptk ?? 'Kepala Sekolah' }}</td>
                        <td>{{ $ks->nama }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif
        </div>

        {{-- Right Column --}}
        <div>
            {{-- Peta --}}
            @if($sekolah->lintang && $sekolah->bujur && $sekolah->lintang != 0)
            <div class="detail-card">
                <h2><i class="fas fa-map"></i> Lokasi Peta</h2>
                <div style="border-radius: var(--radius-md); overflow: hidden;">
                    <div id="mapLeaflet" style="height: 300px;"></div>
                </div>
                <div style="margin-top: 0.8rem; text-align: center;">
                    <a href="https://www.google.com/maps?q={{ $sekolah->lintang }},{{ $sekolah->bujur }}" target="_blank"
                       style="display: inline-flex; align-items: center; gap: 6px; color: var(--primary); font-weight: 600; font-size: 0.85rem; text-decoration: none;">
                        <i class="fas fa-external-link-alt"></i> Buka di Google Maps
                    </a>
                </div>
            </div>
            @endif

            {{-- Statistik --}}
            @if($sekolah->statistik)
            <div class="detail-card">
                <h2><i class="fas fa-chart-bar"></i> Statistik Sekolah</h2>

                @php
                    $stat = $sekolah->statistik;
                @endphp

                <div class="stat-bar-container">
                    <div class="stat-bar-label">
                        <span>Rasio Rombel / Ruang Kelas</span>
                        <span>{{ number_format($stat->rasio_rombel_ruang_kelas, 2) }}</span>
                    </div>
                    <div class="stat-bar">
                        <div class="stat-bar-fill bar-primary" data-width="{{ min($stat->rasio_rombel_ruang_kelas * 50, 100) }}"></div>
                    </div>
                </div>

                <div class="stat-bar-container">
                    <div class="stat-bar-label">
                        <span>Rasio Siswa / Guru</span>
                        <span>{{ number_format($stat->rasio_siswa_guru, 2) }}</span>
                    </div>
                    <div class="stat-bar">
                        <div class="stat-bar-fill bar-cyan" data-width="{{ min($stat->rasio_siswa_guru * 3, 100) }}"></div>
                    </div>
                </div>

                <div class="stat-bar-container">
                    <div class="stat-bar-label">
                        <span>Guru Berkualifikasi</span>
                        <span>{{ number_format($stat->persentase_guru_klasifikasi, 1) }}%</span>
                    </div>
                    <div class="stat-bar">
                        <div class="stat-bar-fill bar-success" data-width="{{ min($stat->persentase_guru_klasifikasi, 100) }}"></div>
                    </div>
                </div>

                <div class="stat-bar-container">
                    <div class="stat-bar-label">
                        <span>Guru Sertifikasi</span>
                        <span>{{ number_format($stat->persentase_guru_sertifikasi, 1) }}%</span>
                    </div>
                    <div class="stat-bar">
                        <div class="stat-bar-fill bar-warning" data-width="{{ min($stat->persentase_guru_sertifikasi, 100) }}"></div>
                    </div>
                </div>

                <div class="stat-bar-container">
                    <div class="stat-bar-label">
                        <span>Guru ASN</span>
                        <span>{{ number_format($stat->persentase_guru_asn, 1) }}%</span>
                    </div>
                    <div class="stat-bar">
                        <div class="stat-bar-fill bar-pink" data-width="{{ min($stat->persentase_guru_asn, 100) }}"></div>
                    </div>
                </div>

                <div class="stat-bar-container">
                    <div class="stat-bar-label">
                        <span>Ruang Kelas Layak</span>
                        <span>{{ number_format($stat->persentase_ruang_kelas_layak, 1) }}%</span>
                    </div>
                    <div class="stat-bar">
                        <div class="stat-bar-fill bar-primary" data-width="{{ min($stat->persentase_ruang_kelas_layak, 100) }}"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- JSON-LD Schema for SEO --}}
    @php
        $schemaData = [
            '@context' => 'https://schema.org',
            '@type' => 'School',
            'name' => $sekolah->nama,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $sekolah->alamat_jalan,
                'addressLocality' => $sekolah->kabupaten,
                'addressRegion' => $provClean,
                'postalCode' => $sekolah->kode_pos,
                'addressCountry' => 'ID',
            ],
            'identifier' => $sekolah->npsn,
        ];
        if ($sekolah->lintang && $sekolah->bujur) {
            $schemaData['geo'] = [
                '@type' => 'GeoCoordinates',
                'latitude' => $sekolah->lintang,
                'longitude' => $sekolah->bujur,
            ];
        }
        if ($sekolah->nomor_telepon) {
            $schemaData['telephone'] = $sekolah->nomor_telepon;
        }
        if ($sekolah->email) {
            $schemaData['email'] = $sekolah->email;
        }
    @endphp
    <script type="application/ld+json">
    {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endsection

@section('extra_scripts')
@if($sekolah->lintang && $sekolah->bujur && $sekolah->lintang != 0)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('mapLeaflet').setView([{{ $sekolah->lintang }}, {{ $sekolah->bujur }}], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        const icon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="
                width: 36px; height: 36px;
                background: var(--primary);
                border: 4px solid white;
                border-radius: 50%;
                box-shadow: 0 3px 12px rgba(0,0,0,0.35);
                display: flex; align-items: center; justify-content: center;
                color: white; font-size: 14px;
            "><i class="fas fa-school"></i></div>`,
            iconSize: [36, 36],
            iconAnchor: [18, 18]
        });

        L.marker([{{ $sekolah->lintang }}, {{ $sekolah->bujur }}], { icon })
            .addTo(map)
            .bindPopup(`<div class="popup-school-name">{{ $sekolah->nama }}</div>`)
            .openPopup();
    });

    // Animate stat bars
    setTimeout(() => {
        document.querySelectorAll('.stat-bar-fill').forEach(bar => {
            const width = bar.getAttribute('data-width');
            if (width) bar.style.width = width + '%';
        });
    }, 500);
</script>
@else
<script>
    setTimeout(() => {
        document.querySelectorAll('.stat-bar-fill').forEach(bar => {
            const width = bar.getAttribute('data-width');
            if (width) bar.style.width = width + '%';
        });
    }, 500);
</script>
@endif
@endsection
