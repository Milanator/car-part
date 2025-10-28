<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\{JsonResponse, Request};

abstract class Controller
{
    protected string $model;
    protected array $filterable;
    protected string $formRequest;

    abstract protected function getListingQuery();

    abstract protected function getModelQuery(): Builder;

    abstract protected function save(array $data, ?int $id = null): Model;

    protected function validateData(Request $request): array
    {
        return validator($request->all(), (new $this->formRequest)->rules())->validate();
    }

    protected function apiHandler(Closure $apiHandler): JsonResponse
    {
        try {
            return response()->json($apiHandler());
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function index(Request $request): JsonResponse
    {
        return $this->apiHandler(function () use ($request) {
            $query = $this->getListingQuery();

            // filter criteria
            foreach ($this->filterable as $column) {
                if ($request->filled($column)) {
                    $value = $request->get($column);

                    $query->when(is_string($value), fn($q) => $q->where($column, 'like', "%{$value}%"));
                    $query->when(!is_string($value), fn($q) => $q->where($column, $value));
                }
            }

            return $query->get();
        });
    }

    public function show(int $id): JsonResponse
    {
        return $this->apiHandler(fn() => $this->getModelQuery()->findOrFail($id));
    }

    public function store(Request $request): JsonResponse
    {
        return $this->apiHandler(fn() => ['item' => $this->save($this->validateData($request)), 'message' => __('success_saved_item')]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        return $this->apiHandler(fn() => ['item' => $this->save($this->validateData($request), $id), 'message' => __('success_saved_item')]);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->apiHandler(function () use ($id) {
            $this->model::findOrFail($id)->delete();

            return ['message' => __('success_deleted_item')];
        });
    }
}
