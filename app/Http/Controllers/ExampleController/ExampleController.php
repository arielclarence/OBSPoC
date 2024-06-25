<?php

declare(strict_types=1);

namespace App\Http\Controllers\ExampleController;

use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class ExampleController extends BaseController
{
    #[OA\Get(
        path: '/v1/example',
        operationId: 'exampleIndex',
        description: 'Description',
        summary: 'Show example',
        security: [
            ['bearerAuth' => []],
        ],
        tags: ['Example'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Success'
            ),
        ],
    )]
    public function index(): JsonResponse
    {
        return response()->json(
            ['message' => 'Example message'],
            Response::HTTP_OK,
        );
    }
}
