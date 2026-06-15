<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Symfony\Component\HttpFoundation\Response;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request): Response
    {
        // New registrations are always customers — send them to the catalog
        return $request->wantsJson()
            ? new JsonResponse(['two_factor' => false], 201)
            : redirect(route('catalog'));
    }
}
