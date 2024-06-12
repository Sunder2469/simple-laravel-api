<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository
{
    public function getTransactions(array $filters = []): Collection
    {
        $query = Transaction::query();

        if (isset($filters['user_id'])) {
            $query->where('author_id', $filters['user_id']);
        }

        if (isset($filters['type'])) {
            if ($filters['type'] === 'income') {
                $query->where('amount', '>', 0);
            } elseif ($filters['type'] === 'expense') {
                $query->where('amount', '<', 0);
            }
        }

        if (isset($filters['amount'])) {
            $query->where('amount', $filters['amount']);
        }

        if (isset($filters['created_at'])) {
            $query->whereDate('created_at', $filters['created_at']);
        }

        return $query->get();
    }

    public function createTransaction(array $data)
    {
        return Transaction::create($data);
    }

    public function findTransactionById($id)
    {
        return Transaction::findOrFail($id);
    }

    public function deleteTransaction($id): void
    {
        $transaction = $this->findTransactionById($id);
        $transaction->delete();
    }

    public function getTotalForUser($userId, $filters = [])
    {
        $query = Transaction::where('author_id', $userId);

        if (isset($filters['from'])) {
            $query->whereDate('created_at', '>=', $filters['from']);
        }

        if (isset($filters['to'])) {
            $query->whereDate('created_at', '<=', $filters['to']);
        }

        return $query->sum('amount');
    }
}
