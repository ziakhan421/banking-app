<?php


namespace App\Repositories;

use App\Models\Account;
use Illuminate\Container\Container as Application;

class AccountRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'balance',
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
        return Account::class;
    }
}
