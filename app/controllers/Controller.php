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
        // unlink($tempFile);
    }

    private function patternsExecute(string $filePath, string $folderPath): string
    {
        $fileContent = file_get_contents($filePath);
        $patterns = [
            "var" => '/\{\{\s*\$([^}]*)\s*\}\}/',
            "if" => '/\s*@if\s*\(\s*(.*?)\s*\)\s*$/m',
            "else" => '/\s*@else\s*$/m',
            "elseif" => '/\s*@else if\s*\(\s*(.*?)\s*\)\s*$/m',
            "for" => '/\s*@for\s*\(\s*(.*?)\s*\)\s*$/m',
            "endfor" => '/\s*@endfor\s*$/m',
            "foreach" => '/\s*@foreach\s*\(\s*(.*?)\s*\)\s*$/m',
            "endforeach" => '/\s*@endforeach\s*$/m',
            "function" => '/\{\{\s*(.*?)\s*\}\}/',
            "empty" => '/\s*@empty\s*\(\s*(.*?)\s*\)\s*$/m',
            "endempty" => '/\s*@endempty\s*$/m',
            "auth" => '/\s*@auth\s*(\(\s*(.*?)\s*\))?\s*$/m',
            "elseauth" => '/\s*@elseauth\s*(\(\s*(.*?)\s*\))\s*$/m',
            "endauth" => '/\s*@endauth\s*$/m',
            "endif" => '/\s*@endif\s*$/m',
            "component" => '/<x-([A-Za-z][A-Za-z0-9_-]*)\s*\/>/',


            // "if-elseif-else" => '/\s*@if\s*\(\s*([^)]*\))\s*\)([^@]*)@else\s+if\s*\(\s*([^)]*\))\s*\)\s*([^@]*)@else\s*([^@]*)@endif/',
            // "if-else" => '/\s*@if\s*\(\s*([^)]*?\)*)\s*\)([^@]*)@else([^@]*)@endif/',
            // "if" => '/\s*@if\s*\(([^)]*)\)([^@]*)@endif/',
            // "for" => '/\s*@for\s*\(\s*([^)]*)\s*\)\s*([^@]*)@endfor/',
            // "foreach" => '/\s*@foreach\s*\(\s*(.*)\s*\)\s*([^@]*)@endforeach/',
            // "function" => '/\{\{\s*([A-Za-z_][A-Za-z0-9_]*)\s*\(([^)]*)\)\s*\}\}/',
            // "empty-else" => '/@empty\s*\(([^)]*)\)\s*((?:(?!@else)[\s\S])*)@else\s*([^@]*)@endempty/',
        ];

        $phpCodes = [
            "var" => "<?= \\$$1; ?>",
            "if" => "<?php if ($1): ?>",
            "else" => "<?php else: ?>",
            "elseif" => "<?php elseif ($1): ?>",
            "endif" => "<?php endif; ?>",
            "for" => "<?php for ($1): ?>",
            "endfor" => "<?php endfor; ?>",
            "foreach" => "<?php foreach ($1): ?>",
            "endforeach" => "<?php endforeach; ?>",
            "function" => "<?php echo $1; ?>",
            "empty" => "<?php if (empty($1)): ?>",
            "endempty" => "<?php endif; ?>",
            "auth" => "<?php if (isAuth($2 ?? null)): ?>",
            "elseauth" => "<?php elseif (isAuth($2 ?? null)): ?>",
            "endauth" => "<?php endif; ?>",
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
