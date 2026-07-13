<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::query()->with(['student', 'vacancy']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return ApplicationResource::collection(
            $query->orderByDesc('id')->paginate(10)
        );
    }

    public function show(Application $application)
    {
        $application->load(['student', 'vacancy']);

        return new ApplicationResource($application);
    }
}
