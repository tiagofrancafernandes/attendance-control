<?php

namespace App\Core\CollectModel;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

#[\AllowDynamicProperties]
class Base extends Collection
{
    protected static array $protectedToSet = [ // Prevent to get by __get
        //
    ];

    protected static array $protectedToGet = [ // Prevent to get by __get
        //
    ];

    protected Collection $data;

    public function __construct(
        Model|Collection|array $data
    ) {
        $this->data = \collect();

        \collect($data)->each(function ($item, $key) {
            if (!$key || !\is_string($key)) {
                return;
            }

            $this->data->put($key, static::collectAll($item));

            $this->__set($key, static::collectAll($item));
        });
    }

    /**
     * function __get
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key): mixed
    {
        if (
            !\is_string($key) ||
            \in_array($key, static::$protectedToGet) ||
            \in_array($key, self::$protectedToGet)
        ) {
            return \null;
        }

        return $this->get($key) ?? $this->getData($key);
    }

    /**
     * function __set
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function __set($key, $value): void
    {
        if (
            !\is_string($key) ||
            \in_array($key, static::$protectedToSet, true) ||
            \in_array($key, self::$protectedToSet, true)
        ) {
            return;
        }

        $this->put($key, $value);
        $this->data->put($key, $value);
    }

    /**
     * function collectAll
     *
     * @param mixed $data
     * @return Collection
     */
    public static function collectAll(mixed $data): Collection
    {
        return collect($data)
            ->map(function ($item) {
                if (is_array($item)) {
                    return static::collectAll($item);
                }

                if (\is_object($item) && $item instanceof Collection) {
                    return $item;
                }

                return $item;
            });
    }

    /**
     * function getData
     *
     * @param ?string $key
     * @param mixed $default
     * @return mixed
     */
    public function getData(?string $key = null, mixed $default = null): mixed
    {
        if (!$key) {
            return $this->data;
        }

        return $this->data->get($key, $default);
    }
}
