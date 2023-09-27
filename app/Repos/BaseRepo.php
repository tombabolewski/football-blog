<?php

declare(strict_types=1);

namespace App\Repos;

use App\Exceptions\ClassIsNotInstanceOfModelException;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepo
{
    /**
     * @var class-string<Model> $model Model class
     */
    protected abstract static readonly string $modelClass;

    public function create(array $properties): Model
    {
        $modelClass = static::$modelClass;
        if (is_subclass_of($modelClass, Model::class) === false) {
            throw new ClassIsNotInstanceOfModelException("{$modelClass} class is not instance of Model");
        }

        /** @var Model */
        $model = new $modelClass();
        foreach ($properties as $key => $value) {
            $model->$key = $value;
        }
        $model->save();
        $this->afterCreate($model);
        return $model->fresh();
    }

    public function delete(Model $model): bool
    {
        if ($model->delete()) {
            $this->afterDelete($model);
            return true;
        }
        return false;
    }

    protected function afterCreate(Model $model): void
    {
        // May be implemented in child class
    }

    protected function afterDelete(Model $model): void
    {
        // May be implemented in child class
    }
}
