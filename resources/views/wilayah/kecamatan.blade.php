@extends('layouts.app')

@php
    $provClean = str_replace('Prov. ', '', $provinsi);
@endphp

@section('title', 'Data Sekolah ' . $kecamatan . ', ' . $kabupaten . ', ' . $provClean)
@section('meta_description', 'Daftar sekolah di ' . $kecamatan . ', ' . $kabupaten . ', ' . $provClean . '. Lihat lokasi peta, NPSN, akreditasi, dan informasi lengkap sekolah.')
@section('meta_keywords', 'sekolah ' . $kecamatan . ', ' . $kabupaten . ', NPSN sekolah ' . $kecamatan)

@section('content')
    {{-- Breadcrumb --}}
    <nav class="breadcrumb" data-aos="fade-right">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Beranda</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <a href="{{ route('provinsi', urlencode($provinsi)) }}">{{ $provClean }}</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <a href="{{ route('kabupaten', [urlencode($provinsi), urlencode($kabupaten)]) }}">{{ $kabupaten }}</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">{{ $kecamatan }}</span>
    </nav>

    {{-- Page Header --}}
    <div class="page-header" data-aos="fade-up">
        <h1><i class="fas fa-map-pin"></i> {{ $kecamatan }}</h1>
        <p>{{ $kabupaten }}, {{ $provClean }}</p>
    </div>

    {{-- Stats --}}
    <section class="stats-grid" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-school"></i></div>
            <div class="stat-value"><span class="counter-animate" data-target="{{ $stats->total_sekolah }}">0</span></div>
            <div class="stat-label">Total Sekolah</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-landmark"></i></div>
            <div class="stat-value"><span class="counter-animate" data-target="{{ $stats->total_negeri }}">0</span></div>
            <div class="stat-label">Sekolah Negeri</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-building"></i></div>
            <div class="stat-value"><span class="counter-animate" data-target="{{ $stats->total_swasta }}">0</span></div>
            <div class="stat-label">Sekolah Swasta</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-graduation-cap"></i></div>
            <div class="stat-value"><span class="counter-animate" data-target="{{ $stats->total_sma_smk }}">0</span></div>
            <div class="stat-label">SMA/SMK</div>
        </div>
    </section>

    {{-- Map --}}
    @if($mapMarkers->count() > 0)
    <section class="map-section" data-aos="fade-up" data-aos-delay="200">
        <div class="map-container">
            <div class="map-header">
                <i class="fas fa-map-marked-alt"></i>
                <h3>Peta Lokasi Sekolah — {{ $kecamatan }}</h3>
            </div>
            <div id="mapLeaflet"></div>
        </div>
    </section>
    @endif

    {{-- School Table --}}
    <section data-aos="fade-up" data-aos-delay="300">
        <div class="page-header">
            <h1 style="font-size:1.4rem"><i class="fas fa-list"></i> Daftar Sekolah</h1>
            <p>Menampilkan {{ $sekolahList->total() }} sekolah di {{ $kecamatan }}</p>
        </div>

        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="th-no">No</th>
                        <th class="th-name">Nama Sekolah</th>
                        <th>NPSN</th>
                        <th>Jenjang</th>
                        <th>Status</th>
                        <th>Akreditasi</th>
                        <th class="th-action">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sekolahList as $sekolah)
                    <tr>
                        <td class="td-no">{{ $sekolahList->firstItem() + $loop->index }}</td>
                        <td class="td-name">
                            <a href="{{ route('sekolah', $sekolah->npsn) }}">
                                <i class="fas fa-school"></i>
                                {{ $sekolah->nama }}
                            </a>
                        </td>
                        <td><code class="npsn-code">{{ $sekolah->npsn }}</code></td>
                        <td>
                            @php
                                $jenjangColors = [
                                    'SD' => '#4f46e5', 'MI' => '#4f46e5', 'SPK SD' => '#4f46e5',
                                    'SMP' => '#06b6d4', 'SPK SMP' => '#06b6d4',
                                    'SMA' => '#f59e0b', 'SMK' => '#ec4899', 'SMAg.K' => '#f59e0b', 'SPK SMA' => '#f59e0b',
                                ];
                                $jColor = $jenjangColors[$sekolah->bentuk_pendidikan] ?? '#6366f1';
                            @endphp
                            <span class="badge-jenjang" style="background: {{ $jColor }}15; color: {{ $jColor }}; border: 1px solid {{ $jColor }}30;">
                                {{ $sekolah->bentuk_pendidikan }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-inline {{ $sekolah->status_sekolah === 'NEGERI' ? 'badge-negeri' : 'badge-swasta' }}">
                                {{ $sekolah->status_sekolah }}
                            </span>
                        </td>
                        <td>
                            @if($sekolah->akreditasi && $sekolah->akreditasi !== '-')
                                <span class="badge-akreditasi">{{ $sekolah->akreditasi }}</span>
                            @else
                                <span style="color: var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td class="td-action">
                            <a href="{{ route('sekolah', $sekolah->npsn) }}" class="btn-view">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrapper">
            {{ $sekolahList->links() }}
        </div>
    </section>
@endsection

@section('extra_scripts')
@if($mapMarkers->count() > 0)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const markers = @json($mapMarkers);

        let latSum = 0, lngSum = 0, count = 0;
        markers.forEach(m => {
            if (m.lintang && m.bujur) {
                latSum += m.lintang;
                lngSum += m.bujur;
                count++;
            }
        });

        const centerLat = count > 0 ? latSum / count : -2.5;
        const centerLng = count > 0 ? lngSum / count : 118;

        const map = L.map('mapLeaflet').setView([centerLat, centerLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        const colorMap = {
            'SD': '#4f46e5', 'MI': '#4f46e5', 'SPK SD': '#4f46e5',
            'SMP': '#06b6d4', 'SPK SMP': '#06b6d4',
            'SMA': '#f59e0b', 'SMK': '#ec4899', 'SMAg.K': '#f59e0b', 'SPK SMA': '#f59e0b',
            'Adi Widyalaya': '#10b981'
        };

        markers.forEach(m => {
            if (!m.lintang || !m.bujur) return;

            const color = colorMap[m.bentuk_pendidikan] || '#6366f1';

            const icon = L.divIcon({
                className: 'custom-marker',
                html: `<div style="
                    width: 28px; height: 28px;
                    background: ${color};
                    border: 3px solid white;
                    border-radius: 50%;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
                    display: flex; align-items: center; justify-content: center;
                    color: white; font-size: 10px; font-weight: bold;
                ">${m.bentuk_pendidikan.substring(0, 2)}</div>`,
                iconSize: [28, 28],
                iconAnchor: [14, 14]
            });

            L.marker([m.lintang, m.bujur], { icon })
                .addTo(map)
                .bindPopup(`
                    <div class="popup-school-name">${m.nama}</div>
                    <div class="popup-school-meta">
                        ${m.bentuk_pendidikan} | ${m.status_sekolah}<br>
                        NPSN: ${m.npsn}
                    </div>
                    <a href="/sekolah/${m.npsn}" class="popup-school-link">
                        <i class="fas fa-external-link-alt"></i> Lihat Detail
                    </a>
                `);
        });

        if (count > 1) {
            const bounds = L.latLngBounds(markers.filter(m => m.lintang && m.bujur).map(m => [m.lintang, m.bujur]));
            map.fitBounds(bounds, { padding: [30, 30] });
        }
    });
</script>
@endif
@endsection
