<?php

namespace App;

use MatthiasMullie\Minify;
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\OutputStyle;

class AssetManager {
    private string $publicPath;
    private string $cachePath;
    private string $scssPath;

    public function __construct() {
        $this->publicPath = 'public';
        $this->cachePath = $this->publicPath . '/cache';
        $this->scssPath = 'assets/scss';

        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0755, true);
        }
    }

    public function compileSCSS(array $scssFiles): string {
        $cacheFile = 'styles.min.css';
        $cachePath = $this->cachePath . '/' . $cacheFile;

        $compiler = new Compiler();
        $compiler->addImportPath($this->scssPath);
        $compiler->setOutputStyle(OutputStyle::COMPRESSED);

        $combinedScss = '';
        foreach ($scssFiles as $file) {
            $fullPath = $this->scssPath . '/' . $file;
            if (file_exists($fullPath)) {
                $combinedScss .= file_get_contents($fullPath) . "\n";
            }
        }

        try {
            $compiledCss = $compiler->compileString($combinedScss)->getCss();
            file_put_contents($cachePath, $compiledCss);
            return '/cache/' . $cacheFile . '?v=' . filemtime($cachePath);
        } catch (\Exception $e) {
            error_log('SCSS compilation error: ' . $e->getMessage());
            return '';
        }
    }

    public function minifyJS(array $files): string {
        $cacheFile = 'scripts.min.js';
        $cachePath = $this->cachePath . '/' . $cacheFile;

        $minifier = new Minify\JS();

        foreach ($files as $file) {
            $fullPath = 'public/assets/js/' . $file;
            if (file_exists($fullPath)) {
                $minifier->add($fullPath);
            }
        }

        $minified = $minifier->minify();
        file_put_contents($cachePath, $minified);

        return '/cache/' . $cacheFile . '?v=' . filemtime($cachePath);
    }
}
