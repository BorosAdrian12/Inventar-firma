<?php
class Util
{
    public static function parseUrl($url)
    {
        $urlAr = parse_url($url);
        $urlAr = parse_url($url);
        $urlAr["path"] = ltrim($urlAr["path"], "/");
        $urlAr["path"] = trim($urlAr["path"]);
        $explodedUrl = explode("/", $urlAr["path"]);
        return $explodedUrl;
    }
}
