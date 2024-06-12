<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * Class TransactionController
 * @package App\Http\Controllers
 *
 * @OA\Info(title="API Documentation", version="1.0")
 */
class TransactionController extends Controller
{
    /**
     * TransactionController constructor.
     * @param TransactionService $transactionService
     */
    public function __construct(protected TransactionService $transactionService)
    {
    }

    /**
     * Display a listing of transactions.
     *
     * @param TransactionRequest $request
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/transactions",
     *     summary="Get a list of transactions",
     *     @OA\Response(response="200", description="Success")
     * )
     */
    public function index(TransactionRequest $request): JsonResponse
    {
        $filters = $request->validated();
        $filters['user_id'] = Auth::id();

        return response()->json($this->transactionService->getTransactions($filters));
    }

    /**
     * Store a newly created transaction.
     *
     * @param TransactionRequest $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/transactions",
     *     summary="Create a new transaction",
     *     @OA\Response(response="201", description="Created")
     * )
     */
    public function store(TransactionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['author_id'] = Auth::id();

        $transaction = $this->transactionService->createTransaction($data);

        return response()->json($transaction, 201);
    }

    /**
     * Display the specified transaction.
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/transactions/{id}",
     *     summary="Get a specific transaction",
     *     @OA\Response(response="200", description="Success")
     * )
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->transactionService->findTransactionById($id));
    }

    /**
     * Remove the specified transaction.
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Delete(
     *     path="/api/transactions/{id}",
     *     summary="Delete a specific transaction",
     *     @OA\Response(response="204", description="Deleted")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->transactionService->deleteTransaction($id);

        return response()->json(null, 204);
    }
}
