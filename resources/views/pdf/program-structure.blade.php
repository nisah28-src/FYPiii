<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; table-layout: fixed; }
        
        /* Header Table */
        th { 
            background-color: #2D3748; 
            color: white; 
            padding: 8px; 
            border: 1px solid #1a202c;
            text-transform: uppercase;
            font-size: 10px;
        }

        td { padding: 8px; border: 1px solid #CBD5E0; vertical-align: middle; }

        /* Trik Vertical Semester */
        .vertical-td {
            background-color: #EDF2F7;
            width: 30px;
            text-align: center;
        }

        .vertical-text {
            /* DomPDF perlukan display: block atau inline-block untuk transform */
            display: block;
            transform: rotate(-90deg);
            white-space: nowrap;
            font-weight: bold;
            color: #2B6CB0;
            width: 20px; /* Kecilkan width supaya dia tak tolak column lain */
            margin: 0 auto;
        }

        /* Warna Kategori */
        .cat-badge {
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }

        .header-section { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4A5568; padding-bottom: 10px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; color: #718096; }
        
        .badge-pre {
            display: inline-block;
            background: #f1f5f9;
            padding: 2px 4px;
            border: 1px solid #e2e8f0;
            border-radius: 3px;
            font-size: 9px;
            margin-bottom: 2px;
        }
    </style>
</head>
<body>

    <div class="header-section">
        <h1 style="margin: 0; color: #2D3748; font-size: 18px;">{{ $title }}</h1>
        <p style="margin: 5px 0;">Generated on: {{ $date }} | Status: <strong>{{ strtoupper($structure->status) }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="35px">Sem</th>
                <th width="80px">Code</th>
                <th>Course Name</th>
                <th width="45px">Credits</th>
                <th width="120px">Prerequisite</th>
                <th width="100px">Category</th>
            </tr>
        </thead>
        <tbody>
            @foreach($structure->programSubjects->groupBy('semester_number') as $semNum => $subs)
                @foreach($subs as $index => $pSub)
                <tr>
                    {{-- Column Semester Vertical - Hanya keluar pada row pertama setiap group --}}
                    @if($index === 0)
                        <td rowspan="{{ $subs->count() }}" class="vertical-td">
                            <div class="vertical-text">SEM {{ $semNum }}</div>
                        </td>
                    @endif

                    <td style="font-weight: bold; text-align: center;">{{ $pSub->subject->subject_code }}</td>
                    <td>{{ $pSub->subject->subject_name }}</td>
                    <td style="text-align: center;">{{ $pSub->subject->credit_hours }}</td>
                    <td>
                        @forelse($pSub->subject->prerequisites as $pre)
                            <span class="badge-pre">{{ $pre->subject_name }}</span>
                        @empty
                            <span style="color: #A0AEC0;">None</span>
                        @endforelse
                    </td>
                   
                        @php
                            // Ambil data category
                                $categoryObj = $pSub->subject->category_type;
                                
                                // Check kalau dia Enum, ambil value. Kalau string biasa, guna terus.
                                $rawType = ($categoryObj instanceof \UnitEnum) ? $categoryObj->value : (string)$categoryObj;
                                
                                $type = strtolower(trim($rawType));

                                $color = match($type) {
                                    'core', 'wajib' => '#E53E3E', 
                                    'elective', 'elektif' => '#38A169', 
                                    'mqa', 'mpu' => '#805AD5', 
                                    'university', 'universiti' => '#3182CE', 
                                    default => '#718096' 
                                };
                        @endphp
                        <td style="text-align: center;">
    <span class="cat-badge" style="background-color: {{ $color }};">
        {{ $rawType ?: 'N/A' }}
    </span>
</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Program Structure Management System | Generated by AI
    </div>

</body>
</html>