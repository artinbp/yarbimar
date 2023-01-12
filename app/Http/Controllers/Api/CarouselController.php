<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarouselController extends Controller
{
    public function list(): JsonResponse
    {
        $carousel = Carousel::all();

        return response()->json($carousel, Response::HTTP_OK);
    }
}
