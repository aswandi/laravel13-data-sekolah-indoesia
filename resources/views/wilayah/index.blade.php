@extends('layouts.app')

@section('title', 'Data Sekolah Indonesia - Database Sekolah Seluruh Indonesia')
@section('meta_description', 'Database resmi data sekolah di seluruh Indonesia. Temukan informasi lengkap ' . number_format($totalSekolah) . ' sekolah dari 38 provinsi termasuk NPSN, akreditasi, dan lokasi.')
@section('meta_keywords', 'data sekolah indonesia, database sekolah, NPSN sekolah, sekolah negeri, sekolah swasta, SD SMP SMA SMK se-Indonesia')

@section('content')
    {{-- Hero --}}
    <section class="hero" data-aos="fade-up">
        <h1>🏫 Data Sekolah<br>Seluruh Indonesia</h1>
        <p>Database lengkap <strong>{{ number_format($totalSekolah, 0, ',', '.') }}</strong> sekolah dari <strong>{{ $provinsiData->count() }}</strong> provinsi di Indonesia — terintegrasi dengan peta lokasi</p>
    </section>

    {{-- Stats Overview --}}
    <section class="stats-grid" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-school"></i></div>
            <div class="stat-value"><span class="counter-animate" data-target="{{ $totalSekolah }}">0</span></div>
            <div class="stat-label">Total Sekolah</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-landmark"></i></div>
            <div class="stat-value"><span class="counter-animate" data-target="{{ $totalNegeri }}">0</span></div>
            <div class="stat-label">Sekolah Negeri</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-building"></i></div>
            <div class="stat-value"><span class="counter-animate" data-target="{{ $totalSwasta }}">0</span></div>
            <div class="stat-label">Sekolah Swasta</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-map-marked-alt"></i></div>
            <div class="stat-value"><span class="counter-animate" data-target="{{ $provinsiData->count() }}">0</span></div>
            <div class="stat-label">Provinsi</div>
        </div>
    </section>

    {{-- Province Table --}}
    <section data-aos="fade-up" data-aos-delay="200">
        <div class="page-header">
            <h1><i class="fas fa-map"></i> Daftar Provinsi</h1>
            <p>Pilih provinsi untuk melihat data sekolah di wilayah tersebut</p>
        </div>

        <div class="data-table-container">
            <table class="data-table" id="provinsiTable">
                <thead>
                    <tr>
                        <th class="th-no">No</th>
                        <th class="th-name">Provinsi</th>
                        <th class="th-num">Total</th>
                        <th class="th-num">Negeri</th>
                        <th class="th-num">Swasta</th>
                        <th class="th-num">SD/MI</th>
                        <th class="th-num">SMP</th>
                        <th class="th-num">SMA/SMK</th>
                        <th class="th-action">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($provinsiData as $prov)
                    <tr data-aos="fade-up" data-aos-delay="{{ min($loop->index * 20, 200) }}">
                        <td class="td-no">{{ $loop->iteration }}</td>
                        <td class="td-name">
                            <a href="{{ route('provinsi', urlencode($prov->provinsi)) }}">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ str_replace('Prov. ', '', $prov->provinsi) }}
                            </a>
                        </td>
                        <td class="td-num"><span class="num-total">{{ number_format($prov->total_sekolah, 0, ',', '.') }}</span></td>
                        <td class="td-num"><span class="badge-inline badge-negeri">{{ number_format($prov->total_negeri, 0, ',', '.') }}</span></td>
                        <td class="td-num"><span class="badge-inline badge-swasta">{{ number_format($prov->total_swasta, 0, ',', '.') }}</span></td>
                        <td class="td-num">{{ number_format($prov->total_sd, 0, ',', '.') }}</td>
                        <td class="td-num">{{ number_format($prov->total_smp, 0, ',', '.') }}</td>
                        <td class="td-num">{{ number_format($prov->total_sma_smk, 0, ',', '.') }}</td>
                        <td class="td-action">
                            <a href="{{ route('provinsi', urlencode($prov->provinsi)) }}" class="btn-view">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
