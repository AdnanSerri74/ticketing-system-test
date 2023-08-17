<?php

namespace app\Core;

class Builder
{
    protected $statement = '';
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function where(array ...$conditions): Builder
    {
        $whereStatement = "WHERE";

        foreach ($conditions as $condition) {
            $operators = ['=', '!=', '<>', 'like', '>', '<', ''];

            if (in_array($condition[1], $operators)) {
                $valueOperator = $condition[1];
                $value = $condition[2];
                $conditionOperator = isset($condition[3]) ? strtoupper($condition[3]) : 'AND';
            } else {
                $valueOperator = '=';
                $value = $condition[1];
                $conditionOperator = isset($condition[2]) ? strtoupper($condition[2]) : 'AND';
            }

            $whereStatement .= " {$condition[0]} {$valueOperator} '$value' $conditionOperator";

        }

        $this->statement = substr($whereStatement, 0, strlen($whereStatement) - 4);

        return $this;
    }

    public function orderBy(string $column, string $dir = 'asc'): Builder
    {

        $dir = strtoupper($dir);

        $this->statement = "ORDER BY $column $dir";

        return $this;
    }

    public function first(array|string $columns = '*'): Model|false
    {

        $db = App::resolve(DB::class);

        $data = $db->query("SELECT * FROM {$this->model->table()} $this->statement LIMIT 1")
            ->find();

        if (!$data)
            return false;

        $cols = $columns != "*" ? $columns : ['id', ...$this->model->fillable()];

        foreach ($cols as $col)
            $this->model->$col = $data[$col];

        return $this->model;
    }

    public function firstOrFail(array|string $columns = '*'): Model
    {
        $db = App::resolve(DB::class);

        $data = $db->query("SELECT * FROM {$this->model->table()} $this->statement LIMIT 1")
            ->findOrFail();

        $cols = $columns != "*" ? $columns : ['id', ...$this->model->fillable()];

        foreach ($cols as $col)
            $this->model->$col = $data[$col];

        return $this->model;
    }

    public function get(array|string $columns = '*'): array
    {
        $db = App::resolve(DB::class);

        $data = $db->query("SELECT * FROM {$this->model->table()} $this->statement")
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

    public function paginate(int $perPage = null, array|string $columns = "*"): Paginator
    {

        $db = App::resolve(DB::class);

        $perPage = request()->query('perPage') ?? $perPage;

        if ($perPage < 1)
            throw new \Exception('perPage is supposed to be a positive number.', 500);

        $page = request()->query('page') ?? 1;

        $offset = ($page - 1) * $perPage;

        $instance = $this->model;

        $totalRows = $db->query("SELECT COUNT(*) FROM {$instance->table()} $this->statement")->find()['COUNT(*)'];

        $totalPages = ceil($totalRows / $perPage);

        $paginated = $db->query("SELECT * FROM {$instance->table()} $this->statement LIMIT $offset, $perPage")->get();

        $cols = $columns != "*" ? $columns : ['id', ...$instance->fillable()];

        $models = [];

        foreach ($paginated as $modelData) {
            $instance = new ($this->model::class);

            foreach ($cols as $col)
                $instance->$col = $modelData[$col];

            $models[] = $instance;
        }

        return new Paginator($perPage, $page, $totalRows, $totalPages, $models);
    }
}