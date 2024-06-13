<?php

namespace App\Http\Controllers;

use App\Http\Requests\BalanceRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
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
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="from",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", format="date"),
     *         description="Start date for the balance calculation"
     *     ),
     *     @OA\Parameter(
     *         name="to",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", format="date"),
     *         description="End date for the balance calculation"
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Type of transactions to include (income, expense, or all)"
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     *     @OA\Header(
     *         header="Content-Type",
     *         description="Content-Type header",
     *         @OA\Schema(type="string", default="application/json")
     *     ),
     *     @OA\Header(
     *         header="Accept",
     *         description="Accept header",
     *         @OA\Schema(type="string", default="application/json")
     *     )
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

