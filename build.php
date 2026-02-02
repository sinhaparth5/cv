<?php
require_once __DIR__ . '/vendor/autoload.php';

use MatthiasMullie\Minify;
use ScssPhp\ScssPhp\Compiler;

echo "🔨 Building assets...\n";

if (!is_dir(__DIR__ . '/public/css')) {
    mkdir(__DIR__ . '/public/css', 0755, true);
}
if (!is_dir(__DIR__ . '/public/js')) {
    mkdir(__DIR__ . '/public/js', 0755, true);
}

echo "📝 Compiling SCSS...\n";
try {
    $scssFile = __DIR__ . '/assets/scss/main.scss';
    if (!file_exists($scssFile)) {
        throw new RuntimeException("SCSS file not found: $scssFile");
    }

    $scss = new Compiler();
    $scss->setOutputStyle(\ScssPhp\ScssPhp\OutputStyle::COMPRESSED);

    $scssContent = file_get_contents($scssFile);
    $compiledCss = $scss->compileString($scssContent)->getCss();
    
    $minifier = new Minify\CSS();
    $minifier->add($compiledCss);
    $minifiedCss = $minifier->minify();
    
    file_put_contents(__DIR__ . '/public/css/main.min.css', $minifiedCss);
    echo "✅ CSS compiled and minified\n";
} catch (Exception $e) {
    echo "❌ SCSS compilation failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "📦 Minifying JavaScript...\n";
try {
    $jsFile = __DIR__ . '/assets/js/main.js';
    if (!file_exists($jsFile)) {
        throw new RuntimeException("JavaScript file not found: $jsFile");
    }

    $minifier = new Minify\JS($jsFile);
    $minifiedJs = $minifier->minify();
    
    file_put_contents(__DIR__ . '/public/js/main.min.js', $minifiedJs);
    echo "✅ JavaScript minified\n";
} catch (Exception $e) {
    echo "❌ JavaScript minification failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "🎉 Build completed successfully!\n";
echo "📁 Assets created:\n";
echo "   - public/css/main.min.css (" . number_format(filesize(__DIR__ . '/public/css/main.min.css') / 1024, 2) . " KB)\n";
echo "   - public/js/main.min.js (" . number_format(filesize(__DIR__ . '/public/js/main.min.js') / 1024, 2) . " KB)\n";