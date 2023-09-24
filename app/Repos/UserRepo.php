<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepo extends BaseRepo
{
    protected static string $model = User::class;

    public function afterCreate(Model $model): void 
    {
        dispatch(new UserCreatedEvent($model));
    }
}
