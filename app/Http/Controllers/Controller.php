<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

abstract class Controller
{
    protected string $model;

    protected string $pagePath;

    protected string $routeAs;

    abstract protected function getListingItems();

    public function index(): Response
    {
        return Inertia::render("{$this->pagePath}/Index", ['items' => $this->getListingItems()]);
    }

    public function edit(int $id): Response
    {
        return Inertia::render("{$this->pagePath}/Form", ['model' => $this->model::findOrFail($id)]);
    }

    public function create()
    {
        return Inertia::render("{$this->pagePath}/Form", ['model' => []]);
    }
}
