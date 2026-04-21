<!DOCTYPE html>

<head>
    <title>PROGRAM PELATIHAN BERBASIS KOMPETENSI </title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'DejaVuSans', sans-serif;
            margin-left: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: none;
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
            text-align: justify;
        }

        #judul {
            text-align: left;
            font-family: sans-serif;
        }

        @page {
            size: A4 portrait;
            margin: 120px 30px 30px 30px;
        }


        header {
            position: fixed;
            top: -90px;
            left: 0px;
            right: 0px;
            height: 100px;
            padding: 0 18px;
            text-align: center;
            border-top: 1px solid;
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: none;
        }

        footer {
            position: fixed;
            bottom: -67px;
            left: 0px;
            right: 0px;
            height: 100px;
            margin-top: 10px;
            text-align: center;
            border-top: none;
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
        }

        th,
        td {
            padding-left: 0px;
            padding-right: 0px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>

    <style>
        .pdf-table {
            border-collapse: collapse;
            width: 100%;
        }

        .pdf-table th,
        .pdf-table td {
            border: 1px solid black;
            padding: 5px;
        }

        thead {
            display: table-header-group;
            /* Header akan diulang di setiap halaman */
        }

        tfoot {
            display: table-footer-group;
            /* Kalau mau footer diulang */
        }
    </style>
</head>

<body>
    <header>
        @php
            $setting = \App\Models\SettingApp::first();
        @endphp
        <table width="100%" style="margin-top:10px;" border="0">
            <tr>
                <td width="25%" style="text-align: left; vertical-align: middle;padding-left:0px;">
                    <img src="{{ public_path('storage/uploads/logos/' . ($setting->logo ?? 'default-logo.png')) }}"
                        width="140px" alt="Logo Kiri">
                </td>
                <td width="50%" style="text-align: center; vertical-align: middle;padding-right:10px;">
                    <b>PROGRAM PELATIHAN BERBASIS KOMPETENSI
                    </b>
                </td>
                <td width="25%" style="text-align: right; vertical-align: middle;padding-right:10px;">
                </td>
            </tr>
        </table>
    </header>
    <main style="margin-left: 30px;margin-right:30px;font-size: 13px;line-height:1.4;">
        <div style="margin-bottom: 8px;text-align:left;font-size:13px;">
            <b>
                A. INFORMASI UMUM
            </b>
        </div>

        <table class="pdf-table" border="1" width="100%"
            style="margin:15px 0;border-collapse:collapse;page-break-inside:avoid;font-size:13px;line-height:1.4;">

            <tbody>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top">1.</td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">Judul</td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:left;padding:6px;vertical-align:top;">
                        {{ $competences->scheme->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top">2.</td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">Kode </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:left;padding:6px;vertical-align:top;">{{ $generalInformation->kode ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top">3.</td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">Jenis Program </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:left;padding:6px;vertical-align:top;">
                        {{ $generalInformation->jenis_program ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top">4.</td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">Metode Pelatihan </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:left;padding:6px;vertical-align:top;">
                        {{ $generalInformation->metode_pelatihan ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top">5.</td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">Tujuan </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:justify;padding:6px;vertical-align:top;">
                        {{ $generalInformation->tujuan ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top">6.</td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">Profil Kompetensi </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:left;padding:6px;vertical-align:top;">
                        <table class="pdf-table" width="100%" style="border-collapse: collapse;line-height:0.9;">
                            <tbody>
                                @foreach ($dataKodeUnit as $item)
                                    <tr>
                                        <td style="border: none; width: 1px;">
                                            {{ $loop->iteration }}.
                                        </td>
                                        <td style="border: none;">
                                            {{ $item->unit ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top">7.</td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">Jenis Standart Kompetensi
                    </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:justify;padding:6px;vertical-align:top;">
                        {{ $generalInformation->jenis_standart_kompetensi ?? 'N/A' }}
                        {{ $competences->no_skkni ?? 'N/A' }}</td>
                    </td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top">8.</td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">Persyaratan Peserta
                        Pelatihan
                    </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:justify;padding:6px;vertical-align:top;">
                    </td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top"></td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">
                        8.1 Pendidikan
                    </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:justify;padding:6px;vertical-align:top;">
                        {{ $generalInformation->persyaratan_pendidikan ?? 'N/A' }}</td>
                    </td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top"></td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">
                        8.2 Pelatihan
                    </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:justify;padding:6px;vertical-align:top;">
                        {{ $generalInformation->persyaratan_pelatihan ?? 'N/A' }}</td>
                    </td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top"></td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">
                        8.3 Pengalaman Kerja
                    </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:justify;padding:6px;vertical-align:top;">
                        {{ $generalInformation->persyaratan_pengalaman_kerja ?? 'N/A' }}</td>
                    </td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top"></td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">
                        8.4 Umur
                    </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:justify;padding:6px;vertical-align:top;">
                        {{ $generalInformation->persyaratan_usia ?? 'N/A' }}</td>
                    </td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top"></td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">
                        8.5 Persyaratan Khusus
                    </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:justify;padding:6px;vertical-align:top;">
                        {{ $generalInformation->persyaratan_khusus_peserta ?? 'N/A' }}</td>
                    </td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top">9.</td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">Persyaratan Instruktur
                    </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:justify;padding:6px;vertical-align:top;">
                    </td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top"></td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">
                        9.1 Pendidikan Formal
                    </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:justify;padding:6px;vertical-align:top;">
                        {{ $generalInformation->instruktur_pendidikan_formal ?? 'N/A' }}</td>
                    </td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top"></td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">
                        9.2 Kompetensi Metodologi
                    </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:justify;padding:6px;vertical-align:top;">
                        {{ $generalInformation->instruktur_kompetensi_metodologi ?? 'N/A' }}</td>
                    </td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top"></td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">
                        9.3 Kompetensi Teknis
                    </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:justify;padding:6px;vertical-align:top;">
                        {{ $generalInformation->instruktur_kompetensi_teknis ?? 'N/A' }}</td>
                    </td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top"></td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">
                        9.4 Pengalaman Kerja
                    </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:justify;padding:6px;vertical-align:top;">
                        {{ $generalInformation->instruktur_pengalaman_kerja ?? 'N/A' }}</td>
                    </td>
                </tr>
                <tr>
                    <td width="5%" style="text-align:center;padding:6px;vertical-align:top"></td>
                    <td width="35%" style="text-align:left;padding:6px;vertical-align:top;">
                        9.5 Persyaratan Khusus
                    </td>
                    <td width="1%" style="text-align:center;padding:6px;vertical-align:top;">:</td>
                    <td style="text-align:justify;padding:6px;vertical-align:top;">
                        {{ $generalInformation->instruktur_persyaratan_khusus ?? 'N/A' }}</td>
                    </td>
                </tr>
            </tbody>
        </table>


        <div style="page-break-before: always;">
            <b>
                B. KURIKULUM PELATIHAN BERBASIS KOMPETENSI
            </b>
            <br>
            <br>
            <table class="pdf-table" border="1" width="100%"
                style="margin: 0 auto;border-collapse: collapse;font-size: 13px;line-height:1.4;">
                <tr>
                    <th class="text-white" width="1%">NO</th>
                    <th class="text-white">MATERI PELATIHAN / KODE UNIT</th>
                    <th class="text-white">PERKIRAAN WAKTU (JP) TEORI</th>
                    <th class="text-white">PERKIRAAN WAKTU (JP) PRAKTEK</th>
                    <th class="text-white">JUMLAH (JP)</th>
                </tr>
                </thead>
                <tbody>
                    <!-- KELOMPOK INTI -->
                    @php $no = 1; @endphp
                    @forelse ($curricula->where('kelompok', 'inti') as $item)
                        <tr>
                            <td style="vertical-align: top;text-align:center;">{{ $no++ }}.</td>
                            <td>
                                @if ($item->competenceCode)
                                    {{ $item->competenceCode->unit ?? '-' }}<br>
                                    <small class="text-muted">{{ $item->competenceCode->kode ?? '-' }}</small>
                                @else
                                    -
                                @endif
                            </td>
                            <td style="text-align: center;">{{ $item->perkiraan_waktu_teori ?? 0 }}</td>
                            <td style="text-align: center;">{{ $item->perkiraan_waktu_praktek ?? 0 }}</td>
                            <td style="text-align: center;font-weight: bold;">{{ $item->jumlah ?? 0 }}</td>
                        </tr>
                    @empty
                    @endforelse

                    <!-- Subtotal Kelompok Inti -->
                    @if ($curricula->where('kelompok', 'inti')->count() > 0)
                        <tr class="fw-bold bg-light">
                            <td colspan="2" style="vertical-align: top;text-align:center;font-weight: bold;">Jumlah
                                I
                                (Kelompok Inti)</td>
                            <td style="text-align: center;font-weight: bold;">{{ $subtotals['inti']['teori'] }}</td>
                            <td style="text-align: center;font-weight: bold;">{{ $subtotals['inti']['praktek'] }}</td>
                            <td style="text-align: center;font-weight: bold;">{{ $subtotals['inti']['jumlah'] }}</td>
                        </tr>
                    @endif

                    <!-- KELOMPOK PENUNJANG -->
                    @forelse ($curricula->where('kelompok', 'penunjang') as $item)
                        <tr>
                            <td style="vertical-align: top;text-align:center;">{{ $no++ }}.</td>
                            <td>
                                @if ($item->competenceCode)
                                    {{ $item->competenceCode->unit ?? '-' }}<br>
                                    <small class="text-muted">{{ $item->competenceCode->kode ?? '-' }}</small>
                                @else
                                    -
                                @endif
                            </td>
                            <td style="text-align: center;">{{ $item->perkiraan_waktu_teori ?? 0 }}</td>
                            <td style="text-align: center;">{{ $item->perkiraan_waktu_praktek ?? 0 }}</td>
                            <td style="text-align: center;font-weight: bold;">{{ $item->jumlah ?? 0 }}</td>
                        </tr>
                    @empty
                    @endforelse

                    <!-- Subtotal Kelompok Penunjang -->
                    @if ($curricula->where('kelompok', 'penunjang')->count() > 0)
                        <tr class="fw-bold bg-light">
                            <td colspan="2" style="vertical-align: top;text-align:center; font-weight: bold;">
                                Jumlah II
                                (Kelompok Penunjang)</td>
                            <td style="text-align: center;font-weight: bold;">{{ $subtotals['penunjang']['teori'] }}
                            </td>
                            <td style="text-align: center;font-weight: bold;">{{ $subtotals['penunjang']['praktek'] }}
                            </td>
                            <td style="text-align: center;font-weight: bold;">{{ $subtotals['penunjang']['jumlah'] }}
                            </td>
                        </tr>
                    @endif

                    <!-- Total Kelompok I & II -->
                    @if ($curricula->where('kelompok', '!=', 'ojt')->count() > 0)
                        <tr class="fw-bold bg-light">
                            <td colspan="2" style="vertical-align: top;text-align:center; font-weight: bold;">
                                Jumlah I
                                & II</td>
                            <td style="text-align: center;font-weight: bold;">{{ $subtotals['total']['teori'] }}</td>
                            <td style="text-align: center;font-weight: bold;">{{ $subtotals['total']['praktek'] }}
                            </td>
                            <td style="text-align: center;font-weight: bold;">{{ $subtotals['total']['jumlah'] }}</td>
                        </tr>
                    @endif

                    <!-- KELOMPOK OJT -->
                    @forelse ($curricula->where('kelompok', 'ojt') as $ojt)
                        <tr>
                            <td style="vertical-align: top;text-align:center;">III.</td>
                            <td style="vertical-align: top;text-align:left;">On the Job Training (OJT) / Pendampingan
                            </td>
                            <td colspan="3" style="text-align: center;">{{ $ojt->ojt_bulan ?? '-' }} Bulan</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="page-break-before: always;">
            <b>
                C. SILABUS PELATIHAN BERBASIS KOMPETENSI
            </b>
            <br>
            @foreach ($sillabus as $item)
                <table class="pdf-table" width="100%"
                    style="margin-left:-5px;margin-top: 8px; border-collapse: collapse; font-size: 13px; line-height:1.4; border: none;">
                    <tbody>
                        <tr>
                            <td width="1%" style="text-align:center;vertical-align:top;border:none;">
                                {{ $loop->iteration }}.
                            </td>
                            <td width="30%" style="text-align:left;vertical-align:top;border:none;">
                                Unit
                                Kompetensi</td>
                            <td width="1%" style="text-align:center;vertical-align:top;border:none;">:
                            </td>
                            <td style="text-align:left;vertical-align:top;border:none;">
                                {{ $item->unitKompetensi->unit ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top;border:none;"></td>
                            <td style="text-align:left;vertical-align:top;border:none;">Kode Unit</td>
                            <td style="text-align:center;vertical-align:top;border:none;">:</td>
                            <td style="text-align:left;vertical-align:top;border:none;">
                                {{ $item->unitKompetensi->kode ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top;border:none;"></td>
                            <td style="text-align:left;vertical-align:top;border:none;">Perkiraan Waktu
                                Pelatihan
                            </td>
                            <td style="text-align:center;vertical-align:top;border:none;">:</td>
                            <td style="text-align:left;vertical-align:top;border:none;">
                                {{ $item->waktu_pelatihan ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top;border:none;"></td>
                            <td style="text-align:left;vertical-align:top;border:none;">Metode Pelatihan
                            </td>
                            <td style="text-align:center;vertical-align:top;border:none;">:</td>
                            <td style="text-align:left;vertical-align:top;border:none;">
                                {{ $item->metode_pelatihan ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top;border:none;"></td>
                            <td style="text-align:left;vertical-align:top;border:none;">Capaian Unit
                                Kompetensi
                            </td>
                            <td style="text-align:center;vertical-align:top;border:none;">:</td>
                            <td style="text-align:justify;vertical-align:top;border:none;">
                                {{ $item->capaian_unit_kompetensi ?? 'N/A' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                @php
                    $sillabusDetails = \App\Models\SilabusDetail::where('silabus_id', $item->id)
                        ->orderBy('number', 'asc')
                        ->get();
                @endphp

                @foreach ($sillabusDetails as $detail)
                    <table class="pdf-table" border="1" width="100%"
                        style="margin: 8 auto;border-collapse: collapse;font-size: 13px;line-height:1.4;page-break-inside:avoid;">
                        <thead>
                            <tr>
                                <th class="text-white" width="50%">ELEMEN KOMPETENSI</th>
                                <th class="text-white" width="50%">KRITERIA UNJUK KERJA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align:left;padding:6px;vertical-align:top">
                                    <table class="pdf-table" width="100%"
                                        style="border-collapse: collapse;line-height:1.4;">
                                        <tbody>
                                            <tr>
                                                <td style="border: none; width: 1px; vertical-align: top;">
                                                    {{ $loop->iteration }}.
                                                </td>
                                                <td style="border: none; vertical-align: top;">
                                                    {{ $detail->element->element ?? 'N/A' }}

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>

                                <td style="text-align:left;padding:6px;vertical-align:top">

                                    @php
                                        $kukList = \App\Models\CompetenceKuk::where(
                                            'competence_code_element_id',
                                            $detail->element_id,
                                        )
                                            ->orderBy('number', 'asc')
                                            ->get();
                                    @endphp

                                    @foreach ($kukList as $kuk)
                                        <table class="pdf-table" width="100%"
                                            style="border-collapse: collapse;line-height:1.4;">
                                            <tbody>
                                                <tr>
                                                    <td style="border: none; width: 1px;vertical-align: top;">
                                                        {{ $loop->parent->iteration }}.{{ $loop->iteration }}.
                                                    </td>
                                                    <td style="border: none; vertical-align: top;">
                                                        {{ $kuk->kuk ?? 'N/A' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endforeach

                                </td>
                            </tr>
                            <tr>
                                <th class="text-white" width="50%">INDIKATOR UNJUK KERJA</th>
                                <th class="text-white" width="50%">PENGETAHUAN</th>
                            </tr>
                            <tr>
                                <td style="text-align:left;padding:6px;padding:6px; vertical-align:top">
                                    {!! str_replace(
                                        ['<p>', '<ol>', '<li>'],
                                        [
                                            '<p style="margin-top:2px;margin-bottom:4px;">',
                                            '<ol style="margin-top:4px;margin-bottom:4px;padding-left:22px;">',
                                            '<li style="margin-bottom:3px;padding-left:2px;">',
                                        ],
                                        $detail->indikator_unjuk_kerja ?? 'N/A',
                                    ) !!}
                                </td>
                                <td style="text-align:left;padding:6px;vertical-align:top">
                                    {!! str_replace(
                                        ['<p>', '<ol>', '<li>'],
                                        [
                                            '<p style="margin-top:2px;margin-bottom:4px;">',
                                            '<ol style="margin-top:4px;margin-bottom:4px;padding-left:22px;">',
                                            '<li style="margin-bottom:3px;padding-left:2px;">',
                                        ],
                                        $detail->pengetahuan ?? 'N/A',
                                    ) !!}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-white" width="50%">KETERAMPILAN DAN SIKAP</th>
                                <th class="text-white" width="50%">DURASI (MENIT)</th>
                            </tr>
                            <tr>
                                <td style="text-align:left;padding:6px;vertical-align:top">
                                    {!! str_replace(
                                        ['<p>', '<ol>', '<li>'],
                                        [
                                            '<p style="margin-top:2px;margin-bottom:4px;">',
                                            '<ol style="margin-top:4px;margin-bottom:4px;padding-left:22px;">',
                                            '<li style="margin-bottom:3px;padding-left:2px;">',
                                        ],
                                        $detail->keterampilan_sikap ?? 'N/A',
                                    ) !!}
                                </td>
                                <td style="text-align:left;padding:6px;vertical-align:top">
                                    {{ $detail->durasi }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach
            @endforeach
        </div>

        <div style="page-break-before: always;">
            <div style="page-break-inside: avoid">
                <b>
                    D. RENCANA PEMBELAJARAN (LESSON PLAN)
                </b>
                <br>

                <table class="pdf-table" border="1" width="100%"
                    style="margin:15px 0;border-collapse:collapse;page-break-inside:avoid;font-size:13px;line-height:1.4;">
                    <tbody>
                        <tr>
                            <td width="50%" style="text-align:left;padding:6px;vertical-align:top;">
                                <b>NAMA PROGRAM PELATIHAN : </b> <br>
                                {{ $competences->scheme->name ?? 'N/A' }}

                            </td>
                            <td width="50%" style="text-align:left;padding:6px;vertical-align:top;">
                                <b>PENYAJIAN :</b> {{ $lessonPlans->penyajian_hari ?? 'N/A' }} Hari
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" style="text-align:left;vertical-align:top;">
                                <b>UNIT KOMPETENSI : </b> <br>
                                <table class="pdf-table" width="100%"
                                    style="border-collapse: collapse; line-height: 1.3;">
                                    <tbody>
                                        @foreach ($dataKodeUnit as $item)
                                            <tr>
                                                <td style="border: none; width: 10px; vertical-align: top;">
                                                    {{ $loop->iteration }}.
                                                </td>
                                                <td style="border: none; padding-bottom: 0px;">
                                                    {{ $item->unit ?? 'N/A' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td width="50%" style="text-align:left;padding:6px;vertical-align:top;">
                                <b>WAKTU :</b> {{ $lessonPlans->waktu_jp ?? 'N/A' }} Menit
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center;padding:6px;vertical-align:top;">
                                <b>JUDUL PELATIHAN :</b> <br>
                                {{ $competences->scheme->name ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:left;padding:6px;vertical-align:top;">
                                <b>TUJUAN INSTRUKSIONAL :</b> <br>

                                {!! str_replace(
                                    ['<p>', '<ol>', '<li>'],
                                    [
                                        '<p style="margin-top:2px;margin-bottom:4px;">',
                                        '<ol style="margin-top:4px;margin-bottom:4px;padding-left:22px;">',
                                        '<li style="margin-bottom:3px;padding-left:2px;">',
                                    ],
                                    $lessonPlans->tujuan_instruksional ?? 'N/A',
                                ) !!}
                            </td>
                        </tr>
                        <tr>
                            <td width="50%" style="text-align:left;padding:6px;vertical-align:top;">
                                <b>METODE MENGAJAR : </b>
                            </td>
                            <td width="50%" style="text-align:left;padding:6px;vertical-align:top;">
                                {!! str_replace(
                                    ['<p>', '<ol>', '<li>'],
                                    [
                                        '<p style="margin-top:2px;margin-bottom:4px;">',
                                        '<ol style="margin-top:4px;margin-bottom:4px;padding-left:22px;">',
                                        '<li style="margin-bottom:3px;padding-left:2px;">',
                                    ],
                                    $lessonPlans->metode ?? 'N/A',
                                ) !!} </td>
                        </tr>
                        <tr>
                            <td width="50%" style="text-align:left;padding:6px;vertical-align:top;">
                                <b>MEDIA : </b>
                            </td>
                            <td width="50%" style="text-align:left;padding:6px;vertical-align:top;">
                                {!! str_replace(
                                    ['<p>', '<ol>', '<li>'],
                                    [
                                        '<p style="margin-top:2px;margin-bottom:4px;">',
                                        '<ol style="margin-top:4px;margin-bottom:4px;padding-left:22px;">',
                                        '<li style="margin-bottom:3px;padding-left:2px;">',
                                    ],
                                    $lessonPlans->media ?? 'N/A',
                                ) !!} </td>
                        </tr>
                        <tr>
                            <td width="50%" style="text-align:left;padding:6px;vertical-align:top;">
                                <b>PERSIAPAN : </b>
                            </td>
                            <td width="50%" style="text-align:left;padding:6px;vertical-align:top;">
                                {!! str_replace(
                                    ['<p>', '<ol>', '<li>'],
                                    [
                                        '<p style="margin-top:2px;margin-bottom:4px;">',
                                        '<ol style="margin-top:4px;margin-bottom:4px;padding-left:22px;">',
                                        '<li style="margin-bottom:3px;padding-left:2px;">',
                                    ],
                                    $lessonPlans->persiapan ?? 'N/A',
                                ) !!} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <table class="pdf-table" border="1" width="100%"
                style="margin:15px 0;border-collapse:collapse;page-break-inside:avoid;font-size:13px;line-height:1.4;">
                <tbody>
                    <tr>
                        <td WIDTH="20%" style="text-align:left;padding:6px;vertical-align:top;">
                            <b>SUB POKOK BAHASAN </b>
                        </td>
                        <td WIDTH="50%" style="text-align:left;padding:6px;vertical-align:top;">
                            <b>URAIAN / KEGIATAN </b>
                        </td>
                        <td WIDTH="35%" style="text-align:left;padding:6px;vertical-align:top;">
                            <b>MEDIA </b>
                        </td>
                        <td WIDTH="15%" style="text-align:left;padding:6px;vertical-align:top;">
                            <b>WAKTU</b>
                        </td>
                    </tr>
                    @foreach ($lessonPlanDetails as $detail)
                        <tr>
                            <td style="vertical-align: top;text-align: left;">
                                {!! str_replace(
                                    ['<p>', '<ol>', '<li>'],
                                    [
                                        '<p style="margin-top:2px;margin-bottom:4px;">',
                                        '<ol style="margin-top:4px;margin-bottom:4px;padding-left:22px;">',
                                        '<li style="margin-bottom:3px;padding-left:2px;">',
                                    ],
                                    $detail->sub_pokok ?? 'N/A',
                                ) !!}
                            </td>
                            <td style="vertical-align: top;text-align: left;">
                                {!! str_replace(
                                    ['<p>', '<ol>', '<li>'],
                                    [
                                        '<p style="margin-top:2px;margin-bottom:4px;">',
                                        '<ol style="margin-top:4px;margin-bottom:4px;padding-left:22px;">',
                                        '<li style="margin-bottom:3px;padding-left:2px;">',
                                    ],
                                    $detail->uraian ?? 'N/A',
                                ) !!}
                            </td>
                            <td style="vertical-align: top;text-align: justify;">
                                {!! str_replace(
                                    ['<p>', '<ol>', '<li>'],
                                    [
                                        '<p style="margin-top:2px;margin-bottom:4px;">',
                                        '<ol style="margin-top:4px;margin-bottom:4px;padding-left:22px;">',
                                        '<li style="margin-bottom:3px;padding-left:2px;">',
                                    ],
                                    $detail->media ?? 'N/A',
                                ) !!}
                            </td>
                            <td style="vertical-align: top;text-align: center;">
                                {{ $detail->waktu ?? 'N/A' }} Menit
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" style="text-align:right;padding:6px;vertical-align:top;font-weight: bold;">
                            Total Waktu</td>
                        <td style="text-align: center;font-weight: bold;">
                            {{ $lessonPlanDetails->sum('waktu') ?? 0 }}
                            Menit</td>
                    </tr>
                </tbody>
            </table>
        </div>



        <div style="page-break-before: always;">

            @if ($equipments)
                <div style="page-break-inside: avoid">
                    <b>
                        E. DAFTAR PERALATAN YANG DIGUNAKAN
                    </b>
                    <br>
                    <table class="pdf-table" width="100%"
                        style="margin-left:-5px; margin-top:8px; border-collapse: collapse; font-size: 13px; line-height:1; border: none;">
                        <tbody>
                            <tr>
                                <td width="30%"
                                    style="text-align:left;padding:6px;vertical-align:top;border:none;">
                                    Judul/Nama Pelatihan
                                </td>
                                <td width="1%"
                                    style="text-align:center;padding:6px;vertical-align:top;border:none;">:
                                </td>
                                <td style="text-align:left;padding:6px;vertical-align:top;border:none;">
                                    {{ $competences->scheme->name ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left;padding:6px;vertical-align:top;border:none;">Perkiraan
                                    Waktu
                                    Pelatihan </td>
                                <td style="text-align:center;padding:6px;vertical-align:top;border:none;">:</td>
                                <td style="text-align:left;padding:6px;vertical-align:top;border:none;">
                                    {{ $equipments->perkiraan_waktu_pelatihan ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left;padding:6px;vertical-align:top;border:none;">Jumlah
                                    Peserta
                                </td>
                                <td style="text-align:center;padding:6px;vertical-align:top;border:none;">:</td>
                                <td style="text-align:left;padding:6px;vertical-align:top;border:none;">
                                    {{ $equipments->jumlah_peserta ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left;padding:6px;vertical-align:top;border:none;">Metode
                                    Pelatihan
                                </td>
                                <td style="text-align:center;padding:6px;vertical-align:top;border:none;">:</td>
                                <td style="text-align:left;padding:6px;vertical-align:top;border:none;">
                                    {{ $equipments->metode_pelatihan ?? 'N/A' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="pdf-table" border="1" width="100%"
                        style="margin:15px 0;border-collapse:collapse;page-break-inside:avoid;font-size:13px;line-height:1.4;">
                        <thead>
                            <tr>
                                <th width="1%" style="text-align:center;padding:6px;vertical-align:top">
                                    No
                                </th>
                                <th style="text-align:left;padding:6px;vertical-align:top">
                                    Daftar Peralatan
                                </th>
                                <th style="text-align:left;padding:6px;vertical-align:top">
                                    Spesifikasi
                                </th>
                                <th style="text-align:left;padding:6px;vertical-align:top">
                                    Satuan
                                </th>
                                <th style="text-align:left;padding:6px;vertical-align:top">
                                    Jumlah
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipmentDetails as $item)
                                <tr>
                                    <td style="text-align:center;padding:6px;vertical-align:top">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td style="text-align:left;padding:6px;vertical-align:top">
                                        {{ $item->nama_peralatan ?? 'N/A' }}
                                    </td>
                                    <td style="text-align:left;padding:6px;vertical-align:top">
                                        {{ $item->spesifikasi ?? 'N/A' }}
                                    </td>
                                    <td style="text-align:left;padding:6px;vertical-align:top">
                                        {{ $item->satuan ?? 'N/A' }}
                                    </td>
                                    <td style="text-align:left;padding:6px;vertical-align:top">
                                        {{ $item->jumlah ?? 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>

        <div style="page-break-before: always;">

            @if ($supplys)
                <div style="page-break-inside: avoid">
                    <b>
                        F. DAFTAR PERLENGKAPAN YANG DIBUTUHKAN
                    </b>
                    <br>
                    <table class="pdf-table" width="100%"
                        style="margin-left:-5px; margin-top:8px; border-collapse: collapse; font-size: 13px; line-height:1; border: none;">
                        <tbody>
                            <tr>
                                <td width="30%"
                                    style="text-align:left;padding:6px;vertical-align:top;border:none;">
                                    Judul/Nama Pelatihan
                                </td>
                                <td width="1%"
                                    style="text-align:center;padding:6px;vertical-align:top;border:none;">:
                                </td>
                                <td style="text-align:left;padding:6px;vertical-align:top;border:none;">
                                    {{ $competences->scheme->name ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left;padding:6px;vertical-align:top;border:none;">Perkiraan
                                    Waktu
                                    Pelatihan </td>
                                <td style="text-align:center;padding:6px;vertical-align:top;border:none;">:</td>
                                <td style="text-align:left;padding:6px;vertical-align:top;border:none;">
                                    {{ $supplys->perkiraan_waktu_pelatihan ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left;padding:6px;vertical-align:top;border:none;">Jumlah
                                    Peserta
                                </td>
                                <td style="text-align:center;padding:6px;vertical-align:top;border:none;">:</td>
                                <td style="text-align:left;padding:6px;vertical-align:top;border:none;">
                                    {{ $supplys->jumlah_peserta ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:left;padding:6px;vertical-align:top;border:none;">Metode
                                    Pelatihan
                                </td>
                                <td style="text-align:center;padding:6px;vertical-align:top;border:none;">:</td>
                                <td style="text-align:left;padding:6px;vertical-align:top;border:none;">
                                    {{ $supplys->metode_pelatihan ?? 'N/A' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="pdf-table" border="1" width="100%"
                        style="margin:15px 0;border-collapse:collapse;page-break-inside:avoid;font-size:13px;line-height:1.4;">
                        <thead>
                            <tr>
                                <th width="1%" style="text-align:center;padding:6px;vertical-align:top">
                                    No
                                </th>
                                <th style="text-align:left;padding:6px;vertical-align:top">
                                    Daftar Peralatan
                                </th>
                                <th style="text-align:left;padding:6px;vertical-align:top">
                                    Spesifikasi
                                </th>
                                <th style="text-align:left;padding:6px;vertical-align:top">
                                    Satuan
                                </th>
                                <th style="text-align:left;padding:6px;vertical-align:top">
                                    Jumlah
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($supplyDetails as $item)
                                <tr>
                                    <td style="text-align:center;padding:6px;vertical-align:top">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td style="text-align:left;padding:6px;vertical-align:top">
                                        {{ $item->nama_peralatan ?? 'N/A' }}
                                    </td>
                                    <td style="text-align:left;padding:6px;vertical-align:top">
                                        {{ $item->spesifikasi ?? 'N/A' }}
                                    </td>
                                    <td style="text-align:left;padding:6px;vertical-align:top">
                                        {{ $item->satuan ?? 'N/A' }}
                                    </td>
                                    <td style="text-align:left;padding:6px;vertical-align:top">
                                        {{ $item->jumlah ?? 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>




    </main>

</body>
</main>

</body>
