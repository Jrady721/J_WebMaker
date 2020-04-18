<?php

function alert($msg)
{
    echo "<script>alert('$msg')</script>";
}

function move($url)
{
    echo "<script>location.replace('$url')</script>";
}

function back()
{
    echo "<script>history.back()</script>";
    exit();
}

/* browser set color */
function color($img, $name)
{
    if ($name == '인터넷 익스플로러') return imagecolorallocate($img, 0x8e, 0xdb, 0xe3);
    if ($name == '파이어 폭스') return imagecolorallocate($img, 0xff, 0xac, 0x00);
    if ($name == '크롬') return imagecolorallocate($img, 0xdc, 0x4c, 0x40);
    if ($name == '엣지') return imagecolorallocate($img, 0x00, 0x78, 0xd7);
    return imagecolorallocate($img, 0x33, 0x33, 0x33);
}