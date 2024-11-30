<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait CacheTrait
{
    /**
     * Tempo padrão de cache em minutos
     */
    protected int $defaultCacheTime = 60;

    /**
     * Prefixo para as chaves de cache
     */
    protected string $cachePrefix = 'app_cache_';

    /**
     * Obtém um item do cache ou executa o callback se não existir
     *
     * @param string $key
     * @param \Closure $callback
     * @param int|null $minutes
     * @return mixed
     */
    protected function remember(string $key, \Closure $callback, ?int $minutes = null)
    {
        $minutes = $minutes ?? $this->defaultCacheTime;
        $key = $this->getCacheKey($key);

        return Cache::remember($key, $minutes * 60, $callback);
    }

    /**
     * Obtém um item do cache permanentemente ou executa o callback se não existir
     *
     * @param string $key
     * @param \Closure $callback
     * @return mixed
     */
    protected function rememberForever(string $key, \Closure $callback)
    {
        $key = $this->getCacheKey($key);
        return Cache::rememberForever($key, $callback);
    }

    /**
     * Invalida um item específico do cache
     *
     * @param string $key
     * @return bool
     */
    protected function forget(string $key): bool
    {
        return Cache::forget($this->getCacheKey($key));
    }

    /**
     * Invalida vários itens do cache por tag
     *
     * @param string|array $tags
     * @return bool
     */
    protected function forgetByTags(string|array $tags): bool
    {
        return Cache::tags($tags)->flush();
    }

    /**
     * Invalida todos os itens do cache com o prefixo da aplicação
     *
     * @return bool
     */
    protected function flushAll(): bool
    {
        return Cache::flush();
    }

    /**
     * Gera uma chave de cache para um modelo
     *
     * @param Model $model
     * @param string|null $suffix
     * @return string
     */
    protected function getModelCacheKey(Model $model, ?string $suffix = null): string
    {
        $key = strtolower(class_basename($model)) . '_' . $model->getKey();
        if ($suffix) {
            $key .= '_' . $suffix;
        }
        return $this->getCacheKey($key);
    }

    /**
     * Gera uma chave de cache para uma coleção de modelos
     *
     * @param Collection $collection
     * @param string|null $suffix
     * @return string
     */
    protected function getCollectionCacheKey(Collection $collection, ?string $suffix = null): string
    {
        $key = $collection->map(function ($item) {
            return $item instanceof Model
                ? $item->getKey()
                : (string) $item;
        })->join('_');

        $key = 'collection_' . md5($key);
        if ($suffix) {
            $key .= '_' . $suffix;
        }

        return $this->getCacheKey($key);
    }

    /**
     * Gera uma chave de cache para filtros
     *
     * @param array $filters
     * @param string|null $prefix
     * @return string
     */
    protected function getFiltersCacheKey(array $filters, ?string $prefix = null): string
    {
        ksort($filters);
        $key = md5(json_encode($filters));
        if ($prefix) {
            $key = $prefix . '_' . $key;
        }
        return $this->getCacheKey('filters_' . $key);
    }

    /**
     * Adiciona o prefixo da aplicação à chave
     *
     * @param string $key
     * @return string
     */
    protected function getCacheKey(string $key): string
    {
        return $this->cachePrefix . $key;
    }

    /**
     * Define o tempo padrão de cache
     *
     * @param int $minutes
     * @return void
     */
    protected function setDefaultCacheTime(int $minutes): void
    {
        $this->defaultCacheTime = $minutes;
    }

    /**
     * Define o prefixo para as chaves de cache
     *
     * @param string $prefix
     * @return void
     */
    protected function setCachePrefix(string $prefix): void
    {
        $this->cachePrefix = $prefix . '_';
    }

    /**
     * Obtém dados em cache com tags
     *
     * @param array|string $tags
     * @param string $key
     * @param \Closure $callback
     * @param int|null $minutes
     * @return mixed
     */
    protected function rememberByTags(array|string $tags, string $key, \Closure $callback, ?int $minutes = null)
    {
        $minutes = $minutes ?? $this->defaultCacheTime;
        $key = $this->getCacheKey($key);

        return Cache::tags($tags)->remember($key, $minutes * 60, $callback);
    }
}
