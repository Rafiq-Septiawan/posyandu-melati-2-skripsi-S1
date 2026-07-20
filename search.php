<?php
function search($dir, $pattern) {
    if (!is_dir($dir)) return;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && in_array($file->getExtension(), ['php', 'js', 'css', 'html'])) {
            $content = file_get_contents($file->getPathname());
            if (stripos($content, $pattern) !== false) {
                $lines = explode("\n", $content);
                foreach ($lines as $lineNum => $line) {
                    if (stripos($line, $pattern) !== false) {
                        $relPath = str_replace(realpath(__DIR__) . DIRECTORY_SEPARATOR, '', $file->getRealPath());
                        echo "$relPath:" . ($lineNum + 1) . ": " . trim($line) . "\n";
                    }
                }
            }
        }
    }
}

$pattern = isset($argv[1]) ? $argv[1] : 'admin';
echo "Searching for '$pattern'...\n";
search(realpath(__DIR__ . '/app'), $pattern);
search(realpath(__DIR__ . '/config'), $pattern);
search(realpath(__DIR__ . '/routes'), $pattern);
search(realpath(__DIR__ . '/resources/views'), $pattern);
