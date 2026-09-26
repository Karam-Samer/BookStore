<?php

class GuestMiddleware implements Middleware
{
    public function handle(string ...$roles): void
    {
        if (isset($_SESSION['user'])) {
            redirect("/profile");
        }
    }
}
