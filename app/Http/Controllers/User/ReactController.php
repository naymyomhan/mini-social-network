<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReactRequest;
use App\Services\User\ReactService;
use App\Traits\ResponseTraits;

class ReactController extends Controller
{
    use ResponseTraits;
    /**
     * @var ReactService $reactService;
     */
    protected ReactService $reactService;

    public function __construct(ReactService $reactService)
    {
        $this->reactService = $reactService;
    }

    public function addReact(ReactRequest $request, $id)
    {
        $react = $this->reactService->addReact($id, $request->reaction);
        return $this->success('Add reaction successful', $react);
    }

    public function removeReact($id)
    {
        $this->reactService->removeReact($id);
        return $this->success('Remove reaction successful');
    }
}
