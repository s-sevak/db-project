<?php

interface CommandInterface
{
    public function execute(...$params): void;
}
