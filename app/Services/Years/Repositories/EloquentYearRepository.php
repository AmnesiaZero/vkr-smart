<?php

namespace App\Services\Years\Repositories;

use App\Models\Year;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentYearRepository implements YearRepositoryInterface
{

    public function create(array $data): Model
    {
        return Year::query()->create($data);
    }

    public function update(int $id, array $data): int
    {
        return Year::query()->where('id', '=', $id)->update($data);
    }

    public function getByYearNumber(int $year, int $userId): Model
    {
        return Year::query()->where('user_id', '=', $userId)->first();
    }

    public function delete(int $id): bool
    {
        return Year::query()->find($id)->delete();
    }

    public function find($id): Model
    {
        return Year::query()->find($id);
    }

    public function copy(int $id): Model
    {
        return Year::query()->where('id', '=', $id)->first()->duplicate();
    }

    public function findWithInfo(int $id): Model
    {
        return Year::with('faculties.departments.programs.programSpecialties')->find($id);
    }

    public function all(int $organizationId): Collection
    {
        return Year::query()->where('organization_id', '=', $organizationId)
            ->with('departments.programs.programSpecialties')->get();

    }

    public function specialties(int $id): Collection
    {
        return $this->find($id)
            ->departments()
            ->with([
                'programs' => function ($query) {
                    // Загрузка специальностей с их департаментами и факультетами
                    $query->with([
                        'programSpecialties',
                        'department.faculty'
                    ]);
                }
            ])
            ->get()
            ->map(function ($department) {
                return $department->programs->map(function ($program) {
                    return $program->programSpecialties->map(function ($specialty) use ($program) {
                        return [
                            'specialty' => $specialty,
                            'department' => $program->department->name,
                            'faculty' => $program->department->faculty->name,
                            'year' => $program->year,
                        ];
                    });
                });
            })
            ->flatten(2); // Уровень flatten зависит от глубины вложенности коллекции
    }

    public function get(int $organizationId): Collection
    {
        return Year::with('departments')->where('organization_id', '=', $organizationId)->get();
    }
}
