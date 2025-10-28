<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class Controller
{
    protected string $model;

    protected string $pagePath;

    protected string $routeAs;

    protected array $filterable;

    abstract protected function getListingQuery();

    abstract protected function getModelQuery(): Builder;

    abstract protected function save(Request $request, ?int $id = null): Model;

    protected function apiHandler(Closure $apiHandler): JsonResponse
    {
        try {
            return $apiHandler();
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function index(Request $request): JsonResponse
    {
        return $this->apiHandler(function () use ($request): JsonResponse {
            $query = $this->getListingQuery();

            foreach ($this->filterable as $column) {
                if ($request->filled($column)) {
                    $value = $request->get($column);

                    $query->when(is_string($value), fn($q) => $q->where($column, 'like', "%{$value}%"));
                    $query->when(!is_string($value), fn($q) => $q->where($column, $value));
                }
            }

            return response()->json($query->get());
        });
    }

    public function show(int $id): JsonResponse
    {
        return $this->apiHandler(function () use ($id): JsonResponse {
            return response()->json($this->getModelQuery()->findOrFail($id));
        });
    }

    public function store(Request $request): JsonResponse
    {
        return $this->apiHandler(function () use ($request): JsonResponse {
            $model = $this->save($request);

            return response()->json($model);
        });
    }

    public function update(Request $request, $id): JsonResponse
    {
        return $this->apiHandler(function () use ($request, $id): JsonResponse {
            $model = $this->save($request, $id);

            return response()->json($model);
        });
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->apiHandler(function () use ($id): JsonResponse {
            $this->model::findOrFail($id)->delete();

            return response()->json(data: ['message' => 'Deleted item']);
        });
    }
}
