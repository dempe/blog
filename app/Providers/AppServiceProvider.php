<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use ParsedownExtra;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('markdown', function () {
           return "<?php ob_start(); ?>";
        });

        Blade::directive('endmarkdown', function () {
/*            return "<?php echo ob_get_clean();?>";*/
//            return "<?php
//                        \$pd = new ParsedownExtra();
//                        \$pd->setSafeMode(false);  // Disable automatic pre/code block wrapping
//                        echo \$pd->text(trim(ob_get_clean()));
/*                    ?>";*/


            return "<?php
                \$content = ob_get_clean();
                // Normalize the indentation
                \$content = preg_replace('/^[ \\t]+/m', '', \$content);
                \$pd = new ParsedownExtra();
                \$pd->setSafeMode(false);  // Disable pre/code wrapping
                echo \$pd->text(\$content);
            ?>";
        });

    }
}

