<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

abstract class Controller
{
    protected string $model;

    protected string $pagePath;

    protected string $routeAs;

    abstract protected function getListingItems();

    public function index(): JsonResponse
    {
        return response()->json($this->getListingItems());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->model::findOrFail($id));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->model::create($this->validateData($request));

        return redirect()->route("{$this->routeAs}.index")->with('success', 'Item created.');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $item = $this->model::findOrFail($id);

        $item->update($this->validateData($request, $id));

        return redirect()->route("{$this->routeAs}.index")->with('success', 'Item updated.');
    }

    public function destroy($id): RedirectResponse
    {
        $this->model::findOrFail($id)->delete();

        return redirect()->route("{$this->routeAs}.index")->with('success', 'Item deleted.');
    }
}
