<?php

namespace App\Repositories;

use Exception;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     *
     * @throws Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Paginate records for scaffold.
     *
     * @param int $perPage
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate($perPage, $columns = ['*'])
    {
        $query = $this->allQuery();

        return $query->paginate($perPage, $columns);
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @return Builder
     */
    public function allQuery($search = [], $skip = null, $limit = null): Builder
    {
        $this->makeModel();

        $query = $this->model->newQuery();

        if (count($search)) {
            foreach ($search as $key => $value) {
                if ($value && in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Make Model instance
     *
     * @return Model
     * @throws Exception
     *
     */
    public function makeModel()
    {
        if (!$this->model) {
            $model = $this->app->make($this->model());

            if (!$model instanceof Model) {
                throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
            }
            $this->model = $model;
        }
        return $this->model;
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract public function model();

    /**
     * Get searchable fields array
     *
     * @return array
     */
    abstract public function getFieldsSearchable();

    /**
     * Retrieve all records with given filter criteria
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $columns
     *
     * @return Builder[]|Collection
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {

        $query = $this->allQuery([], $skip, $limit);

        return $query->get($columns);
    }

    /**
     * @param $search
     * @param $skip
     * @param $limit
     * @return Builder
     */
    public function search(?string $search, $skip = null, $limit = null)
    {
        $query = $this->allQuery([], $skip,$limit);

        if ($search) {
            foreach ($this->getFieldsSearchable() as $field){
                $query->orWhere($field, "like", "%$search%");
            }
        }
        return $query;
    }

    /**
     * Create model record
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        $this->makeModel();

        $model = $this->model->newInstance($input);

        $model->save();

        return $model;
    }

    /**
     * Find model record for given id
     *
     * @param int $id
     * @param array $columns
     *
     * @return Builder|Builder[]|Collection|Model|null
     * @throws Exception
     */
    public function find($id, $columns = ['*']): Model|Collection|Builder|array|null
    {
        $this->makeModel();

        $query = $this->model->newQuery();

        return $query->find($id, $columns);
    }

    /**
     * Update model record for given id
     *
     * @param array $input
     * @param int $id
     *
     * @return Builder|Builder[]|Collection|Model
     * @throws Exception
     */
    public function update($input, $id): Model|Collection|Builder|array
    {
        $this->makeModel();

        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * @param int $id
     *
     * @return bool|mixed|null
     * @throws Exception
     *
     */
    public function delete($id)
    {
        $this->makeModel();

        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        return $model->delete();
    }

    /**
     * @param $id
     * @return int
     * @throws Exception
     */
    public function destroy($id): int
    {
        $this->makeModel();

        return $this->model->destroy($id);
    }
}
