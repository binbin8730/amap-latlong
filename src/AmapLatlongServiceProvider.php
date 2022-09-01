<?php

namespace Encore\AmapLatlong;

use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\Admin\Show;
use Illuminate\Support\ServiceProvider;

class AmapLatlongServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(AmapLatlong $extension)
    {
        if (!AmapLatlong::boot()) {
            return;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'amap-latlong');
        }

        Admin::booting(function () {
            Form::extend('amap_latlong', Latlong::class);
            Show\Field::macro('amap_atlong', AmapLatlong::showField());
        });
    }
}
