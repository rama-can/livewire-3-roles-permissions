<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserService
{
    public function create(array $data);
    public function update(string $id, array $data);
    public function delete(string $id);
}
