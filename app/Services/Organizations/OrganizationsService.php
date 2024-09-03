<?php

namespace App\Services\Organizations;

use App\Helpers\JsonHelper;
use App\Models\Organization;
use App\Services\Organizations\Repositories\OrganizationRepositoryInterface;
use App\Services\Services;
use App\Services\Specialties\Repositories\SpecialtyRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrganizationsService extends Services
{
    public OrganizationRepositoryInterface $_repository;

    public SpecialtyRepositoryInterface $specialtyRepository;

    public function __construct(OrganizationRepositoryInterface $organizationRepository, SpecialtyRepositoryInterface $specialtyRepository)
    {
        $this->_repository = $organizationRepository;
        $this->specialtyRepository = $specialtyRepository;
    }

    public function configureInspectorsAccess(int $id, array $specialtiesIds): JsonResponse
    {
        $organization = $this->_repository->find($id);
        try {
            $organization->inspectorsSpecialties()->sync($specialtiesIds);
        }
        catch (QueryException $e) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'При привязке специальностей к проверяющим произошла ошибка'
            ]);
        }
        return self::sendJsonResponse(true, [
            'title' => 'Успешно',
            'message' => 'Проверяющим организации успешно привязаны специальности'
        ]);

    }

    public function find(): JsonResponse
    {
        $user = Auth::user();
        $id = $user->organization_id;
        $organization = $this->_repository->find($id);
        return self::sendJsonResponse(true, [
            'title' => 'Успешно',
            'organization' => $organization,
            'user' => $user
        ]);
    }

    public function integrationView()
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $organization = $this->_repository->find($organizationId);
        return view('templates.dashboard.settings.integration', ['organization' => $organization]);
    }

    public function view()
    {
        $you = Auth::user();
        $organizations = $this->_repository->get();
        return view('templates.dashboard.platform.organization.organizations.index',[
            'user' => $you,
            'organizations' => $organizations
        ]);
    }

    public function get(bool $paginate,int $page): JsonResponse
    {
        $organizations = $this->_repository->get($paginate,$page);
        if($organizations and is_iterable($organizations))
        {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'organizations' => $organizations
            ]);
        }
        return self::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Ошибка при получении организаций'
        ]);
    }

    public function editView(int $id)
    {
        $you = Auth::user();
        $organization = $this->_repository->find($id);
        return view('templates.dashboard.platform.organization.organizations.update',[
            'user' => $you,
            'organization' => $organization
        ]);
    }

    public function update(int $id,array $data)
    {
        $result = $this->_repository->update($id,$data);

    }
}
