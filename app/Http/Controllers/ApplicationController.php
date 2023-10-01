<?php

namespace App\Http\Controllers;

use App\Enum\Status;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ApplicationResource;
use App\Http\Requests\Application\StoreRequest;
use App\Http\Requests\Application\UpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApplicationController extends Controller
{
    /**
     * user может создавать и просматривать свои заявки
     * manager может просматривать и изменять все заявки 
     */
    public function __construct()
    {
        $this->middleware('role:user')->only('index', 'show', 'store');
        $this->middleware('role:manager')->only('all', 'update');
    }
    //метод для просмотра всех заявок
    public function all(): AnonymousResourceCollection|JsonResponse
    {
        $applications = Application::query()->get();
        
        if ($applications->isEmpty()) {
            return response()->json([
                'message' => 'Заявок нет',
            ]);
        }

        return ApplicationResource::collection($applications);
    }
    /**
     * метод для просмотра своих заявок
     */
    public function index(): AnonymousResourceCollection|JsonResponse
    {
        $id = Auth::user()->id;
        
        $applications = Application::query()->where('user', $id)->get();

        if ($applications->isEmpty()) {
            return response()->json([
                'message' => 'У вас нет заявок',
            ]);
        }

        return ApplicationResource::collection($applications);
    }

    /**
     * метод для создания новой заявки
     */
    public function store(StoreRequest $request): ApplicationResource|JsonResponse
    {
        $validated = $request->validated();
        $validated['user'] = Auth::user()->id;
        $validated['status'] = Status::NEW->value;

        $application = Application::query()->create($validated);

        if (! $application) {
            return response()->json([
                'message' => 'Произошла ошибка при создании заявки!',
            ], 500);
        }

        return new ApplicationResource($application);
    }

    /**
     * показать конкретную заявку
     */
    public function show(Application $application): ApplicationResource
    {
        return new ApplicationResource($application);
    }

    /**
     * метод для изменения заявок
     */
    public function update(UpdateRequest $request, Application $application): ApplicationResource|JsonResponse
    {
        //проверяем что при изменении статуса - был добавлен комментарий
        if ($request->has('status') && ! $request->has('comment')) {
            return response()->json([
                'message' => 'При изменении статуса - поле комментария обязателено для заполнения!',
            ], 400);
        }

        $validated = $request->safe()->only(['status', 'comment']);

        $application->update($validated);

        return new ApplicationResource($application);
    }
}
