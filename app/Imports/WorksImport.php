<?php

namespace App\Imports;


use App\Models\User;
use App\Models\Work;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class WorksImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Work
     */
    public function model(array $row)
    {
        return new Work([
            'student'     => $row[0],
            'group'    => $row[1],
            'name' => $row[2],
            'scientific_supervisor' => $row[3],
            'work_type' => $row[4],
            'assessment' => $row[5],
        ]);
    }

    /**
     * @param array $row
     *
     * @return Work|null
     */
    public function collection(Collection $rows):void
    {
        foreach ($rows as $row) {
            Work::create([
                'student'              => $row[0],
                'group'                => $row[1],
                'name'                 => $row[2],
                'scientific_supervisor'=> $row[3],
                'work_type'            => $row[4],
                'assessment'           => $row[5],
            ]);
        }
    }

}
