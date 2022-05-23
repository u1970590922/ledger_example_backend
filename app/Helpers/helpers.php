<?php

if (!function_exists('filter_fields')) {
    /**
     * @param  $array
     * @param  string|array  $keys
     * @return array
     */
    function filter_fields($array, string|array $keys): array
    {
        if (is_string($keys)) {
            $keys = [$keys];
        }

        return collect($array)->only($keys)->toArray();
    }
}

if (!function_exists('remove_fields')) {
    /**
     * @param  $array
     * @param  string|array  $keys
     * @return array
     */
    function remove_fields($array, string|array $keys): array
    {
        if (is_string($keys)) {
            $keys = [$keys];
        }

        return collect($array)->except($keys)->toArray();
    }
}

if (!function_exists('enum_values')) {
    function enum_values(string $enum): array
    {
        return array_column($enum::cases(), 'value');
    }
}