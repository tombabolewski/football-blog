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
    protected static string $modelClass;

    public function create(array $properties): Model 
    {
        $modelClass = static::$modelClass;
        if (is_subclass_of($modelClass, Model::class) === false) {
            throw new ClassIsNotInstanceOfModelException("{$modelClass} class is not instance of Model");
        }
        
        /** @var Model */
        $model = new static::$modelClass;
        foreach ($properties as $key => $value) {
            $model->$key = $value;
        }
        $model->save();
        $this->afterCreate($model);
        return $model->fresh();
    }

    protected function afterCreate(Model $model): void
    {
        // May be implemented in child class
    }
}
