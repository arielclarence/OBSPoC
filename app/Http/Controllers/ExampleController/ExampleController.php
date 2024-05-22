<?php

declare(strict_types=1);

namespace App\Http\Controllers\ExampleController;

use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ExampleController extends BaseController
{
    public function __construct(private readonly SchemaServiceInterface $schemaService) {}

    /**
     * @OA\Get(
     * path="/v1/example",
     * summary="Show example",
     * description="Description",
     * operationId="exampleIndex",
     * tags={"Schema"},
     * security={ {"bearer": {} }},
     * @OA\Response(
     *   response=200,
     *   description="Success"
     *  )
     * )
     *
     * show example message
     */
    public function index(): JsonResponse
    {
        return response()->json(
            ['message' => 'Example message'],
            Response::HTTP_OK,
        );
    }
}
