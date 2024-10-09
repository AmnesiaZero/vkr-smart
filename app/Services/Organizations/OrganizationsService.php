<?php

namespace App\Services\Organizations;

use App\Helpers\FilesHelper;
use App\Helpers\JsonHelper;
use App\Models\Organization;
use App\Services\Organizations\Repositories\OrganizationRepositoryInterface;
use App\Services\Services;
use App\Services\Specialties\Repositories\SpecialtyRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
            'you' => $user
        ]);
    }

    public function integrationView()
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $organization = $this->_repository->find($organizationId);
        return view('templates.dashboard.settings.integration', ['organization' => $organization]);
    }

    public function view(array $data)
    {
        $you = Auth::user();
        $additionalData = [
            'with_trashed' => true,
            'paginate' => true,
        ];
        $data = array_merge($data,$additionalData);
        if(!isset($data['page']))
        {
            $data['page'] = 1;
        }
        $organizations = $this->_repository->get($data);
        if($organizations)
        {
            return view('templates.dashboard.platform.organization.organizations.index',[

                'organizations' => $organizations
            ]);
        }
        return back()->withErrors(['Ошибка при получении организаций']);
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
        $parents = $this->_repository->parents($id);
        return view('templates.dashboard.platform.organization.organizations.update',[

            'organization' => $organization,
            'parents' => $parents
        ]);
    }

    public function update(int $id,array $data)
    {
//        dd(is_file($data['logo']));
        if(isset($data['logo']))
        {
            if(is_file($data['logo']) and FilesHelper::acceptableImage($data['logo']))
            {
                $logoFile = $data['logo'];
                $directoryNumber = ceil($id/1000);
                $logoDirectory = 'logos/'.$directoryNumber;
                Storage::makeDirectory($logoDirectory);
                $logoFileName = $id.'.'.$logoFile->extension();
                $logoFile->storeAs($logoDirectory,$logoFileName);
                $data['logo_path'] = $logoFileName;
                $data['logo_file_name'] = $logoFile->getClientOriginalName();
            }
            else
            {
                return back()->withErrors(['Некорректный файл логотипа. Проверьте расширение файла. Допустимые расширения : jpeg,png,webp,jpg']);
            }
        }
        $result = $this->_repository->update($id,$data);
        if($result)
        {
            $you = Auth::user();
            if(isset($data['redirect']))
            {
                return redirect('/dashboard/platform/organizations');
            }
            $organization = $this->_repository->find($id);
            return view('templates.dashboard.platform.organization.organizations.update',[
                'organization' => $organization,
                'you' => $you
            ]);
        }
        return back()->withErrors(['Ошибка при обновлении организации']);
    }

    public function addView()
    {
        $you = Auth::user();
        return view('templates.dashboard.platform.organization.organizations.create',[

        ]);
    }

    public function create(array $data)
    {
        $organization = $this->_repository->create($data);
        if($organization and $organization->id)
        {
            $updatedData = [];
            $id = $organization->id;
            if(isset($data['logo']))
            {
                if(is_file($data['logo']) and FilesHelper::acceptableImage($data['logo']))
                {
                    $logoFile = $data['logo'];
                    $directoryNumber = ceil($id/1000);
                    $logoDirectory = 'logos/'.$directoryNumber;
                    Storage::makeDirectory($logoDirectory);
                    $logoFileName = $id.'.'.$logoFile->extension();
                    $logoPath =  $logoFile->storeAs($logoDirectory,$logoFileName);
                    $updatedData['logo_path'] = $logoPath;
                    $updatedData['logo_file_name'] = $logoFile->getClientOriginalName();
                }
                else
                {
                    return back()->withErrors(['Некорректный файл логотипа. Проверьте расширение файла. Допустимые расширения : jpeg,png,webp,jpg']);
                }
            }
            $result = $this->_repository->update($id,$updatedData);
            if($result)
            {
                $updatedOrganization = $this->_repository->find($id);
                $you = Auth::user();
                if(isset($data['redirect']))
                {
                    return redirect('/dashboard/platform/organizations');
                }
                return view('templates.dashboard.platform.organization.organizations.create',[
                    'organization' => $updatedOrganization,
                    'you' => $you
                ]);
            }
        }
        return back()->withErrors(['Ошибка при создании организации']);
    }


    public function updatePremium(int $id): JsonResponse
    {
        $organization = $this->_repository->find($id);
        if($organization and $organization->id)
        {
            $isPremium = $organization->is_premium;
            if($isPremium==0)
            {
                $organization->is_premium = 1;
            }
            else
            {
                $organization->is_premium = 0;
            }
            $organization->save();
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'organization'=> $organization
            ]);
        }
        return self::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при обновлении статуса организации'
        ]);
    }

    public function updateBasic(int $id): JsonResponse
    {
        $organization = $this->_repository->find($id);
        Log::debug('organization = '.print_r($organization,true));
        if($organization and $organization->id)
        {
            $isBasic = $organization->is_basic;
            if($isBasic==0)
            {
                $organization->is_basic = 1;
            }
            else
            {
                $organization->is_basic = 0;
            }
            $organization->save();
            Log::debug('updated organization = '.print_r($organization,true));
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'organization'=> $organization
            ]);
        }
        return self::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при обновлении статуса организации'
        ]);
    }

    public function updateStatus(int $id): JsonResponse
    {
        $organization = $this->_repository->find($id);
        if($organization and $organization->id)
        {
            $isBlocked = $organization->is_blocked;
            if($isBlocked==0)
            {
                $organization->is_blocked = 1;
            }
            else
            {
                $organization->is_blocked = 0;
            }
            $organization->save();
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'organization'=> $organization
            ]);
        }
        return self::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при обновлении статуса организации'
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $result = $this->_repository->delete($id);
        if ($result)
        {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'message' => 'Данный элемент был успешно удален'
            ]);
        }
        else
        {
            return self::sendJsonResponse(false,[
                'title' => 'Ошибка',
                'message' => 'Возникла ошибка при удалении организации из базы данных'
            ]);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        $result = $this->_repository->destroy($id);
        if ($result)
        {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'message' => 'Данный элемент был успешно удален'
            ]);
        }
        else
        {
            return self::sendJsonResponse(false,[
                'title' => 'Ошибка',
                'message' => 'Возникла ошибка при удалении организации из базы данных'
            ]);
        }
    }

    public function restore(int $id): JsonResponse
    {
        $result = $this->_repository->restore($id);
        if ($result)
        {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'message' => 'Данный элемент был успешно восстановлен'
            ]);
        }
        else
        {
            return self::sendJsonResponse(false,[
                'title' => 'Ошибка',
                'message' => 'Возникла ошибка при восстановлении'
            ]);
        }
    }
}
