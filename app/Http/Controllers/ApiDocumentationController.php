<?php

namespace App\Http\Controllers;

use App\Models\Endpoint;
use App\Models\Group;
use Illuminate\View\View;

class ApiDocumentationController extends Controller
{
    public function show(Endpoint $endpoint): View
    {
        return view('api.documentation.show', [
            'endpoint' => $endpoint->load(['method', 'group', 'collection', 'headers', 'payloads'])
        ]);
    }

    public function showGroupCollections(Group $group): View
    {
        return view('api.documentation.group', [
            'group' => $group->load(['collections.endpoints.method', 'collections.endpoints.headers', 'collections.endpoints.payloads'])
        ]);
    }
} 