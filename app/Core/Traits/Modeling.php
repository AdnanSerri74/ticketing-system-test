<?php

namespace app\Core\Traits;

use app\Core\App;
use app\Core\Builder;
use app\Core\DB;
use app\Core\Model;
use app\Core\Paginator;
use app\Core\WhereStatement;
use PDO;

trait Modeling
{
    public static function all(array|string $columns = "*"): array
    {
        $db = App::resolve(DB::class);

        $instance = new static();

        $data = $db->query("SELECT $columns FROM {$instance->table()};")->get();

        if (!$data)
            return [];

        $cols = $columns != "*" ? $columns : ['id', ...$instance->fillable()];

        $models = [];

        foreach ($data as $modelData) {
            $instance = new static();

            foreach ($cols as $col)
                $instance->$col = $modelData[$col];

            $models[] = $instance;
        }

        return $models;
    }

    public static function find(int $id, $columns = "*"): static|Model
    {
        $db = App::resolve(DB::class);

        $instance = new static();

        $data = $db->query("SELECT $columns FROM {$instance->table()} WHERE id='$id';")->findOrFail();

        $cols = $columns != "*" ? $columns : ['id', ...$instance->fillable()];

        foreach ($cols as $col)
            $instance->$col = $data[$col];

        return $instance;
    }

    public static function where(array ...$conditions): WhereStatement
    {

        $instance = new static();

        $whereStatement = "WHERE";

        foreach ($conditions as $condition) {
            $operators = ['=', '!=', '<>', 'like', '>', '<', ''];

            if (in_array($condition[1], $operators)) {
                $valueOperator = $condition[1];
                $value = $condition[2];
                $conditionOperator = isset($condition[3]) ? strtoupper($condition[3]) : '';
            } else {
                $valueOperator = '=';
                $value = $condition[1];
                $conditionOperator = isset($condition[2]) ? strtoupper($condition[2]) : '';
            }

            $whereStatement .= " {$condition[0]} {$valueOperator} '$value' $conditionOperator";
        }

        return new WhereStatement($instance, $whereStatement);

    }

    public static function create(array $attributes): static|false
    {
        $db = App::resolve(DB::class);

        $instance = new static();

        $keysString = join(', ', array_keys($attributes));
        $valuesString = join(', ', array_map(fn($value) => "'$value'", array_values($attributes)));


        if( $db->query("INSERT INTO {$instance->table} ($keysString) VALUES ($valuesString);")->executed())
        {
            $insertedID = $db->lastInsertedID();
            $data = $db->query("SELECT * FROM {$instance->table} WHERE id='$insertedID';")->find();

            $cols = ['id', ...$instance->fillable()];

            foreach ($cols as $col)
                $instance->$col = $data[$col];

            return $instance;
        }

        return false;
    }

    public static function update(int $id, array $attributes): bool
    {
        $db = App::resolve(DB::class);

        $instance = new static();

        $updateStatement = join(', ', array_map(function ($key, $value) {
            return "$key='$value'";
        }, array_keys($attributes), array_values($attributes)));


        return $db->query("UPDATE {$instance->table()} SET $updateStatement WHERE id='$id';")->executed();
    }

    public static function delete(int $id): bool
    {
        $db = App::resolve(DB::class);

        $instance = new static();

        return $db->query("DELETE FROM {$instance->table()} WHERE id='$id';")->executed();
    }

    public static function paginate(int $perPage, array|string $columns = "*"): Paginator {

        $db = App::resolve(DB::class);

        $perPage = request()->query('perPage') ?? $perPage;

        if ($perPage < 1)
            throw new \Exception('perPage is supposed to be a positive number.', 500);

        $page = request()->query('page') ?? 1;

        $offset = ($page-1) * $perPage;

        $instance = new static();

        $totalRows = $db->query("SELECT COUNT(*) FROM {$instance->table()}")->find()['COUNT(*)'];

        $totalPages = ceil($totalRows / $perPage);

        $paginated = $db->query("SELECT * FROM {$instance->table()} LIMIT $offset, $perPage")->get();

        $cols = $columns != "*" ? $columns : ['id', ...$instance->fillable()];

        $models = [];

        foreach ($paginated as $modelData) {
            $instance = new static();

            foreach ($cols as $col)
                $instance->$col = $modelData[$col];

            $models[] = $instance;
        }

        return new Paginator($perPage, $page, $totalRows, $totalPages, $models);
    }

    public static function query(): Builder {

        return new Builder(new static);
    }
}