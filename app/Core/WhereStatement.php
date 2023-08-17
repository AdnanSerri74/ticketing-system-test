<?php

namespace app\Core;

use app\Core\Traits\Modeling;

class WhereStatement
{
    protected string $statement;
    protected Model $model;

    public function __construct(Model $model, string $statement)
    {
        $this->statement = $statement;
        $this->model = $model;
    }
    public function first(array|string $columns = '*'): Model|false {

        $db = App::resolve(DB::class);

        $data = $db->query("SELECT $columns FROM {$this->model->table()} $this->statement LIMIT 1")
            ->find();

        if (!$data)
            return false;

        $cols = $columns != "*" ? $columns : ['id', ...$this->model->fillable()];

        foreach ($cols as $col)
            $this->model->$col = $data[$col];

        return $this->model;
    }
    public function firstOrFail(array|string $columns = '*'): Model {
        $db = App::resolve(DB::class);

        $data = $db->query("SELECT $columns FROM {$this->model->table()} $this->statement LIMIT 1")
            ->findOrFail();

        $cols = $columns != "*" ? $columns : ['id', ...$this->model->fillable()];

        foreach ($cols as $col)
            $this->model->$col = $data[$col];

        return $this->model;
    }

    public function get(array|string $columns = '*'): array {
        $db = App::resolve(DB::class);

        $data = $db->query("SELECT $columns FROM {$this->model->table()} $this->statement")
            ->get();

        if (!$data)
            return [];

        $cols = $columns != "*" ? $columns : ['id', ...$this->model->fillable()];

        $models = [];

        foreach ($data as $modelData) {
            $model = new ($this->model::class);


            foreach ($cols as $col)
                $model->$col = $modelData[$col];

            $models[] = $model;
        }

        return $models;
    }

    public function paginate(int $perPage = null, array|string $columns = "*"): Paginator {

        $db = App::resolve(DB::class);

        $perPage = request()->query('perPage') ?? $perPage;

        if ($perPage < 1)
            throw new \Exception('perPage is supposed to be a positive number.', 500);

        $page = request()->query('page') ?? 1;

        $offset = ($page-1) * $perPage;

        $instance = $this->model;

        $totalRows = $db->query("SELECT COUNT(*) FROM {$instance->table()} $this->statement")->find()['COUNT(*)'];

        $totalPages = ceil($totalRows / $perPage);

        $paginated = $db->query("SELECT * FROM {$instance->table()} $this->statement LIMIT $offset, $perPage")->get();

        $cols = $columns != "*" ? $columns : ['id', ...$instance->fillable()];

        $models = [];

        foreach ($paginated as $modelData) {
            $instance =  new ($this->model::class);

            foreach ($cols as $col)
                $instance->$col = $modelData[$col];

            $models[] = $instance;
        }

        return new Paginator($perPage, $page, $totalRows, $totalPages, $models);
    }
}