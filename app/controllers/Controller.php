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
            "var" => '/\{\{\s*\$([^}]*)\s*\}\}/',
            "if-elseif-else" => '/\s*@if\s*\(\s*([^)]*\))\s*\)([^@]*)@else\s+if\s*\(\s*([^)]*\))\s*\)\s*([^@]*)@else\s*([^@]*)@endif/',
            "if-else" => '/\s*@if\s*\(\s*([^)]*?\)*)\s*\)([^@]*)@else([^@]*)@endif/',
            "if" => '/\s*@if\s*\(([^)]*)\)([^@]*)@endif/',
            "for" => '/\s*@for\s*\(\s*([^)]*)\s*\)\s*([^@]*)@endfor/',
            "foreach" => '/\s*@foreach\s*\(\s*(.*)\s*\)\s*([^@]*)@endforeach/',
            "function" => '/\{\{\s*([A-Za-z_][A-Za-z0-9_]*)\s*\(([^)]*)\)\s*\}\}/',
            "component" => '/<x-([A-Za-z][A-Za-z0-9_-]*)\s*\/>/',
            "empty-else" => '/@empty\s*\(([^)]*)\)\s*((?:(?!@else)[\s\S])*)@else\s*([^@]*)@endempty/',
        ];

        $phpCodes = [
            "var" => "<?= \\$$1; ?>",
            "if-elseif-else" => '<?php if ($1): ?>$2<?php elseif ($3): ?>$4<?php else: ?>$5<?php endif; ?>',
            "if-else" => '<?php if ($1): ?>$2<?php else: ?>$3<?php endif; ?>',
            "if" => '<?php if ($1): ?>$2<?php endif; ?>',
            "for" => '<?php for ($1): ?>$2<?php endfor; ?>',
            "foreach" => '<?php foreach ($1): ?>$2<?php endforeach; ?>',
            "function" => "<?= $1($2); ?>",
            "empty-else" => '<?php if (empty($1)): ?>$2<?php else: ?>$3<?php endif; ?>',
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
        // pr("/../views/{$path}/components/{$component}.php", true);
        if (file_exists(__DIR__ . "/../views/components/{$component}.php")) {
            $componentPath = __DIR__ . "/../views/components/{$component}.php";
        } else {
            $componentPath = __DIR__ . "/../views/{$path}/components/{$component}.php";
        }

        return $this->patternsExecute($componentPath, $path);
    }
}
