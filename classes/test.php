<?php
$path=["static", "html" ,"test.html" ];
if (file_exists('../static/' . $path[1] . '/' . $path[2]))
    echo "exista\n";
if (file_exists('../static/html/test.html'))
    echo "exista\n";
