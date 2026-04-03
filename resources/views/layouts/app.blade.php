<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Data Sekolah Indonesia">
    <title>@yield('title', 'Data Sekolah Indonesia - Informasi Lengkap Sekolah Se-Indonesia')</title>
    <meta name="description" content="@yield('meta_description', 'Database lengkap sekolah se-Indonesia. Cari informasi sekolah berdasarkan provinsi, kabupaten, dan kecamatan. Data NPSN, akreditasi, dan lokasi sekolah.')">
    <meta name="keywords" content="@yield('meta_keywords', 'data sekolah indonesia, NPSN, sekolah negeri, sekolah swasta, SD, SMP, SMA, SMK')">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Data Sekolah Indonesia')">
    <meta property="og:description" content="@yield('meta_description', 'Database lengkap sekolah se-Indonesia')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Data Sekolah Indonesia">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    {{-- AOS Animation --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --primary-dark: #3730a3;
            --secondary: #06b6d4;
            --accent: #f59e0b;
            --accent-pink: #ec4899;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;

            --bg-main: #f0f4ff;
            --bg-card: #ffffff;
            --bg-glass: rgba(255, 255, 255, 0.85);
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;

            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.05);
            --shadow-lg: 0 10px 25px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.04);
            --shadow-xl: 0 20px 50px -12px rgba(0,0,0,0.15);

            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;

            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-main);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ========== ANIMATED BACKGROUND ========== */
        .bg-decoration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .bg-decoration .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: floatOrb 20s ease-in-out infinite;
        }

        .bg-decoration .orb:nth-child(1) {
            width: 500px;
            height: 500px;
            background: var(--primary);
            top: -100px;
            right: -150px;
            animation-delay: 0s;
        }

        .bg-decoration .orb:nth-child(2) {
            width: 400px;
            height: 400px;
            background: var(--secondary);
            bottom: -100px;
            left: -100px;
            animation-delay: -7s;
        }

        .bg-decoration .orb:nth-child(3) {
            width: 300px;
            height: 300px;
            background: var(--accent-pink);
            top: 40%;
            left: 60%;
            animation-delay: -14s;
        }

        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(50px, -80px) scale(1.1); }
            50% { transform: translate(-30px, 60px) scale(0.9); }
            75% { transform: translate(70px, 40px) scale(1.05); }
        }

        /* ========== NAVBAR ========== */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--bg-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.3);
            padding: 0 2rem;
            box-shadow: var(--shadow-sm);
        }

        .navbar-inner {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-primary);
        }

        .navbar-brand .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .navbar-brand .brand-text {
            font-weight: 700;
            font-size: 1.2rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-brand .brand-sub {
            font-size: 0.7rem;
            color: var(--text-muted);
            font-weight: 400;
            display: block;
            line-height: 1.2;
        }

        /* Search box */
        .search-container {
            position: relative;
            width: 380px;
        }

        .search-input {
            width: 100%;
            padding: 10px 18px 10px 44px;
            border: 2px solid rgba(79, 70, 229, 0.1);
            border-radius: 50px;
            font-size: 0.9rem;
            font-family: inherit;
            background: rgba(255,255,255,0.8);
            transition: var(--transition);
            outline: none;
        }

        .search-input:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            background: white;
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            margin-top: 8px;
            background: white;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-xl);
            max-height: 400px;
            overflow-y: auto;
            display: none;
            z-index: 1001;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .search-results.active {
            display: block;
        }

        .search-result-item {
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            color: var(--text-primary);
            border-bottom: 1px solid rgba(0,0,0,0.03);
        }

        .search-result-item:hover {
            background: var(--bg-main);
        }

        .search-result-item .sr-icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: white;
            flex-shrink: 0;
        }

        .search-result-item .sr-info h4 {
            font-size: 0.85rem;
            font-weight: 600;
        }

        .search-result-item .sr-info p {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            position: relative;
            z-index: 1;
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* ========== HERO SECTION ========== */
        .hero {
            text-align: center;
            padding: 3rem 1rem 2rem;
        }

        .hero h1 {
            font-size: 2.8rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--accent-pink));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.15rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        /* ========== STATS OVERVIEW ========== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.2rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(255,255,255,0.5);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }

        .stat-card:nth-child(1)::before { background: linear-gradient(90deg, var(--primary), var(--primary-light)); }
        .stat-card:nth-child(2)::before { background: linear-gradient(90deg, var(--success), #34d399); }
        .stat-card:nth-child(3)::before { background: linear-gradient(90deg, var(--accent-pink), #f472b6); }
        .stat-card:nth-child(4)::before { background: linear-gradient(90deg, var(--accent), #fbbf24); }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }

        .stat-card:nth-child(1) .stat-icon { background: rgba(79, 70, 229, 0.1); color: var(--primary); }
        .stat-card:nth-child(2) .stat-icon { background: rgba(16, 185, 129, 0.1); color: var(--success); }
        .stat-card:nth-child(3) .stat-icon { background: rgba(236, 72, 153, 0.1); color: var(--accent-pink); }
        .stat-card:nth-child(4) .stat-icon { background: rgba(245, 158, 11, 0.1); color: var(--accent); }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 0.3rem;
        }

        .stat-card .stat-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* ========== BREADCRUMB ========== */
        .breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 1rem 0;
            margin-bottom: 1rem;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .breadcrumb a:hover {
            color: var(--primary-dark);
        }

        .breadcrumb .separator {
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        .breadcrumb .current {
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* ========== PAGE HEADER ========== */
        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        /* ========== DATA TABLE ========== */
        .data-table-container {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(0,0,0,0.04);
            overflow: hidden;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .data-table thead {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
        }

        .data-table thead th {
            padding: 1rem 1rem;
            font-weight: 600;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            text-align: left;
        }

        .data-table thead th.th-no {
            width: 50px;
            text-align: center;
        }

        .data-table thead th.th-num {
            text-align: right;
            width: 90px;
        }

        .data-table thead th.th-action {
            text-align: center;
            width: 100px;
        }

        .data-table tbody tr {
            border-bottom: 1px solid rgba(0,0,0,0.04);
            transition: var(--transition);
        }

        .data-table tbody tr:nth-child(even) {
            background: rgba(79, 70, 229, 0.015);
        }

        .data-table tbody tr:hover {
            background: rgba(79, 70, 229, 0.05);
        }

        .data-table tbody td {
            padding: 0.85rem 1rem;
            vertical-align: middle;
        }

        .data-table tbody td.td-no {
            text-align: center;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.82rem;
        }

        .data-table tbody td.td-name a {
            color: var(--primary-dark);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .data-table tbody td.td-name a:hover {
            color: var(--primary);
            transform: translateX(3px);
        }

        .data-table tbody td.td-name a i {
            color: var(--primary-light);
            font-size: 0.85rem;
        }

        .data-table tbody td.td-num {
            text-align: right;
            font-weight: 500;
            font-variant-numeric: tabular-nums;
        }

        .data-table tbody td.td-action {
            text-align: center;
        }

        .num-total {
            font-weight: 700;
            color: var(--primary);
            font-size: 0.95rem;
        }

        .badge-inline {
            padding: 0.2rem 0.6rem;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-inline.badge-negeri {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .badge-inline.badge-swasta {
            background: rgba(236, 72, 153, 0.1);
            color: var(--accent-pink);
        }

        .btn-view {
            padding: 0.4rem 0.9rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-view:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            color: white;
        }

        .npsn-code {
            background: rgba(79, 70, 229, 0.08);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--primary);
            font-family: 'Plus Jakarta Sans', monospace;
        }

        .badge-jenjang {
            padding: 0.2rem 0.6rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-block;
            white-space: nowrap;
        }

        .badge-akreditasi {
            padding: 0.2rem 0.55rem;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 700;
            background: rgba(245, 158, 11, 0.1);
            color: var(--accent);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .badge {
            padding: 0.25rem 0.6rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-negeri {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .badge-swasta {
            background: rgba(236, 72, 153, 0.1);
            color: var(--accent-pink);
        }

        /* ========== MAP CONTAINER ========== */
        .map-section {
            margin-bottom: 2rem;
        }

        .map-container {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(0,0,0,0.04);
        }

        .map-container .map-header {
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .map-container .map-header i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .map-container .map-header h3 {
            font-weight: 700;
            font-size: 1rem;
        }

        #mapLeaflet {
            height: 500px;
            width: 100%;
        }

        /* ========== SCHOOL DETAIL PAGE ========== */
        .detail-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
        }

        .detail-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0,0,0,0.04);
            margin-bottom: 1.5rem;
        }

        .detail-card h2 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-card h2 i {
            color: var(--primary);
        }

        .detail-table {
            width: 100%;
        }

        .detail-table tr {
            border-bottom: 1px solid rgba(0,0,0,0.04);
        }

        .detail-table tr:last-child {
            border-bottom: none;
        }

        .detail-table td {
            padding: 0.7rem 0;
            font-size: 0.9rem;
            vertical-align: top;
        }

        .detail-table td:first-child {
            color: var(--text-muted);
            font-weight: 500;
            width: 40%;
            padding-right: 1rem;
        }

        .detail-table td:last-child {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Stat bars */
        .stat-bar-container {
            margin-bottom: 1rem;
        }

        .stat-bar-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.82rem;
            margin-bottom: 0.3rem;
        }

        .stat-bar-label span:first-child {
            color: var(--text-secondary);
            font-weight: 500;
        }

        .stat-bar-label span:last-child {
            font-weight: 700;
            color: var(--primary);
        }

        .stat-bar {
            height: 8px;
            background: var(--bg-main);
            border-radius: 50px;
            overflow: hidden;
        }

        .stat-bar-fill {
            height: 100%;
            border-radius: 50px;
            transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            width: 0;
        }

        .stat-bar-fill.bar-primary {
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
        }

        .stat-bar-fill.bar-success {
            background: linear-gradient(90deg, var(--success), #34d399);
        }

        .stat-bar-fill.bar-warning {
            background: linear-gradient(90deg, var(--accent), #fbbf24);
        }

        .stat-bar-fill.bar-pink {
            background: linear-gradient(90deg, var(--accent-pink), #f472b6);
        }

        .stat-bar-fill.bar-cyan {
            background: linear-gradient(90deg, var(--secondary), #22d3ee);
        }

        /* ========== PAGINATION ========== */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .pagination-wrapper nav {
            display: flex;
            gap: 0.3rem;
        }

        .pagination-wrapper nav span,
        .pagination-wrapper nav a {
            padding: 0.5rem 0.9rem;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .pagination-wrapper .page-item.active .page-link,
        .pagination-wrapper nav span[aria-current="page"] span {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
        }

        .pagination-wrapper nav a {
            background: var(--bg-card);
            color: var(--text-secondary);
            border: 1px solid rgba(0,0,0,0.06);
        }

        .pagination-wrapper nav a:hover {
            background: var(--primary);
            color: white;
        }

        .pagination-wrapper nav span[aria-disabled="true"] span {
            background: var(--bg-main);
            color: var(--text-muted);
            cursor: not-allowed;
        }

        /* ========== FOOTER ========== */
        .footer {
            margin-top: 3rem;
            padding: 2rem;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        .footer a {
            color: var(--primary);
            text-decoration: none;
        }

        /* ========== COUNTER ANIMATION ========== */
        .counter-animate {
            display: inline-block;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .navbar-inner {
                flex-direction: column;
                height: auto;
                padding: 1rem 0;
                gap: 0.8rem;
            }

            .search-container {
                width: 100%;
            }

            .hero h1 {
                font-size: 1.8rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .main-content {
                padding: 1rem;
            }

            #mapLeaflet {
                height: 350px;
            }

            .data-table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .data-table {
                min-width: 700px;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ========== LOADING SKELETON ========== */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: var(--radius-sm);
        }

        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* ========== TOOLTIP ========== */
        .tooltip-custom {
            position: relative;
        }

        .tooltip-custom::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--text-primary);
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: var(--transition);
        }

        .tooltip-custom:hover::after {
            opacity: 1;
            transform: translateX(-50%) translateY(-4px);
        }

        /* ========== CHART COLORS ========== */
        .chart-container {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0,0,0,0.04);
        }

        /* Mobile Nav Toggle */
        .nav-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-primary);
            cursor: pointer;
        }

        /* Smooth scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-main);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 50px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* Leaflet popup customization */
        .leaflet-popup-content-wrapper {
            border-radius: var(--radius-md) !important;
            box-shadow: var(--shadow-lg) !important;
            border: 1px solid rgba(0,0,0,0.05) !important;
        }

        .leaflet-popup-content {
            margin: 12px 16px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        .popup-school-name {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--primary-dark);
            margin-bottom: 4px;
        }

        .popup-school-meta {
            font-size: 0.78rem;
            color: var(--text-secondary);
        }

        .popup-school-link {
            display: inline-block;
            margin-top: 6px;
            font-size: 0.78rem;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .popup-school-link:hover {
            text-decoration: underline;
        }
    </style>

    @yield('extra_styles')
</head>
<body>
    {{-- Animated Background --}}
    <div class="bg-decoration">
        <div class="orb"></div>
        <div class="orb"></div>
        <div class="orb"></div>
    </div>

    {{-- Navbar --}}
    <nav class="navbar" id="navbar">
        <div class="navbar-inner">
            <a href="{{ route('home') }}" class="navbar-brand">
                <div class="logo-icon">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <span class="brand-text">Data Sekolah</span>
                    <span class="brand-sub">Seluruh Indonesia</span>
                </div>
            </a>

            <div class="search-container" id="searchContainer">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" id="searchInput" placeholder="Cari nama sekolah atau NPSN..." autocomplete="off">
                <div class="search-results" id="searchResults"></div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer">
        <p>&copy; {{ date('Y') }} <strong>Data Sekolah Indonesia</strong> — Sumber data: <a href="https://sekolah.data.kemendikdasmen.go.id" target="_blank">Kemendikdasmen RI</a></p>
        <p style="margin-top: 0.5rem; font-size: 0.78rem;">Data terakhir diperbarui dari database resmi Kementerian Pendidikan Dasar dan Menengah</p>
    </footer>

    {{-- Scripts --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 600,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50
        });

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 3) {
                searchResults.classList.remove('active');
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`/api/search?q=${encodeURIComponent(query)}`)
                    .then(r => r.json())
                    .then(data => {
                        if (data.length === 0) {
                            searchResults.innerHTML = '<div style="padding: 1rem; text-align: center; color: var(--text-muted);">Tidak ditemukan</div>';
                        } else {
                            searchResults.innerHTML = data.map(item => {
                                const bgColors = {
                                    'SD': '#4f46e5', 'MI': '#4f46e5',
                                    'SMP': '#06b6d4',
                                    'SMA': '#f59e0b', 'SMK': '#ec4899',
                                    'SPK SD': '#4f46e5', 'SPK SMP': '#06b6d4', 'SPK SMA': '#f59e0b'
                                };
                                const bg = bgColors[item.bentuk_pendidikan] || '#6366f1';
                                return `
                                    <a href="/sekolah/${item.npsn}" class="search-result-item">
                                        <div class="sr-icon" style="background:${bg}">${item.bentuk_pendidikan}</div>
                                        <div class="sr-info">
                                            <h4>${item.nama}</h4>
                                            <p>${item.kecamatan}, ${item.kabupaten}, ${item.provinsi}</p>
                                        </div>
                                    </a>
                                `;
                            }).join('');
                        }
                        searchResults.classList.add('active');
                    });
            }, 350);
        });

        document.addEventListener('click', function(e) {
            if (!document.getElementById('searchContainer').contains(e.target)) {
                searchResults.classList.remove('active');
            }
        });

        // Counter animation
        function animateCounters() {
            document.querySelectorAll('.counter-animate').forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                if (isNaN(target)) return;
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;

                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    counter.textContent = Math.floor(current).toLocaleString('id-ID');
                }, 16);
            });
        }

        // Trigger counter animation when visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.disconnect();
                }
            });
        });

        const statCards = document.querySelector('.stats-grid');
        if (statCards) observer.observe(statCards);

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = 'var(--shadow-md)';
            } else {
                navbar.style.boxShadow = 'var(--shadow-sm)';
            }
        });
    </script>

    @yield('extra_scripts')
</body>
</html>
