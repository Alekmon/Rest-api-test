<?php

namespace App\Http\Controllers;

use App\Enum\Status;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ApplicationResource;
use App\Http\Requests\Application\StoreRequest;
use App\Http\Requests\Application\UpdateRequest;

class ApplicationController extends Controller
{

    public function all()
    {
        $applications = Application::query()->paginate(10);

        if (! $applications) {
            return response()->json([
                'message' => 'Заявок нет',
            ]);
        }

        return ApplicationResource::collection($applications);
    }
    /**
     * Display unique user applicatons.
     */
    public function index()
    {
        $id = Auth::user()->id;
        
        $applications = Application::where('user', $id)->get();

        if (! $applications) {
            return response()->json([
                'message' => 'У вас нет заявок',
            ]);
        }

        return ApplicationResource::collection($applications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['user'] = Auth::user()->id;
        $validated['status'] = Status::NEW->value;

        $application = Application::query()->create($validated);

        if (! $application) {
            return response()->json([
                'message' => 'Произошла ошибка при создании заявки!',
            ]);
        }

        return new ApplicationResource($application);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        return new ApplicationResource($application);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Application $application)
    {
        $validated = $request->validated();

        $application->update($validated);

        return new ApplicationResource($application);
    }
}
