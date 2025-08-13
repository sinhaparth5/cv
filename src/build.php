<?php
/**
 * Build Script - Automatically generates minified CSS and JS files
 * Run this script to create main.min.css and main.min.js
 */

class AssetMinifier {
    private $baseDir;
    
    public function __construct() {
        $this->baseDir = __DIR__;
    }
    
    public function minifyCSS($css) {
        // Remove comments
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        
        // Remove unnecessary whitespace
        $css = str_replace(["\r\n", "\r", "\n", "\t"], '', $css);
        $css = preg_replace('/\s+/', ' ', $css);
        
        // Remove space around specific characters
        $css = str_replace([' {', '{ ', ' }', '} ', ': ', ' :', '; ', ' ;', ', ', ' ,'], 
                          ['{', '{', '}', '}', ':', ':', ';', ';', ',', ','], $css);
        
        // Remove trailing semicolon before closing brace
        $css = str_replace(';}', '}', $css);
        
        return trim($css);
    }
    
    public function minifyJS($js) {
        // Remove single line comments (but preserve URLs)
        $js = preg_replace('/(?<!:)\/\/.*$/m', '', $js);
        
        // Remove multi-line comments
        $js = preg_replace('/\/\*[\s\S]*?\*\//', '', $js);
        
        // Remove unnecessary whitespace
        $js = preg_replace('/\s+/', ' ', $js);
        
        // Remove space around operators and punctuation
        $patterns = [
            '/\s*([{}();,=+\-*\/&|!<>])\s*/' => '$1',
            '/\s*:\s*/' => ':',
            '/;\s*/' => ';',
            '/,\s*/' => ',',
        ];
        
        foreach ($patterns as $pattern => $replacement) {
            $js = preg_replace($pattern, $replacement, $js);
        }
        
        return trim($js);
    }
    
    public function buildCSS() {
        $cssFile = $this->baseDir . '/assets/css/style.css';
        $minifiedFile = $this->baseDir . '/assets/css/style.min.css';
        
        if (!file_exists($cssFile)) {
            echo "❌ CSS file not found: $cssFile\n";
            return false;
        }
        
        $css = file_get_contents($cssFile);
        $minifiedCSS = $this->minifyCSS($css);
        
        // Create directory if it doesn't exist
        $dir = dirname($minifiedFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $result = file_put_contents($minifiedFile, $minifiedCSS);
        
        if ($result !== false) {
            $originalSize = strlen($css);
            $minifiedSize = strlen($minifiedCSS);
            $savings = round((($originalSize - $minifiedSize) / $originalSize) * 100, 1);
            
            echo "✅ CSS minified successfully!\n";
            echo "   Original: " . number_format($originalSize) . " bytes\n";
            echo "   Minified: " . number_format($minifiedSize) . " bytes\n";
            echo "   Saved: {$savings}%\n\n";
            return true;
        } else {
            echo "❌ Failed to write minified CSS file\n";
            return false;
        }
    }
    
    public function buildJS() {
        $jsFile = $this->baseDir . '/assets/js/app.js';
        $minifiedFile = $this->baseDir . '/assets/js/app.min.js';
        
        if (!file_exists($jsFile)) {
            echo "❌ JS file not found: $jsFile\n";
            return false;
        }
        
        $js = file_get_contents($jsFile);
        $minifiedJS = $this->minifyJS($js);
        
        // Create directory if it doesn't exist
        $dir = dirname($minifiedFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $result = file_put_contents($minifiedFile, $minifiedJS);
        
        if ($result !== false) {
            $originalSize = strlen($js);
            $minifiedSize = strlen($minifiedJS);
            $savings = round((($originalSize - $minifiedSize) / $originalSize) * 100, 1);
            
            echo "✅ JS minified successfully!\n";
            echo "   Original: " . number_format($originalSize) . " bytes\n";
            echo "   Minified: " . number_format($minifiedSize) . " bytes\n";
            echo "   Saved: {$savings}%\n\n";
            return true;
        } else {
            echo "❌ Failed to write minified JS file\n";
            return false;
        }
    }
    
    public function build() {
        echo "🚀 Starting build process...\n\n";
        
        $cssSuccess = $this->buildCSS();
        $jsSuccess = $this->buildJS();
        
        if ($cssSuccess && $jsSuccess) {
            echo "🎉 Build completed successfully!\n";
            echo "Files created:\n";
            echo "  - assets/styles/style.min.css\n";
            echo "  - assets/js/app.min.js\n";
        } else {
            echo "⚠️  Build completed with errors.\n";
        }
    }
    
    public function watch() {
        echo "👀 Watching for file changes...\n";
        echo "Press Ctrl+C to stop.\n\n";
        
        $cssFile = $this->baseDir . '/assets/css/style.css';
        $jsFile = $this->baseDir . '/assets/js/app.js';
        
        $lastCSSTime = file_exists($cssFile) ? filemtime($cssFile) : 0;
        $lastJSTime = file_exists($jsFile) ? filemtime($jsFile) : 0;
        
        while (true) {
            $currentCSSTime = file_exists($cssFile) ? filemtime($cssFile) : 0;
            $currentJSTime = file_exists($jsFile) ? filemtime($jsFile) : 0;
            
            if ($currentCSSTime > $lastCSSTime) {
                echo "📝 CSS file changed, rebuilding...\n";
                $this->buildCSS();
                $lastCSSTime = $currentCSSTime;
            }
            
            if ($currentJSTime > $lastJSTime) {
                echo "📝 JS file changed, rebuilding...\n";
                $this->buildJS();
                $lastJSTime = $currentJSTime;
            }
            
            sleep(1); // Check every second
        }
    }
}

// Auto-build integration for index.php
function autoBuildAssets() {
    $cssFile = __DIR__ . '/assets/css/style.css';
    $jsFile = __DIR__ . '/assets/js/app.js';
    $minCSSFile = __DIR__ . '/assets/css/style.min.css';
    $minJSFile = __DIR__ . '/assets/js/app.min.js';
    
    $needsRebuild = false;
    
    // Check if minified files exist
    if (!file_exists($minCSSFile) || !file_exists($minJSFile)) {
        $needsRebuild = true;
    }
    
    // Check if source files are newer than minified files
    if (file_exists($cssFile) && file_exists($minCSSFile)) {
        if (filemtime($cssFile) > filemtime($minCSSFile)) {
            $needsRebuild = true;
        }
    }
    
    if (file_exists($jsFile) && file_exists($minJSFile)) {
        if (filemtime($jsFile) > filemtime($minJSFile)) {
            $needsRebuild = true;
        }
    }
    
    if ($needsRebuild) {
        $minifier = new AssetMinifier();
        $minifier->build();
    }
}

// CLI usage
if (php_sapi_name() === 'cli') {
    $minifier = new AssetMinifier();
    
    if (isset($argv[1])) {
        switch ($argv[1]) {
            case 'watch':
                $minifier->watch();
                break;
            case 'css':
                $minifier->buildCSS();
                break;
            case 'js':
                $minifier->buildJS();
                break;
            default:
                echo "Usage: php build.php [watch|css|js]\n";
                echo "  watch - Watch for changes and auto-rebuild\n";
                echo "  css   - Build CSS only\n";
                echo "  js    - Build JS only\n";
                echo "  (no args) - Build all\n";
        }
    } else {
        $minifier->build();
    }
}
?>