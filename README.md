高德经纬度选择器/Latitude and longitude selector
======
这个扩展是通过 laravel-admin-ext/latlong:1.x 进行二次开发！

只针对高德地图使用，只针对高德地图使用，只针对高德地图使用
修复了一些BUG

1、增加admin.php api_secret 参数
2、修改加载地图逻辑，升级到最新版本 1.4.15
3、修复默认没有添加坐标值，显示地图空白问题


## Configuration

打开 `config/admin.php` 增加 extensions 配置 :

```php

    'extensions' => [

        'amap-latlong' => [

            // Whether to enable this extension, defaults to true
            'enable' => true,

            // Specify the default provider
            'default' => 'amap',

            // According to the selected provider above, fill in the corresponding api_key
            'providers' => [
                'amap' => [
                    'api_key' => '',
                    'api_secret' => ''
                ],
            ],
        ]
    ]

```

## Usage

Suppose you have two fields `latitude` and `longitude` in your table that represent latitude and longitude, then use the following in the form:

```php
$form->amap_latlong('latitude', 'longitude', 'Position');

// Set the map height
$form->amap_latlong('latitude', 'longitude', 'Position')->height(500);

// Set the map zoom
$form->amap_latlong('latitude', 'longitude', 'Position')->zoom(16);

// Set default position
$form->amap_latlong('latitude', 'longitude', 'Position')->default(['lat' => 90, 'lng' => 90]);
```

Use in show page

```php
$show->field('Position')->amap_latlong('lat_column', 'long_column', $height = 400, $zoom = 16);
```

## Donate





