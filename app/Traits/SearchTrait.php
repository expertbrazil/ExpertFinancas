<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait SearchTrait
{
    /**
     * Aplica filtros de busca ao query builder
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public function scopeSearch(Builder $query, array $filters): Builder
    {
        foreach ($filters as $field => $value) {
            if (empty($value)) {
                continue;
            }

            // Verifica se existe um método específico para o campo
            $method = 'filter' . Str::studly($field);
            if (method_exists($this, $method)) {
                $this->$method($query, $value);
                continue;
            }

            // Aplica filtro padrão baseado no tipo de campo
            $this->applyDefaultFilter($query, $field, $value);
        }

        return $query;
    }

    /**
     * Aplica filtro padrão baseado no tipo de campo
     *
     * @param Builder $query
     * @param string $field
     * @param mixed $value
     * @return void
     */
    protected function applyDefaultFilter(Builder $query, string $field, mixed $value): void
    {
        // Obtém informações sobre o campo do modelo
        $table = $query->getModel()->getTable();
        $columnType = $this->getColumnType($table, $field);

        // Aplica filtro baseado no tipo da coluna
        switch ($columnType) {
            case 'string':
            case 'text':
                $query->where($field, 'LIKE', "%{$value}%");
                break;

            case 'integer':
            case 'bigint':
            case 'float':
            case 'decimal':
                $query->where($field, $value);
                break;

            case 'date':
            case 'datetime':
                $this->applyDateFilter($query, $field, $value);
                break;

            case 'boolean':
                $query->where($field, filter_var($value, FILTER_VALIDATE_BOOLEAN));
                break;

            case 'enum':
                $query->where($field, $value);
                break;

            default:
                $query->where($field, $value);
        }
    }

    /**
     * Aplica filtro para campos de data
     *
     * @param Builder $query
     * @param string $field
     * @param mixed $value
     * @return void
     */
    protected function applyDateFilter(Builder $query, string $field, mixed $value): void
    {
        if (is_array($value)) {
            if (isset($value['start'])) {
                $query->where($field, '>=', $value['start']);
            }
            if (isset($value['end'])) {
                $query->where($field, '<=', $value['end']);
            }
        } else {
            $query->whereDate($field, $value);
        }
    }

    /**
     * Obtém o tipo da coluna do banco de dados
     *
     * @param string $table
     * @param string $column
     * @return string|null
     */
    protected function getColumnType(string $table, string $column): ?string
    {
        $schema = \DB::getDoctrineSchemaManager();
        $columns = $schema->listTableColumns($table);

        return $columns[$column]->getType()->getName();
    }

    /**
     * Aplica ordenação ao query builder
     *
     * @param Builder $query
     * @param string|array $orderBy
     * @param string $direction
     * @return Builder
     */
    public function scopeApplyOrder(Builder $query, string|array $orderBy, string $direction = 'asc'): Builder
    {
        if (is_array($orderBy)) {
            foreach ($orderBy as $field => $dir) {
                $query->orderBy($field, $dir);
            }
        } else {
            $query->orderBy($orderBy, $direction);
        }

        return $query;
    }

    /**
     * Aplica agrupamento ao query builder
     *
     * @param Builder $query
     * @param string|array $groupBy
     * @return Builder
     */
    public function scopeApplyGrouping(Builder $query, string|array $groupBy): Builder
    {
        if (is_array($groupBy)) {
            $query->groupBy($groupBy);
        } else {
            $query->groupBy($groupBy);
        }

        return $query;
    }

    /**
     * Aplica relacionamentos ao query builder
     *
     * @param Builder $query
     * @param array $relations
     * @return Builder
     */
    public function scopeWithRelations(Builder $query, array $relations): Builder
    {
        foreach ($relations as $relation => $callback) {
            if (is_numeric($relation)) {
                $query->with($callback);
            } else {
                $query->with([$relation => $callback]);
            }
        }

        return $query;
    }
}
