<?php


namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Container\Container as Application;

class TransactionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'type',
        'amount',
        'balance',
        'description'
    ];

    public function __construct()
    {
        parent::__construct(Application::getInstance());
    }

    /**
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * @return string
     */
    public function model(): string
    {
        return Transaction::class;
    }
}
