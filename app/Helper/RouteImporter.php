<?php

namespace App\Helper;

Class RouteImporter
{
    /**
     * Returns file path containing route
     *
     * @param $path
     * @return string
     */
    static public function getRouteFilePath($path): string
    {
        return base_path() . '\\routes\\container\\' . $path . '.php';
    }
}
