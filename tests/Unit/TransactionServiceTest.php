<?php

namespace Tests\Unit;

use App\Services\TransactionService;
use App\Repositories\TransactionRepository;
use PHPUnit\Framework\TestCase;

//Example Test
class TransactionServiceTest extends TestCase
{
    protected $transactionService;
    protected $transactionRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transactionRepository = $this->createMock(TransactionRepository::class);
        $this->transactionService = new TransactionService($this->transactionRepository);
    }

    public function testGetTransactions()
    {
        $filters = ['user_id' => 1];
        $this->transactionRepository
            ->expects($this->once())
            ->method('getTransactions')
            ->with($filters)
            ->willReturn([]);

        $result = $this->transactionService->getTransactions($filters);

        $this->assertEmpty($result);
    }
}

