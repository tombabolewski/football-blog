<?php

namespace App\Repos;

use App\Exceptions\ClassIsNotInstanceOfModelException;
use App\Exceptions\WrongModelInstanceException;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepo
{
    /**
     * @var class-string<Model> $model Model class
     */
    protected static string $modelClass;

    public function create(array $properties): Model
    {
        $this->beforeAction();
        $this->beforeCreate($properties);
        /** @var Model */
        $model = new static::$modelClass();
        foreach ($properties as $key => $value) {
            $model->$key = $value;
        }
        $model->save();
        $this->afterCreate($model);
        return $model->fresh();
    }

    public function update($model, array $properties): Model
    {
        $this->beforeAction();
        $this->beforeUpdate($model, $properties);
        foreach ($properties as $key => $value) {
            $model->$key = $value;
        }
        $model->save();
        $this->afterUpdate($model);
        return $model->fresh();
    }

    public function delete($model): bool
    {
        $this->beforeAction();
        $this->beforeDelete($model);
        if ($model->delete()) {
            $this->afterDelete($model);
            return true;
        }
        return false;
    }

    protected function checkModelClass(): void
    {
        $modelClass = static::$modelClass;
        if (is_subclass_of($modelClass, Model::class) === false) {
            throw new ClassIsNotInstanceOfModelException("{$modelClass} class is not instance of Model");
        }
    }

    protected function checkModel($model): void
    {
        $modelClass = static::$modelClass;
        if ($model instanceof $modelClass === false) {
            throw new WrongModelInstanceException("Model is not instance of {$modelClass}");
        }
    }

    protected function beforeAction(): void
    {
        $this->checkModelClass();
    }

    protected function beforeCreate(array $properties): void
    {
    }
    protected function afterCreate($model): void
    {
    }
    protected function beforeUpdate($model, array $properties): void
    {
        $this->checkModel($model);
    }
    protected function afterUpdate($model): void
    {
    }
    protected function beforeDelete($model): void
    {
        $this->checkModel($model);
    }
    protected function afterDelete($model): void
    {
    }
}
