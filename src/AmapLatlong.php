<?php

namespace Encore\AmapLatlong;

use Encore\Admin\Extension;
use Encore\Admin\Admin;

class AmapLatlong extends Extension
{
    public $name = 'amap-latlong';

    public $views = __DIR__ . '/../resources/views';
    /**
     * @var array
     */
    protected static $providers = [
        'amap'    => Map\Amap::class,
    ];

    /**
     * @var Map\AbstractMap
     */
    protected static $provider;

    /**
     * @param string $name
     * @return Map\AbstractMap
     */
    public static function getProvider($name = '')
    {
        if (static::$provider) {
            return static::$provider;
        }

        $name = AmapLatlong::config('default', $name);
        $args = AmapLatlong::config("providers.$name", []);

        return static::$provider = new static::$providers[$name](...array_values($args));
    }

    /**
     * @return \Closure
     */
    public static function showField()
    {
        return function ($lat, $lng, $height = 300, $zoom = 16) {

            return $this->unescape()->as(function () use ($lat, $lng, $height, $zoom) {

                $lat = $this->{$lat};
                $lng = $this->{$lng};
                $id = ['lat' => 'lat', 'lng' => 'lng'];
                Admin::script(AmapLatlong::getProvider()
                    ->setParams([
                        'zoom' => $zoom
                    ])
                    ->applyScript($id));

                return <<<HTML
<div class="row">
    <div class="col-md-3">
        <input id="{$id['lat']}" class="form-control" value="{$lat}"/>
    </div>
    <div class="col-md-3">
        <input id="{$id['lng']}" class="form-control" value="{$lng}"/>
    </div>
</div>

<br>

<div id="map_{$id['lat']}{$id['lng']}" style="width: 100%;height: {$height}px"></div>
HTML;
            });
        };
    }
}
