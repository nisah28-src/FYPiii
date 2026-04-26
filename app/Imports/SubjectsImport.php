<?php

namespace App\Imports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubjectsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Subject([
        'subject_name' => $row['subject_name'],
        'subject_code' => $row['subject_code'],
        'credit_hours' => $row['credit_hours'],
        'category_type' => $row['category_type'],
        'pre_requisite_id' => $row['pre_requisite_id'] ?? null,
        ]);
    }
}
