<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive("clientdata", function ($expression) {
            return '<input type="hidden" name="itshost" value="<?=$_SERVER[\'HTTP_HOST\'];?>">
                <?php
                $urlnow = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
                $a = explode("?", $urlnow);
                $site = $a[0];
                ?>
                <input type="hidden" name="site"        value="<?php echo $site; ?>">
                <input type="hidden" name="type"        value="<?php echo session("type"); ?>">
                <input type="hidden" name="from"        value="<?php echo  session("from"); ?>">
                <input type="hidden" name="issearch"    value="<?php echo  session("issearch"); ?>">
                <input type="hidden" name="utm_term"    value="<?php echo  session("utm_term");?>">
                <input type="hidden" name="ip_lida"     value="<?php echo $_SERVER["REMOTE_ADDR"];?>">
                <input type="hidden" name="url"         value="<?php echo $urlnow; ?>">
                <input type="hidden" name="utm_keyword" value="<?php echo  session("utm_keyword");?>">
                <input type="hidden" name="utm_term"    value="<?php echo  session("utm_term");?>">';
        });
    }
}
