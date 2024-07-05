<?php

namespace App\Services\Educations\Repositories;

use App\Models\Education;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentEducationRepository implements EducationRepositoryInterface
{

    public function create(array $data): Model
    {
        return Education::query()->create($data);
    }

    public function get(int $userId): Collection
    {
        return Education::query()->where('user_id','=',$userId)->get();
    }
}
