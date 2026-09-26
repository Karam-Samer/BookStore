<?php

class RegisterMiddleware implements Middleware
{
    public function handle(string ...$roles): void
    {
        if (isAuth("customer")) {
            redirect("/profile");
        }
    }
}
