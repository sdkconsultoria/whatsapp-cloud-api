<?php

namespace Sdkconsultoria\WhatsappCloudApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class APIResourceController extends Controller
{
    protected $resource;
    protected $transformer;

    private function defaultOptions($models, Request $request)
    {
        return $models;
    }

    private function filters(): array
    {
        return [
            'chat_id' => function ($query, $value) {
                return $query->where('chat_id', "$value");
            },
        ];
    }

    private function applyFilters($query, Request $request)
    {
        foreach ($this->filters() as $index => $filter) {
            $search_value = $request->input($index);
            if ($search_value) {
                $query = $filter($query, $search_value);
            }
        }

        return $query;
    }

    public function index(Request $request)
    {
        $models = new $this->resource;
        $models = $this->applyFilters($models, $request);
        $models = $this->defaultOptions($models, $request);
        $models = $models->paginate()->appends(request()->except('page'));

        if ($this->transformer) {
            $transformer = $this->transformer;
            return $transformer::collection($models);
        }
        return response()->json($models);
    }
}
