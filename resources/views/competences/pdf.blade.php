<!DOCTYPE html>

<head>
    <title>SKEMA KOMPETENSI</title>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type=”text/css”>
        body {
            font-family: 'DejaVuSans', sans-serif;
            font-size: 13.5px;
            margin: 0;
            margin-top: 120px;
            margin-bottom: 0px;
            border-top: none;
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
        }

        @page {
            size: A4 portrait;
            margin: 22px 22px;
            /* 1 cm dalam piksel */
        }

        header {
            position: fixed;
            top: 0px;
            margin-left: -1px;
            height: 120px;
            text-align: center;
            border-top: 1px solid;
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: none;
        }

        .page-break {
            page-break-before: always;
        }

        main {
            margin-top: 10px;
            margin-left: 20px;
            margin-right: 20px;
            line-height: 1.4;
        }

        .tcustom {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        .tcustom td,
        .tcustom th {
            padding: 0px;
            text-align: left;
            vertical-align: top;
        }

        table {
            margin-bottom: 0px;
        }
    </style>

</head>

<body>
    @php
        $setting = \App\Models\SettingApp::first();
    @endphp
    <header>
        <table class="table" border="0" style="margin-top:15px;margin-left:15px;margin-right:15px;">
            <tr>
                <th width="350px" style="text-align: left; vertical-align: top;">
                    <img src="{{ public_path('storage/uploads/logos/' . ($setting->logo ?? 'default-logo.png')) }}"
                        width="90px" alt="N/A" style="vertical-align: top;">
                </th>
                <th width="357.8px" style="text-align: right; vertical-align: top;">
                    <img src="{{ public_path('storage/uploads/logos/logo-bnsp.png') }}" width="120px" alt="N/A"
                        style="vertical-align: top;">
                </th>
            </tr>

        </table>
    </header>
    <main>
        <div style="font-size: 16px; text-align: center; margin-bottom: 10px;">
            <b>{{ strtoupper('SKEMA KOMPETENSI') }} <br>
                {{ strtoupper($data->scheme->name) }}
            </b>

        </div>
        <table class="table" border="0">
            <tr>
                <td width="80px" style="text-align: left; vertical-align: top;">No. Skema</td>
                <td width="5px" style="text-align: left; vertical-align: top;">:</td>
                <td width="605px" style="text-align: left; vertical-align: top;">{{ $data->scheme->no_scheme }}</td>
            </tr>
            <tr>
                <td style="text-align: left; vertical-align: top;">No. SKKNI</td>
                <td style="text-align: left; vertical-align: top;">:</td>
                <td style="text-align: left; vertical-align: top;">{{ $data->no_skkni }}</td>
            </tr>
        </table>

        <div style="text-align: left; margin-bottom: 8px;margin-top: 8px;">
            <b>Unit Kompetensi</b>
        </div>
        <table class="tcustom">
            <tr style="background-color: #294996; color: white;">
                <th width="1px"
                    style="padding:4px; border: 1px solid black; text-align: center; vertical-align: top;">No.</th>
                <th width="250px" style="padding:4px; border: 1px solid black; text-align: left; vertical-align: top;">
                    Kode Unit
                </th>
                <th width="350px"
                    style="padding:4px; border: 1px solid black; text-align: justify; vertical-align: top;">Unit
                    Kompetensi</th>
            </tr>
            @foreach ($dataKodeUnit as $item)
                <tr>
                    <td style="padding:4px; border: 1px solid black; text-align: center; vertical-align: top;">
                        {{ $loop->iteration }}
                    </td>
                    <td style="padding:4px; border: 1px solid black; text-align: left; vertical-align: top;">
                        {{ $item->kode }}</td>
                    <td style="padding:4px; border: 1px solid black; text-align: left; vertical-align: top;">
                        {{ $item->unit }}</td>
                </tr>
            @endforeach
        </table>
        @foreach ($dataKodeUnit as $item)
            <table class="table" border="0" style="margin-bottom: 5px; margin-top: 5px; page-break-inside: avoid;">
                <tr>
                    <td width="130px" style="text-align: left; vertical-align: top;">Kode Unit</td>
                    <td width="5px" style="text-align: left; vertical-align: top;">:</td>
                    <td width="605px" style="text-align: left; vertical-align: top;">{{ $item->kode }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; vertical-align: top;">Unit Kompetensi</td>
                    <td style="text-align: left; vertical-align: top;">:</td>
                    <td style="text-align: left; vertical-align: top;">{{ $item->unit }}</td>
                </tr>
            </table>

            <table class="tcustom" style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr style="background-color: #294996; color: white;">
                        <th width="45%"
                            style="padding: 4px; border: 1px solid black; text-align: left; vertical-align: top;">
                            Elemen Kompetensi
                        </th>
                        <th width="55%"
                            style="padding: 4px; border: 1px solid black; text-align: justify; vertical-align: top;">
                            Kriteria Unjuk Kerja
                        </th>
                    </tr>
                </thead>

                @php
                    $getElement = \App\Models\CompetenceCodeElement::where('competence_code_id', $item->id)
                        ->orderBy('created_at', 'asc')
                        ->orderBy('number', 'asc')
                        ->get();
                @endphp

                <tbody>
                    @foreach ($getElement as $element)
                        @php
                            $getKuk = \App\Models\CompetenceKuk::where('competence_code_element_id', $element->id)
                                ->orderBy('created_at', 'asc')
                                ->orderBy('number', 'asc')
                                ->get();
                            $number = $loop->iteration;
                        @endphp
                        <tr style="page-break-inside: avoid;">
                            <td
                                style="border: 1px solid black; text-align: justify; vertical-align: top; padding: 4px;">
                                <table border="0" width="100%">
                                    <tr>
                                        <td width="0px" style="text-align: left; vertical-align: top;">
                                            {{ $number }}.
                                        </td>
                                        <td style="text-align: left; vertical-align: top;">
                                            {{ $element->element }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td
                                style="border: 1px solid black; text-align: justify; vertical-align: top; padding: 4px;">
                                <table border="0" width="100%">
                                    @foreach ($getKuk as $kuk)
                                        <tr>
                                            <td width="0px" style="text-align: justify; vertical-align: top;">
                                                {{ $number }}.{{ $loop->iteration }}.
                                            </td>
                                            <td style="text-align: justify; vertical-align: top;margin-right:4px;">
                                                {{ $kuk->kuk }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach

    </main>
</body>
