<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepo
{
    protected static string $modelClass;

    public function create(object $properties): Model 
    {
        /** @var Model */
        $model = new static::$modelClass;
        foreach ($properties as $key => $value) {
            $model->$key = $value;
        }
        $model->save();
        $this->afterCreate($model);
        return $model->fresh();
    }

    abstract public function afterCreate(Model $model): void;
}
