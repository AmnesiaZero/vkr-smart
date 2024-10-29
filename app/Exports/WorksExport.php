<?php

namespace App\Exports;

use App\Models\Work;
use App\Services\Works\Repositories\WorkRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorksExport implements FromView
{
    use HasFactory, Exportable;

    protected WorkRepositoryInterface $workRepository;


    public function __construct(array $data)
    {
        $this->data = $data;
        $this->workRepository = app(WorkRepositoryInterface::class);
    }


    public function view(): View
    {
        $works = $this->workRepository->search($this->data);
        return view('exports.works', [
            'works' => $works
        ]);
    }
}
