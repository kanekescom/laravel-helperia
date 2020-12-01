<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('abort_if_auth_polymorphic')) {
    /**
     * Get abort if user auth polymorphic is doesn't match
     *
     * @return object
     */
    function abort_if_auth_polymorphic($model, $polymorphicAttribute, $className = null)
    {
        if ($className) {
            $auth = auth_polymorphic($className);
        } else {
            $auth = auth()->user();
            $className = get_class(auth()->user());
        }

        $polymorphicAttributeId = "{$polymorphicAttribute}_id";
        $polymorphicAttributeType = "{$polymorphicAttribute}_type";

        if ($auth->exists) {
            return abort_if(
                $model->$polymorphicAttributeId !== $auth->id
                    || $model->$polymorphicAttributeType !== $className,
                404
            );
        }
    }
}

if (!function_exists('active_route')) {
    /**
     * Add class if the given route is the current route.
     *
     * @param  string  $routes
     * @param  string  $activeClass
     * @return string
     */
    function active_route($routes, $activeClass = 'active')
    {
        return current_route($routes) ? $activeClass : '';
    }
}

if (!function_exists('active_route_ends_with')) {
    /**
     * Add class if the given route is the end of the current route.
     *
     * @param  string  $routes
     * @param  string  $activeClass
     * @return string
     */
    function active_route_ends_with($routes, $activeClass = 'active')
    {
        return route_ends_with($routes) ? $activeClass : '';
    }
}

if (!function_exists('active_route_starts_with')) {
    /**
     * Add class if the given route is the beginning of the current route.
     *
     * @param  string  $routes
     * @param  string  $activeClass
     * @return string
     */
    function active_route_starts_with($routes, $activeClass = 'active')
    {
        return route_starts_with($routes) ? $activeClass : '';
    }
}

if (!function_exists('active_route_resources')) {
    /**
     * Add class if the given route is a resources of the current route.
     *
     * @param  string  $routeResources
     * @param  string  $activeClass
     * @return string
     */
    function active_route_resources($routeResources, $activeClass = 'active')
    {
        foreach ((array) $routeResources as $routeResource) {
            $resources = [
                "{$routeResource}.index",
                "{$routeResource}.create",
                "{$routeResource}.show",
                "{$routeResource}.edit",
            ];

            foreach ($resources as $resource) {
                if (current_route($resource)) {
                    return $activeClass;

                    break;
                }
            }
        }

        return '';
    }
}

if (!function_exists('active_route_or_starts_with')) {
    /**
     * Add class if the given route is the beginning of the current route.
     *
     * @param  string  $routes
     * @param  string  $activeClass
     * @return string
     */
    function active_route_or_starts_with($routes, $activeClass = 'active')
    {
        return current_route($routes) || route_starts_with($routes) ? $activeClass : '';
    }
}

if (!function_exists('auth_polymorphic')) {
    /**
     * Get user auth polymorphic
     *
     * @return object
     */
    function auth_polymorphic($className)
    {
        $class = new $className;

        return auth()->user()->userable_type == $className
            && optional($class::find(auth()->user()->userable_id))->exists()
            ? optional(auth()->user()->userable)
            : optional();
    }
}

if (!function_exists('avatar')) {
    /**
     * Get avatar from https://ui-avatars.com
     *
     * @param  array   $settings
     * @return string
     */
    function avatar(array $settings)
    {
        return url('https://ui-avatars.com/api/?' . http_build_query($settings));
    }
}

if (!function_exists('currency_format')) {
    /**
     * Generate currency format
     *
     * @param  string  $name
     * @return string
     */
    function currency_format(float $currency)
    {
        $format = numfmt_create(config('app.locale'), NumberFormatter::CURRENCY);

        return numfmt_format_currency($format, $currency, config('app.currency'));
    }
}

if (!function_exists('current_route')) {
    /**
     * Determine if the given route is the current route.
     *
     * @param  string  $routes
     * @return bool
     */
    function current_route($routes)
    {
        foreach ((array) $routes as $route) {
            if ((string) $route !== '' && $route === Route::currentRouteName()) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('current_route_label')) {
    /**
     * Get current route language.
     *
     * @return string
     */
    function current_route_lang()
    {
        return __('routes.' . Route::currentRouteName());
    }
}

if (!function_exists('image_or_placeholder')) {
    /**
     * Determine if the given url is url or not and get over by placeholder.
     *
     * @param  string  $url
     * @param  string  $size
     * @param  string  $text
     * @return string
     */
    function image_or_placeholder($url = null, $size = 100, $text = null)
    {
        return $url ?? image_placeholder($size = 100, $text = null);
    }
}

if (!function_exists('image_placeholder')) {
    /**
     * Get image placeholder by via.placeholder.com.
     *
     * @param  string  $size
     * @param  string  $text
     * @return string
     */
    function image_placeholder($size = 100, $text = null)
    {
        return "https://via.placeholder.com/{$size}?text={$text}";
    }
}

if (!function_exists('image_placeholder_app')) {
    /**
     * Get image placeholder app.
     *
     * @param  string  $size
     * @param  string  $text
     * @return string
     */
    function image_placeholder_app($size = 100)
    {
        return "https://via.placeholder.com/{$size}?text=" . config('app.name');
    }
}

if (!function_exists('last_media')) {
    /**
     * Get last media by spatie/laravel-medialibrary
     *
     * @param  string  $model
     * @param  string  $collection
     * @return string
     */
    function last_media($model, $collection = null)
    {
        return optional($model->getMedia($collection)->last());
    }
}

if (!function_exists('media_or_placeholder')) {
    /**
     * Get first media by spatie/laravel-medialibrary or placeholder
     *
     * @param  string  $model
     * @param  string  $collection
     * @return string
     */
    function media_or_placeholder($model, $collection = null, $size = 100, $text = null)
    {
        if ($media_url = optional($model->getMedia($collection)->first())->getUrl()) {
            return $media_url;
        }

        return image_placeholder($size, $text);
    }
}

if (!function_exists('password_by_name')) {
    /**
     * Generate password by name
     *
     * @param  string  $name
     * @return string
     */
    function password_by_name(string $name)
    {
        $name = \Illuminate\Support\Str::of($name)->lower()->explode(' ');
        $password = \Illuminate\Support\Arr::first($name);

        return $password;
    }
}

if (!function_exists('route_ends_with')) {
    /**
     * Determine if the given route is the end of the current route.
     *
     * @param  string  $routes
     * @return bool
     */
    function route_ends_with($routes)
    {
        foreach ((array) $routes as $route) {
            if ((string) $route !== '' && Str::endsWith(Route::currentRouteName(), ".{$routes}")) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('route_starts_with')) {
    /**
     * Determine if the given route is the beginning of the current route.
     *
     * @param  string  $routes
     * @return bool
     */
    function route_starts_with($routes)
    {
        foreach ((array) $routes as $route) {
            if ((string) $route !== '' && Str::startsWith(Route::currentRouteName(), "{$route}.")) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('storage_delete')) {
    /**
     * Delete file using storage.
     *
     * @param  string  $filePath
     * @return bool
     */
    function storage_delete($filePath)
    {
        return Storage::delete($filePath);
    }
}
