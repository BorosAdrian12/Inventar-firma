<?php
class RouterController extends Controller
{
    protected $controller;
    public function process($params)
    {
        $parsedUrl = $this->parseUrl($params[0]);
    }
    private function parseUrl($url)
    {
        $parsedUrl = parse_url($url);
        $parsedUrl["path"] = ltrim($parsedUrl["path"], "/");
        $parsedUrl["path"] = trim($parsedUrl["path"]);
        $explodedUrl = explode("/", $parsedUrl["path"]);
        return $explodedUrl;
    }
}
