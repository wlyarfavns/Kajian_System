<?php

function stripComments($filePath) {
    $tokens = token_get_all(file_get_contents($filePath));
    $output = '';
    
    foreach ($tokens as $token) {
        if (is_array($token)) {
            // Remove comments and doc comments
            if (in_array($token[0], [T_COMMENT, T_DOC_COMMENT])) {
                continue;
            }
            $output .= $token[1];
        } else {
            $output .= $token;
        }
    }

    // Remove extra blank lines that might be left over from deleted comments
    $output = preg_replace("/(^[\r\n]*|[\r\n]+)[ \t]*[\r\n]+/", "\n", $output);
    
    file_put_contents($filePath, $output);
}

if (isset($argv[1]) && is_dir($argv[1])) {
    $dir = $argv[1];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            stripComments($file->getPathname());
        }
    }
    echo "Directory stripped: $dir\n";
} elseif (isset($argv[1]) && is_file($argv[1])) {
    stripComments($argv[1]);
    echo "File stripped: {$argv[1]}\n";
} else {
    echo "Usage: php strip_comments.php <file_or_directory>\n";
}
