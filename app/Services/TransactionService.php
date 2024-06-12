<?php

namespace App\Services;

use App\Mail\NewTransactionMail;
use App\Repositories\TransactionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Events\TransactionCreated;

class TransactionService
{
    public function __construct(protected TransactionRepository $transactionRepository)
    {
    }

    public function getTransactions($filters = []): Collection
    {
        return $this->transactionRepository->getTransactions($filters);
    }

    public function createTransaction(array $data)
    {
        $transaction = $this->transactionRepository->createTransaction($data);

        Log::info('Transaction created: ' . $transaction->id);

        Mail::to($transaction->user->email)->send(new NewTransactionMail());

        broadcast(new TransactionCreated($transaction))->toOthers();

        return $transaction;
    }

    public function findTransactionById($id)
    {
        return $this->transactionRepository->findTransactionById($id);
    }

    public function deleteTransaction($id): void
    {
        $this->transactionRepository->deleteTransaction($id);
    }

    public function getTotalForUser($userId, $filters = [])
    {
        return $this->transactionRepository->getTotalForUser($userId, $filters);
    }
}


