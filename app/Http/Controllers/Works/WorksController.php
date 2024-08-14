<?php

namespace App\Http\Controllers\Works;

use App\Helpers\ValidatorHelper;
use App\Http\Controllers\Controller;
use App\Services\Works\WorksService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class WorksController extends Controller
{

    protected array $fillable = [
        'user_id',
       'year_id',
        'faculty_id',
        'department_id',
        'specialty_id',
        'student',
        'group',
        'name',
        'scientific_supervisor',
        'work_type',
        'protect_date',
        'daterange',
        'assessment',
        'agreement',
        'work_file',
        'self_check',
        'certificate_file',
        'selected_faculties',
        'selected_years',
        'selected_specialties',
        'verification_method',
        'delete_type',
        'import_file',
        'date_range',
        'user_type',
        'page',
        'selected_departments',
        'work_status',
        'user_id'
    ];

    protected WorksService $worksService;


    public function __construct(WorksService $worksService)
    {
        $this->worksService = $worksService;
    }

    public function studentsWorksView()
    {
        return $this->worksService->studentsWorksView();
    }

    public function employeesWorksView()
    {
        return $this->worksService->employeesWorksView();
    }

    public function youWorksView()
    {
        return $this->worksService->youWorksView();
    }



    public function get(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'page' => 'required|integer',
            'user_type' => 'required|integer|in:1,2',
            'selected_departments.*' => ['integer',Rule::exists('departments','id')],
            'user_id' => ['integer',Rule::exists('users','id')],
            'selected_specialties.*' => ['integer',Rule::exists('programs_specialties','id')],
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->worksService->get($data);
    }

    public function getUserWorks(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'page' => 'required|integer',
            'user_id' =>  ['required','integer',Rule::exists('users','id')]
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $pageNumber = $request->page;
        $userId = $request->user_id;
        return $this->worksService->getUserWorks($userId,$pageNumber);
    }

    public function create(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'user_type' => 'required|integer|in:1,2',
            'year_id' => ['integer','required',Rule::exists('organizations_years','id')],
            'faculty_id' => ['integer','required',Rule::exists('faculties','id')],
            'department_id' => ['integer',Rule::exists('departments','id')],
            'specialty_id' => ['integer',Rule::exists('programs_specialties','id')],
            'student' => 'max:250',
            'group' => 'required|max:250',
            'verification_method' => 'required|integer|in:0,1,2',
            'scientific_supervisor' => 'max:250',
            'work_type' => 'required|max:250',
            'protect_date' => 'required|date',
            'assessment' => 'required|integer|min:0|max:5',
            'agreement' => 'integer:in:1',
            'work_file' => 'required|file',
            'self_check' => 'integer:in:1',
            'certificate_file' => 'file'
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->worksService->create($data);
    }

    public function import(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'year_id' => ['integer','required',Rule::exists('organizations_years','id')],
            'faculty_id' => ['integer','required',Rule::exists('faculties','id')],
            'department_id' => ['integer','required',Rule::exists('departments','id')],
            'specialty_id' => ['integer','required',Rule::exists('programs_specialties','id')],
            'verification_method' => 'required|integer|in:0,1,2',
            'import_file' => 'required|file'
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->worksService->import($data);
    }

    public function search(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'user_type' => 'required|integer|in:1,2',
            'specialty_id' => ['integer',Rule::exists('programs_specialties','id')],
            'delete_type' => 'integer|in:0,1,2',
            'student' => 'max:250',
            'group' => 'max:250',
            'scientific_supervisor' => 'max:250',
            'protect_date' => 'max:250',
            'work_type' => 'max:250',
            'name' => 'max:250',
            'selected_faculties.*' => ['integer', Rule::exists('faculties', 'id')],
            'selected_years.*' => ['integer', Rule::exists('organizations_years', 'id')],
            'selected_departments.*' => ['integer',Rule::exists('departments','id')],
            'selected_specialties.*' => ['integer',Rule::exists('programs_specialties','id')],
            'user_id' => ['integer', Rule::exists('users', 'id')]
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->worksService->search($data);
    }

    public function delete(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required','integer'],
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->worksService->delete($id);
    }

    public function destroy(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required','integer'],
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->worksService->destroy($id);
    }

    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required','integer'],
            'specialty_id' => ['integer',Rule::exists('programs_specialties','id')],
            'student' => 'max:250',
            'group' => 'max:250',
            'scientific_supervisor' => 'max:250',
            'work_type' => 'max:250',
            'protect_date' => 'date',
            'assessment' => 'integer|min:0|max:5',
            'agreement' => 'integer:in:1',
            'work_file' => 'file',
            'self_check' => 'integer:in:1',
            'certificate_file' => 'file',
            'work_status' => 'integer|in:0,1,2'
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        Log::debug('id = '.$id);
        $data = $request->only($this->fillable);
        return $this->worksService->update($id,$data);
    }

    public function find(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required','integer'],
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->worksService->find($id);
    }

    public function download(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required','integer',Rule::exists('works','id')],
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->worksService->download($id);
    }

    public function downloadCertificate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required','integer',Rule::exists('works','id')],
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->worksService->downloadCertificate($id);
    }

    public function upload(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required','integer'],
            'work_file' => 'required|file'
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        $workFile = $request->work_file;
        return $this->worksService->upload($id,$workFile);
    }

    public function uploadCertificate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required','integer'],
            'certificate_file' => 'required|file'
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        $certificate = $request->file('certificate_file');
        return $this->worksService->uploadCertificate($id,$certificate);
    }

    public function copy(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required','integer']
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->worksService->copy($id);
    }

    public function updateSelfCheckStatus(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required','integer']
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->worksService->updateSelfCheckStatus($id);
    }

    public function updateVisibility(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required','integer']
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->worksService->updateVisibility($id);
    }

    public function restore(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required','integer']
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->worksService->restore($id);
    }

    public function export(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'specialty_id' => ['integer',Rule::exists('programs_specialties','id')],
            'delete_type' => 'integer|in:0,1,2',
            'student' => 'max:250',
            'group' => 'max:250',
            'scientific_supervisor' => 'max:250',
            'protect_date' => 'max:250',
            'work_type' => 'max:250',
            'name' => 'max:250',
            'selected_faculties.*' => ['integer', Rule::exists('faculties', 'id')],
            'selected_years.*' => ['integer', Rule::exists('organizations_years', 'id')],
            'selected_departments.*' => ['integer',Rule::exists('departments','id')],
            'selected_specialties.*' => ['integer',Rule::exists('programs_specialties','id')],
        ]);
        if ($validator->fails())
        {
            return ValidatorHelper::redirectError($validator);
        }
        $data = $request->only($this->fillable);
        return $this->worksService->export($data);
    }


    public function getReport(Request $request): JsonResponse
    {
        Log::debug('Вошёл в getReport');
        $validator = Validator::make($request->all(),[
            'document_id' => 'required|integer'
        ]);
        if($validator->fails())
        {
            return ValidatorHelper::error($validator);
        }
        $documentId = $request->document_id;
        return $this->worksService->getReport($documentId);
    }


}
