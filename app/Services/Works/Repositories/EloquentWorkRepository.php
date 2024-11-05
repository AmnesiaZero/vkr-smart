<?php

namespace App\Services\Works\Repositories;

use App\Models\StudentWork;
use App\Models\Work;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class EloquentWorkRepository implements WorkRepositoryInterface
{

    public function get(int $organizationId): Collection
    {
        return Work::query()->where('organization_id', '=', $organizationId)->get();
    }

    public function getPaginate(array $data): LengthAwarePaginator
    {
        $query = Work::withTrashed()->with(['faculty', 'specialty']);
        if (isset($data['user_id'])) {
            $query = $query->where('user_id', '=', $data['user_id']);
        } else {
            $query = $query->where('organization_id', '=', $data['organization_id'])->where('user_type', '=', $data['user_type']);
        }
        if (isset($data['visibility']))
        {
            $query = $query->where('visibility','=',$data['visibility']);
        }
        if (isset($data['selected_departments'])) {
            $departmentsIds = $data['selected_departments'];
            $query = $query->whereIn('department_id', $departmentsIds);
        }
        if (isset($data['selected_specialties'])) {
            $specialtiesIds = $data['selected_specialties'];
            $query = $query->whereIn('specialty_id', $specialtiesIds);
        }
        return $query->paginate(config('pagination.per_page'), '*', 'page', $data['page']);
    }

    public function create(array $data): Model
    {
        return Work::query()->create($data);
    }

    public function search(array $data): LengthAwarePaginator|Collection
    {
        $query = Work::query();
        if (isset($data['delete_type'])) {
            $deleteType = $data['delete_type'];
            if ($deleteType == 1) {
                $query = Work::withTrashed()->where('deleted_at', '!=', null);
            } elseif ($deleteType == 2) {
                $query = Work::withTrashed();
            }
        }
        $query->with(['specialty', 'faculty', 'department']);

        if (isset($data['visibility']))
        {
            $query = $query->where('visibility','=',$data['visibility']);
        }

        if(isset($data['file_uploaded']))
        {
            if($data['file_uploaded'])
            {
                 $query = $query->where('path','!=',null);
            }
            else
            {
                $query = $query->where('path','=',null);
            }
        }

        if (isset($data['user_id'])) {
            $query = $query->where('user_id', '=', $data['user_id']);
        }
        if (isset($data['user_type'])) {
            $query = $query->where('user_type', '=', $data['user_type']);
        }
        if (isset($data['scientific_supervisor'])) {
            $query->where('scientific_supervisor', 'like', '%' . $data['scientific_supervisor']);
        }
        if (isset($data['student'])) {
            $query = $query->where('student', 'like', '%' . $data['student'] . '%');
        }
        if (isset($data['group'])) {
            $query = $query->where('group', 'like', '%' . $data['group'] . '%');
        }
        if (isset($data['work_type'])) {
            $query = $query->where('work_type', 'like', '%' . $data['work_type'] . '%');
        }
        if (isset($data['name'])) {
            $query = $query->where('name', 'like', '%' . $data['name'] . '%');
        }
        if (isset($data['specialty_id'])) {
            $query = $query->where('specialty_id', '=', $data['specialty_id']);
        }
        if (isset($data['start_date']) and isset($data['end_date'])) {
            $query = $query->whereBetween('created_at', [$data['start_date'], $data['end_date']]);
        }
        if (isset($data['selected_faculties']) and count($data['selected_faculties']) > 0) {
            $facultiesIds = $data['selected_faculties'];
            $query = $query->whereIn('faculty_id', $facultiesIds);
        }
        if (isset($data['selected_years']) and count($data['selected_years']) > 0) {
            $yearsIds = $data['selected_years'];
            $query = $query->whereIn('year_id', $yearsIds);
        }
        if (isset($data['selected_departments'])) {
            $departmentsIds = $data['selected_departments'];
            $query = $query->whereIn('department_id', $departmentsIds);
        }
        if (isset($data['selected_specialties'])) {
            $specialtiesIds = $data['selected_specialties'];
            $query = $query->whereIn('specialty_id', $specialtiesIds);
        }
        if (isset($data['paginate']) and $data['paginate'])
        {
            return $query->paginate(config('pagination.per_page'), '*', 'page', $data['page']);
        }
        return $query->get();
    }

    public function copy(int $id)
    {
        return Work::query()->where('id', '=', $id)->first()->duplicate();
    }

    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }

    public function find(int $id): Model
    {
        return Work::withTrashed()->with(['specialty', 'year', 'faculty', 'department', 'user', 'report_assets'])->find($id);
    }

    public function destroy(int $id): bool
    {
        return $this->find($id)->forceDelete();
    }

    public function restore(int $id)
    {
        return Work::withTrashed()->where('id', '=', $id)->first()->restore();
    }

    public function updateReportStatus(int $reportId, array $data)
    {
        return Work::query()->where('report_id', '=', $reportId)->first()->update($data);
    }



    public function update(int $id, array $data)
    {
        return $this->find($id)->update($data);
    }

    public function findByReportId(int $reportId): Model
    {
        return Work::query()->where('report_id', '=', $reportId)->first();
    }

    public function getUserWorks(int $userId, int $pageNumber): LengthAwarePaginator
    {
        return Work::withTrashed()->with(['faculty', 'specialty'])->where('user_id', '=', $userId)->paginate(config('pagination.per_page'), '*', 'page', $pageNumber);
    }

    public function exist(int $workId): bool
    {
        return Work::query()->find($workId)->exists();
    }
}
