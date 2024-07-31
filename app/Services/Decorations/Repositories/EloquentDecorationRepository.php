<?php

namespace App\Services\Decorations\Repositories;

use App\Models\Decoration;
use Illuminate\Database\Eloquent\Model;

class EloquentDecorationRepository implements DecorationRepositoryInterface
{

    public function get(int $organizationId): Model
    {
        return Decoration::query()->where('organization_id','=',$organizationId)->first();
    }

    public function create(array $data): Model
    {
        return Decoration::query()->create($data);
    }
}
