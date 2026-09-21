<?php

interface Middleware
{
    public function handle(string ...$args): void;
}
