<?php

class Controller
{
    protected function view(string $viewPath, array $data = []): void
    {
        extract($data);

        $filePath = __DIR__ . "/../views/{$viewPath}.php";
        $folderPath = dirname($viewPath);

        $file = $this->patternsExecute($filePath, $folderPath);

        $tempFile = preg_replace('/\.php$/', '.temp.php', $filePath);

        file_put_contents($tempFile, $file);

        include $tempFile;
        unlink($tempFile);
    }

    private function patternsExecute(string $filePath, string $folderPath): string
    {
        $fileContent = file_get_contents($filePath);

        $patterns = [
            "var" => '/\{\{\s*\$([A-Za-z][A-Za-z0-9]*)\s*\}\}/',
            "if-else" => '/\s*@if\s*\(\s*([^)]*\))\s*\)([^@]*)@?(else|endif)?([^@]*)@endif/',
            "if" => '/\s*@if\s*\(([^)]*)\)((?:[^@])*)@endif/',
            "function" => '/\{\{\s*([A-Za-z_][A-Za-z0-9_]*)\s*\(([^)]*)\)\s*\}\}/',
            "component" => '/<x-([A-Za-z][A-Za-z0-9_-]*)\s*\/>/',
            "session" => '/\{\{\s*\$_SESSION\[\'([A-Za-z_][A-Za-z0-9_]*)\'\]\s*\}\}/'
        ];

        $phpCodes = [
            "var" => "<?= \$$1'; ?>",
            "if-else" => '<?php if ($1): ?>$2<?php else: ?>$4<?php endif; ?>',
            "if" => '<?php if ($1): ?>$2<?php endif; ?>',
            "function" => "<?= $1($2); ?>",
            "session" => "<?= \$_SESSION['$1'] ?? ''; ?>"
        ];

        foreach ($patterns as $key => $pattern) {

            if ($key === 'component') {
                $fileContent = preg_replace_callback(
                    $pattern,
                    function ($matches) use ($folderPath) {
                        return $this->component($matches[1], $folderPath);
                    },
                    $fileContent
                );

                continue;
            }

            $fileContent = preg_replace(
                $pattern,
                $phpCodes[$key],
                $fileContent
            );
        }

        return $fileContent;
    }

    private function component(string $component, string $path): string
    {
        if (file_exists(__DIR__ . "/../views/components/{$component}.php")) {
            $componentPath = __DIR__ . "/../views/components/{$component}.php";
        } else {
            $componentPath = __DIR__ . "/../views/{$path}/components/{$component}.php";
        }

        return $this->patternsExecute($componentPath, $path);
    }
}
