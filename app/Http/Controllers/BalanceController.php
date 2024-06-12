<?php

namespace App\Http\Controllers;

use App\Http\Requests\BalanceRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * Class BalanceController
 * @package App\Http\Controllers
 */
class BalanceController extends Controller
{
    /**
     * BalanceController constructor.
     * @param TransactionService $transactionService
     */
    public function __construct(protected TransactionService $transactionService)
    {
    }

    /**
     * Display the current balance in a specified currency for the authenticated user.
     *
     * @param BalanceRequest $request
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/balance/currency",
     *     summary="Get the current balance in a specified currency for the authenticated user",
     *     @OA\Response(response="200", description="Success")
     * )
     */
    public function balanceInCurrency(BalanceRequest $request): JsonResponse
    {
        $filters = $request->only(['from', 'to']);
        $userId = Auth::id();
        $currency = $request->input('currency', 'USD');

        $total = $this->transactionService->getTotalForUser($userId, $filters);
        $totalInCurrency = convertCurrency($total, $currency);

        return response()->json(['total' => $totalInCurrency, 'currency' => $currency]);
    }
}

