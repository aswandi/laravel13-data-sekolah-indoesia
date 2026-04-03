@extends('layouts.app')

@php
    $provClean = str_replace('Prov. ', '', $provinsi);
    $totalNegeri = $kabupatenData->sum('total_negeri');
    $totalSwasta = $kabupatenData->sum('total_swasta');
@endphp

@section('title', 'Data Sekolah ' . $provClean . ' - Daftar Kabupaten/Kota')
@section('meta_description', 'Daftar sekolah di ' . $provClean . '. Total ' . number_format($totalSekolah) . ' sekolah tersebar di ' . $kabupatenData->count() . ' kabupaten/kota. Lihat statistik dan lokasi sekolah.')
@section('meta_keywords', 'sekolah ' . $provClean . ', data sekolah ' . $provClean . ', NPSN ' . $provClean)

@section('content')
    {{-- Breadcrumb --}}
    <nav class="breadcrumb" data-aos="fade-right">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Beranda</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">{{ $provClean }}</span>
    </nav>

    {{-- Page Header --}}
    <div class="page-header" data-aos="fade-up">
        <h1><i class="fas fa-map-marker-alt"></i> {{ $provClean }}</h1>
        <p>Menampilkan <strong>{{ $kabupatenData->count() }}</strong> kabupaten/kota dengan total <strong>{{ number_format($totalSekolah, 0, ',', '.') }}</strong> sekolah</p>
    </div>

    {{-- Stats --}}
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
            <div class="stat-icon"><i class="fas fa-city"></i></div>
            <div class="stat-value"><span class="counter-animate" data-target="{{ $kabupatenData->count() }}">0</span></div>
            <div class="stat-label">Kabupaten/Kota</div>
        </div>
    </section>

    {{-- Kabupaten Table --}}
    <section data-aos="fade-up" data-aos-delay="200">
        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="th-no">No</th>
                        <th class="th-name">Kabupaten / Kota</th>
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
                    @foreach($kabupatenData as $kab)
                    <tr data-aos="fade-up" data-aos-delay="{{ min($loop->index * 20, 200) }}">
                        <td class="td-no">{{ $loop->iteration }}</td>
                        <td class="td-name">
                            <a href="{{ route('kabupaten', [urlencode($provinsi), urlencode($kab->kabupaten)]) }}">
                                <i class="fas fa-city"></i>
                                {{ $kab->kabupaten }}
                            </a>
                        </td>
                        <td class="td-num"><span class="num-total">{{ number_format($kab->total_sekolah, 0, ',', '.') }}</span></td>
                        <td class="td-num"><span class="badge-inline badge-negeri">{{ number_format($kab->total_negeri, 0, ',', '.') }}</span></td>
                        <td class="td-num"><span class="badge-inline badge-swasta">{{ number_format($kab->total_swasta, 0, ',', '.') }}</span></td>
                        <td class="td-num">{{ number_format($kab->total_sd, 0, ',', '.') }}</td>
                        <td class="td-num">{{ number_format($kab->total_smp, 0, ',', '.') }}</td>
                        <td class="td-num">{{ number_format($kab->total_sma_smk, 0, ',', '.') }}</td>
                        <td class="td-action">
                            <a href="{{ route('kabupaten', [urlencode($provinsi), urlencode($kab->kabupaten)]) }}" class="btn-view">
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
