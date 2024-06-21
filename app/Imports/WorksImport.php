<?php

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WorksImport implements ToModel,WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
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
