@extends('layouts.app')

@php
    $provClean = str_replace('Prov. ', '', $provinsi);
    $totalNegeri = $kecamatanData->sum('total_negeri');
    $totalSwasta = $kecamatanData->sum('total_swasta');
@endphp

@section('title', 'Data Sekolah ' . $kabupaten . ', ' . $provClean . ' - Daftar Kecamatan')
@section('meta_description', 'Daftar sekolah di ' . $kabupaten . ', ' . $provClean . '. Total ' . number_format($totalSekolah) . ' sekolah tersebar di ' . $kecamatanData->count() . ' kecamatan.')
@section('meta_keywords', 'sekolah ' . $kabupaten . ', data sekolah ' . $kabupaten . ' ' . $provClean)

@section('content')
    {{-- Breadcrumb --}}
    <nav class="breadcrumb" data-aos="fade-right">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Beranda</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <a href="{{ route('provinsi', urlencode($provinsi)) }}">{{ $provClean }}</a>
        <span class="separator"><i class="fas fa-chevron-right"></i></span>
        <span class="current">{{ $kabupaten }}</span>
    </nav>

    {{-- Page Header --}}
    <div class="page-header" data-aos="fade-up">
        <h1><i class="fas fa-city"></i> {{ $kabupaten }}</h1>
        <p>{{ $provClean }} — <strong>{{ $kecamatanData->count() }}</strong> kecamatan, <strong>{{ number_format($totalSekolah, 0, ',', '.') }}</strong> sekolah</p>
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
            <div class="stat-icon"><i class="fas fa-map-signs"></i></div>
            <div class="stat-value"><span class="counter-animate" data-target="{{ $kecamatanData->count() }}">0</span></div>
            <div class="stat-label">Kecamatan</div>
        </div>
    </section>

    {{-- Kecamatan Table --}}
    <section data-aos="fade-up" data-aos-delay="200">
        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="th-no">No</th>
                        <th class="th-name">Kecamatan</th>
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
                    @foreach($kecamatanData as $kec)
                    <tr data-aos="fade-up" data-aos-delay="{{ min($loop->index * 20, 200) }}">
                        <td class="td-no">{{ $loop->iteration }}</td>
                        <td class="td-name">
                            <a href="{{ route('kecamatan', [urlencode($provinsi), urlencode($kabupaten), urlencode($kec->kecamatan)]) }}">
                                <i class="fas fa-map-pin"></i>
                                {{ $kec->kecamatan }}
                            </a>
                        </td>
                        <td class="td-num"><span class="num-total">{{ number_format($kec->total_sekolah, 0, ',', '.') }}</span></td>
                        <td class="td-num"><span class="badge-inline badge-negeri">{{ number_format($kec->total_negeri, 0, ',', '.') }}</span></td>
                        <td class="td-num"><span class="badge-inline badge-swasta">{{ number_format($kec->total_swasta, 0, ',', '.') }}</span></td>
                        <td class="td-num">{{ number_format($kec->total_sd, 0, ',', '.') }}</td>
                        <td class="td-num">{{ number_format($kec->total_smp, 0, ',', '.') }}</td>
                        <td class="td-num">{{ number_format($kec->total_sma_smk, 0, ',', '.') }}</td>
                        <td class="td-action">
                            <a href="{{ route('kecamatan', [urlencode($provinsi), urlencode($kabupaten), urlencode($kec->kecamatan)]) }}" class="btn-view">
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
