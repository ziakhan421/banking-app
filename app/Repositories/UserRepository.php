<?php


namespace App\Repositories;

use App\Models\User;
use Illuminate\Container\Container as Application;

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'name',
        'email',
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
        return User::class;
    }
}
