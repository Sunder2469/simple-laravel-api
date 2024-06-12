<?php

namespace App\Http\Controllers;

use App\Http\Requests\BalanceRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * UserController constructor.
     * @param TransactionService $transactionService
     */
    public function __construct(protected TransactionService $transactionService)
    {
    }

    /**
     * Display the current balance for the authenticated user.
     *
     * @param BalanceRequest $request
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/user/balance",
     *     summary="Get the current balance for the authenticated user",
     *     @OA\Response(response="200", description="Success")
     * )
     */
    public function balance(BalanceRequest $request): JsonResponse
    {
        $filters = $request->only(['from', 'to']);
        $userId = Auth::id();

        return response()->json([
            'total' => $this->transactionService->getTotalForUser($userId, $filters)
        ]);
    }
}

