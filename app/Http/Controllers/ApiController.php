<?php

namespace App\Http\Controllers;

use App\Helpers\Responses;

/**
 * @OA\Info(
 *    title="Family Manager BI Group API",
 *    version="1.1.0",
 * )
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 * )
 */
class ApiController extends Controller
{
    use Responses;
}
