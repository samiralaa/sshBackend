<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProjectRequest;
class ProjectController extends Controller
{
     protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        return $this->projectService->index();
    }

    public function store(CreateProjectRequest  $request)
    {
        return $this->projectService->store($request);
    }

    public function show($id)
    {
        return $this->projectService->show($id);
    }

    public function update(Request $request, $id)
    {
        return $this->projectService->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->projectService->destroy($id);
    }
}


