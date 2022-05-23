<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class BaseApiController extends Controller
{
    /**
     * Json回應
     *
     * @param  mixed  $data
     * @param  int  $statusCode
     * @param  array  $headers
     * @return JsonResponse
     */
    public function jsonResponse($data = [], int $statusCode = Response::HTTP_OK, array $headers = []): JsonResponse
    {
        return response()->json($data, $statusCode, $headers);
    }

    /**
     * 成功回應
     *
     * @param  mixed  $data
     * @param  int  $statusCode
     * @return JsonResponse
     */
    public function successResponse($data = [], int $statusCode = Response::HTTP_OK): JsonResponse
    {
        $data = $this->transferResponseDataToArray($data);

        return $this->jsonResponse(array_merge(['status' => 'success'], $data), $statusCode);
    }

    /**
     * 失敗回應
     *
     * @param  mixed  $data
     * @param  int  $statusCode
     * @return JsonResponse
     */
    public function errorResponse($data = [], int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $data = $this->transferResponseDataToArray($data);

        return $this->jsonResponse(array_merge(['status' => 'error'], $data), $statusCode);
    }

    /**
     * 分頁類型轉換成Array
     *
     * @param  LengthAwarePaginator|Paginator  $paginator
     * @return array
     */
    protected function paginate(LengthAwarePaginator|Paginator $paginator): array
    {
        if ($paginator instanceof LengthAwarePaginator) {
            $paginateData = [
                'data' => $paginator->items(),
                'total' => $paginator->total()
            ];
        } elseif ($paginator instanceof Paginator) {
            $paginateData = [
                'data' => $paginator->items(),
                'has_pages' => $paginator->hasPages(),
                'is_first_page' => $paginator->onFirstPage(),
                'is_last_page' => $paginator->onLastPage()
            ];
        }

        return $paginateData;
    }

    /**
     * 分頁回應
     *
     * @param  LengthAwarePaginator|Paginator  $paginator
     * @param  array  $attach
     * @return JsonResponse
     */
    public function paginateResponse(LengthAwarePaginator|Paginator $paginator, array $attach = []): JsonResponse 
    {
        $paginate = $this->paginate($paginator);

        return $this->jsonResponse(array_merge($paginate, $attach));
    }

    /**
     * 資源分頁回應
     *
     * @param  LengthAwarePaginator|Paginator  $paginator
     * @param  string  $resource
     * @param  array  $attach
     * @return JsonResponse
     */
    public function paginateResourceResponse(
        LengthAwarePaginator|Paginator $paginator, 
        string $resource, 
        array $attach = []
    ): JsonResponse {
        $paginate = $this->paginate($paginator);

        $paginate['data'] = new $resource($paginate['data']);

        return $this->jsonResponse(array_merge($paginate, $attach));
    }

    /**
     * 回應資料轉換成Array
     *
     * @param  mixed  $data
     * @param  string  $key
     * @return array
     */
    public function transferResponseDataToArray($data = [], string $key = 'data'): array
    {
        if (empty($data)) {
            return [];
        }
        if (is_string($data)) {
            $key = 'message';
        }
        if (!is_array($data)) {
            return [$key => $data];
        }
        
        return $data;
    }
}