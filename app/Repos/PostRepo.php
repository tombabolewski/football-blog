<?php

namespace App\Repos;

use App\Models\Post;
use App\Models\User;

class PostRepo extends BaseRepo
{
    protected static string $modelClass = Post::class;

    public function createForUser(array $properties, User $user): Post
    {
        $properties['user_id'] = $user->id;
        return $this->create($properties);
    }
}
