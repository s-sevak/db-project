<?php

interface UserRepositoryInterface
{
public function getUsers(): array;
public function saveUsers(array $users): void;
public function deleteUser(int $id): void;
}
