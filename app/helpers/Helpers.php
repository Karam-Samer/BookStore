<?php

function pr(mixed $data, bool $die = false): void
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";

    if ($die) {
        exit;
    }
}

function asset(string $path): string
{
    return BASE_URL . "/assets/" . ltrim($path, "/");
}

function old(string $key, mixed $default = ""): mixed
{
    $oldValue = $_SESSION['_old'][$key] ?? $default;
    unset($_SESSION['_old'][$key]);
    return $oldValue;
}

function oldSelect(string $key, mixed $value, bool $unset = false): string
{
    $oldValue = old($key);

    if ($unset) {
        unset($_SESSION['old'][$key]);
    }

    return ($oldValue == $value) ? "selected" : "";
}

function redirect(string $path): void
{
    $url = BASE_URL . $path;
    header("Location: {$url}");
    exit;
}

function route(string $path): string
{
    return BASE_URL . $path;
}

function isAuth(?string $role = null): bool
{
    if (!isset($_SESSION['user'])) {
        return false;
    }

    if ($role === null) {
        return true;
    }

    return ($_SESSION['user']['role'] ?? null) === $role;
}

function auth(?string $key = null): mixed
{
    $user = $_SESSION['user'] ?? null;

    if ($key === null) {
        return $user;
    }

    return $user[$key] ?? null;
}


function isGuest(): bool
{
    return !isAuth();
}

function back(?string $key = null, string $msg = ""): void
{
    $path = $_SERVER['HTTP_REFERER'];

    if ($key !== null) {
        $_SESSION[$key] = $msg;
    }
    header("Location: {$path}");
    exit;
}

function getError(string | array $key)
{
    $html = "";

    if (isset($_SESSION['_errors'][$key])) {
        $html = "<p class='alert alert-danger mt-2'>{$_SESSION['_errors'][$key][0]}</p>";
        unset($_SESSION['_errors'][$key]);
    }

    return $html;
}
function getSessionMsg(string $key, string $alertName = "success"): string
{
    $html = "";

    if (isset($_SESSION[$key])) {
        $html = "<p class='alert alert-{$alertName} mt-2'>{$_SESSION[$key]}</p>";
        unset($_SESSION[$key]);
    }

    return $html;
}

function preparePagination(int $totalPages, int $currentPage, string $type): string
{
    if ($totalPages <= 1) {
        return "";
    }
    $prepareLi = "";

    $nextPage = ($currentPage < $totalPages) ? $currentPage + 1 : $totalPages;
    $isNextDisabled = ($currentPage >= $totalPages) ? "disabled" : "";

    $prevPage = ($currentPage > 1) ? $currentPage - 1 : 1;
    $isPrevDisabled = ($currentPage <= 1) ? "disabled" : "";

    $profileLink = route("/profile");

    for ($i = 1; $i <= $totalPages; $i++) {
        $isActive = ($i == $currentPage) ? "active" : "";
        $prepareLi .= "<li class='page-item {$isActive}'><a class='page-link' href='{$profileLink}?{$type}-page={$i}'>{$i}</a></li>";
    }

    $pagination = "<nav aria-label='Page navigation example'>
                    <ul class='pagination'>
                        <li class='page-item {$isPrevDisabled}'>
                            <a class='page-link' href='{$profileLink}?{$type}-page={$prevPage}'>Previous</a>
                        </li>
                        {$prepareLi}
                        <li class='page-item {$isNextDisabled}'>
                            <a class='page-link' href='{$profileLink}?{$type}-page={$nextPage}'>Next</a>
                        </li>
                    </ul>
                </nav>";

    return $pagination;
}


function authorBio(string $bio): string
{
    return (strlen($bio) > 100) ? substr($bio, 0, 100) . "..." : $bio;
}