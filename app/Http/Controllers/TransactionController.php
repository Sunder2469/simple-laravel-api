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
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer"
 * )
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
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Type of transaction (income or expense)"
     *     ),
     *     @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Amount of the transaction"
     *     ),
     *     @OA\Parameter(
     *         name="created_at",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", format="date-time"),
     *         description="Creation date of the transaction"
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
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "amount"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="amount", type="integer")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Created"),
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
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Transaction ID"
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     *     @OA\Response(response="404", description="Not Found"),
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
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Transaction ID"
     *     ),
     *     @OA\Response(response="204", description="Deleted"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     *     @OA\Response(response="404", description="Not Found"),
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
    public function destroy(int $id): JsonResponse
    {
        $this->transactionService->deleteTransaction($id);

        return response()->json(null, 204);
    }
}
