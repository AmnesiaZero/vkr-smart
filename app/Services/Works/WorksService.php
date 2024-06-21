<?php

namespace App\Services\Works;

use App\Helpers\FilesHelper;
use App\Helpers\JsonHelper;
use App\Services\OrganizationsYears\Repositories\OrganizationYearRepositoryInterface;
use App\Services\ProgramsSpecialties\Repositories\ProgramSpecialtyRepositoryInterface;
use App\Services\ScientificSupervisors\Repositories\ScientificSupervisorRepositoryInterface;
use App\Services\Specialties\Repositories\SpecialtyRepositoryInterface;
use App\Services\Works\Repositories\WorkRepositoryInterface;
use App\Services\WorksTypes\Repositories\WorksTypeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use WorksImport;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class WorksService
{

    private OrganizationYearRepositoryInterface $yearRepository;

    private WorkRepositoryInterface $workRepository;

    private ProgramSpecialtyRepositoryInterface $programSpecialtyRepository;

    private ScientificSupervisorRepositoryInterface $scientificSupervisorRepository;

    private WorksTypeRepositoryInterface $worksTypeRepository;

    public function __construct(WorkRepositoryInterface $workRepository, OrganizationYearRepositoryInterface $yearRepository,
                                ScientificSupervisorRepositoryInterface $scientificSupervisorRepository, ProgramSpecialtyRepositoryInterface $programSpecialtyRepository,
                                WorksTypeRepositoryInterface $worksTypeRepository)
    {
        $this->workRepository = $workRepository;
        $this->yearRepository = $yearRepository;
        $this->scientificSupervisorRepository = $scientificSupervisorRepository;
        $this->worksTypeRepository = $worksTypeRepository;
        $this->programSpecialtyRepository = $programSpecialtyRepository;

    }

    public function studentsWorksView()
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $years = $this->yearRepository->get($organizationId);
        $works = $this->workRepository->get($organizationId);
        $specialties = $this->specialtyRepository->all();
        return view('templates.dashboard.works.students', ['years' => $years, 'works' => $works, 'specialties' => $specialties]);
    }

    public function get(int $pageNumber): JsonResponse
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $works = $this->workRepository->get($organizationId,$pageNumber);
        return JsonHelper::sendJsonResponse(true, [
            'title' => 'Успешно',
            'works' => $works
        ]);
    }

    public function employeesWorksView()
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $years = $this->yearRepository->get($organizationId);
        $programSpecialties = $this->programSpecialtyRepository->getByOrganization($organizationId);
        $scientificSupervisors = $this->scientificSupervisorRepository->get($organizationId);
        $worksTypes = $this->worksTypeRepository->get($organizationId);
        return view('templates.dashboard.works.employee', [
            'years' => $years,
            'program_specialties' => $programSpecialties,
            'scientific_supervisors' => $scientificSupervisors,
            'works_types' => $worksTypes
        ]);

    }

    public function create( array $data):JsonResponse
    {
        $you = Auth::user();
        $userId = $you->id;
        $organizationId = $you->organization_id;
        $data = array_merge($data,['user_id' => $userId,'organization_id' => $organizationId]);
        $work = $this->workRepository->create($data);
        if($work and $work->id)
        {
            //Вообще,можно в отдельную функцию вынести разбиение по директориям,но лучше не надо
            $workId = $work->id;
            if (isset($data['work_file']) and is_file($data['work_file']) and FilesHelper::acceptableFile($data['work_file']))
            {
                $workFile = $data['work_file'];
                $directoryNumber = ceil($workId/1000);
                $workDirectory = 'works/'.$directoryNumber;
                Storage::makeDirectory($workDirectory);
                $workFileName = $workId.'.'.$workFile->extension();
                $workPath =  $workFile->storeAs($workDirectory,$workFileName);
                $work->path = $workPath;
            }
            else
            {
                return JsonHelper::sendJsonResponse(false,[
                    'title' => 'Ошибка',
                    'message' => 'Был загружен некорректный файл работы. Проверьте его расширение и целостность.Допустимы только файлы формата doc,docx,pdf,pdf и txt'
                ]);
            }
            if(isset($data['certificate_file']))
            {
                if(is_file($data['certificate_file']) and FilesHelper::acceptableFile($data['certificate_file']))
                {
                    $certificateFile = $data['certificate_file'];
                    $certificateFileName = $workId.'.'.$certificateFile->extension();
                    $certificateDirectory = 'certificates/'.$directoryNumber;
                    Storage::makeDirectory($certificateDirectory);
                    $certificatePath = $certificateFile->storeAs($certificateDirectory,$certificateFileName);
                    $work->certificate = $certificatePath;
                }
                else
                {
                    return JsonHelper::sendJsonResponse(false,[
                        'title' => 'Ошибка',
                        'message' => 'Был загружен некорректный файл сертификата. Проверьте его расширение и целостность.Допустимы только файлы формата doc,docx,pdf,pdf и txt'
                    ]);
                }
            }
            $work->save();
            //Подгружаю через find,чтобы связь specialty сохранилась
            $workWithRelations = $this->workRepository->find($workId);
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'work' => $workWithRelations
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
           'title' => 'Ошибка',
           'message' => 'Ошибка при добавлении работы'
        ]);
    }

    public function search(array $data): JsonResponse
    {
        $works = $this->workRepository->search($data);
        if ($works)
        {
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'works' => $works
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Ошибка при поиске работ'
        ]);
    }

    public function update(int $id,array $data): JsonResponse
    {
        $result = $this->workRepository->update($id,$data);
        if($result)
        {
            $work = $this->workRepository->find($id);
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'work' => $work,
                'message' => 'Информация о работе была успешно обновлена'
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при обновлении работы'
        ]);
    }

    public function find(int $id): JsonResponse
    {
        $work = $this->workRepository->find($id);
        if($work and $work->id)
        {
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'work' => $work,
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при получении работы'
        ]);
    }

    public function download(int $id)
    {
        $work = $this->workRepository->find($id);
        if($work and $work->id)
        {
            $path = $work->path;
            if(isset($path) and Storage::exists($path))
            {
                return Storage::download($path);
            }
        }
        return back();
    }

    public function upload(int $id,UploadedFile $workFile): JsonResponse
    {
        $work = $this->workRepository->find($id);
        if($work and $work->id)
        {
            $fileName = $work->id.'.'.$workFile->extension();
            $path = $work->path;
            if(Storage::exists($path))
            {
                if(!Storage::delete($path))
                {
                    return JsonHelper::sendJsonResponse(false,[
                        'title' => 'Ошибка',
                        'message' => 'Возникла ошибка при замене файла'
                    ]);
                }
            }
            if(!isset($workFile) or !is_file($workFile) or !FilesHelper::acceptableFile($workFile))
            {
                return JsonHelper::sendJsonResponse(false,[
                    'title' => 'Ошибка',
                    'message' => 'Был загружен некорректный файл. Проверьте его расширение и целостность'
                ]);
            }
            $directory = 'works/'.ceil($work->id/1000);
            $workFile->storeAs($directory,$fileName);
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'message' => 'Файл успешно изменен'
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при изменении файла'
        ]);
    }

    public function copy(int $id)
    {
        $result = $this->workRepository->copy($id);
        if($result)
        {
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'message' => 'Работа была успешно скопирована'
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
               'title' => 'Ошибка',
                'message' => 'Возникла ошибка при копировании работы'
            ]);
    }

    public function delete(int $id): JsonResponse
    {
        $flag = $this->workRepository->delete($id);
        if($flag)
        {
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'message' => 'Работа успешно помещена на удаление'
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при удалении работы'
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $work = $this->workRepository->find($id);
        $path = $work->path;
        if($work and $work->id)
        {
            $workId = $work->id;
            if(isset($path) and Storage::delete($path))
            {
                $certificate = $work->certificate;
                if(isset($certificate) and Storage::exists($certificate))
                {
                    if(!Storage::delete($certificate))
                    {
                        return JsonHelper::sendJsonResponse(false,[
                            'title' => 'Ошибка',
                            'message' => 'Возникла ошибка при удалении сертификата'
                        ]);
                    }
                }
                $additionalFilesPath = 'additional_files/'.$workId;
                if (Storage::exists($additionalFilesPath))
                {
                    if(!Storage::deleteDirectory($additionalFilesPath))
                    {
                        return JsonHelper::sendJsonResponse(false,[
                            'title' => 'Ошибка',
                            'message' => 'Возникла ошибка при удалении дополнительных файлов'
                        ]);
                    }
                }
                $flag = $this->workRepository->destroy($id);
                if ($flag)
                {
                    return JsonHelper::sendJsonResponse(true,[
                        'title' => 'Успешно',
                        'message' => 'Работа и файлы были успешно удалены'
                    ]);
                }
            }
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при удалении файла работы'
        ]);
    }

    public function updateSelfCheckStatus(int $id): JsonResponse
    {
        $work = $this->workRepository->find($id);
        if($work and $work->id)
        {
            $manual = $work->self_check;
            if($manual)
            {
                $work->self_check = 0;
            }
            else
            {
                $work->self_check = 1;
            }
            $work->save();
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'message' => 'Статус самопроверки успешно обновлен',
                'self_check' => $work->self_check
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при обновлении статуса самопроверки'
        ]);
    }

    public function restore(int $id)
    {
        $work = $this->workRepository->find($id);
        if ($work and $work->id)
        {
            Log::debug('id = '.$id);
            $result = $this->workRepository->restore($id);
            if($result)
            {
                return JsonHelper::sendJsonResponse(true,[
                    'title' => 'Успешно',
                    'message' => 'Работа была успешно восстановлена'
                ]);
            }
            return JsonHelper::sendJsonResponse(false,[
                'title' => 'Ошибка',
                'message' => 'Возникла ошибка при восстановлении работы'
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при поиске работы'
        ]);
    }

    public function uploadCertificate(int $id, UploadedFile $certificate): JsonResponse
    {
        $work = $this->workRepository->find($id);
        if($work and $work->id)
        {
            $fileName = $work->id.'.'.$certificate->extension();
            $certificatePath = $work->certificate;
            if(isset($certificatePath) and Storage::exists($certificatePath))
            {
                Storage::delete($certificatePath);
                $directory = 'certificates/' . ceil($work->id / 1000);
                $certificate->storeAs($directory, $fileName);
                return JsonHelper::sendJsonResponse(true, [
                    'title' => 'Успешно',
                    'message' => 'Файл сертификата успешно изменен'
                ]);
            }
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при изменении файла сертификата'
        ]);
    }

    public function downloadCertificate(int $id)
    {
        $work = $this->workRepository->find($id);
        if($work and $work->id)
        {
            $certificatePath = $work->certificate;
            if(isset($certificatePath) and Storage::exists($certificatePath))
            {
                return Storage::download($certificatePath);
            }
        }
        return back();
    }

    public function import(array $data): JsonResponse
    {
        if(isset($data['import_file']) and is_file($data['import_file']) and FilesHelper::acceptableImport($data['import_file']))
        {
            $importFile = $data['import_file'];
            try{
                $imports = Excel::toCollection(new WorksImport(), $importFile);
            }
            catch (ValidationException  $e)
            {
                return JsonHelper::sendJsonResponse(false,[
                    'title' => 'Ошибка',
                    'message' => 'Возникла ошибка при обработке импорта'
                ]);
            }
            $you = Auth::user();
            $userId = $you->id;
            $organizationId = $you->organization_id;
            $data = array_merge($data,['organization_id' => $organizationId,'user_id' => $userId]);
            $works = [];
            foreach ($imports as $import)
            {
                $workData = array_merge($data,$import);
                $work = $this->workRepository->create($workData);
                if(!isset($work) or !isset($work->id))
                {
                    return JsonHelper::sendJsonResponse(false,[
                        'title' => 'Ошибка',
                        'message' => 'Возникла ошибка при импорте работы'
                    ]);
                }
                $works[] = $work;
            }
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'message' => 'Работы были успешно импортированы',
                'works' => $works
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Файл импорта некорректный. Проверьте целостность и расширение файла'
        ]);
    }

}
