<?php

function darkTheme()
{
    return isset($_COOKIE["dark_theme"]);
}

//color code must be "ffffff", not "#ffffff"
function getDarkThemeColor($hexColor, $lightestHexColor, $darkestHexColor)
{
    $rgb = hexToRGB($hexColor);
    $darkRGB = hexToRGB($darkestHexColor);
    $lightRGB = hexToRGB($lightestHexColor);
    $hsl = rgbToHsl($rgb[0], $rgb[1], $rgb[2]);
    $lighthsl = rgbToHsl($lightRGB[0], $lightRGB[1], $lightRGB[2]);
    $darkhsl = rgbToHsl($darkRGB[0], $darkRGB[1], $darkRGB[2]);
    $lum = 1 - $hsl[2];
    $haloLum = 1 - $lighthsl[2];
    $themeBackLum = $darkhsl[2];
    if ($lum < $haloLum) {
        $newRGB = hslToRgb($hsl[0], $hsl[1], $themeBackLum * $lum / $haloLum);
        return byteToHexString($newRGB[0]) . byteToHexString($newRGB[1]) . byteToHexString($newRGB[2]);
    } else {
        $newRGB = hslToRgb($hsl[0], $hsl[1], (1 - $themeBackLum) * ($lum - 1) / (1 - $haloLum) + 1);
        return byteToHexString($newRGB[0]) . byteToHexString($newRGB[1]) . byteToHexString($newRGB[2]);
    }
}
function byteToHexString($byte)
{
    $str = dechex($byte);
    return strlen($str) == 1 ? "0$str" : $str;
}
function hexToRGB($hexColor)
{
    return array(
        hexdec(substr($hexColor, 0, 2)),
        hexdec(substr($hexColor, 2, 2)),
        hexdec(substr($hexColor, 4, 2))
    );
}
//source : https://gist.github.com/brandonheyer/5254516
function rgbToHsl($r, $g, $b)
{
    $oldR = $r;
    $oldG = $g;
    $oldB = $b;

    $r /= 255;
    $g /= 255;
    $b /= 255;

    $max = max($r, $g, $b);
    $min = min($r, $g, $b);

    $h = 0;
    $s = 0;
    $l = ($max + $min) / 2;
    $d = $max - $min;

    if ($d == 0) {
        $h = $s = 0; // achromatic
    } else {
        $s = $d / (1 - abs(2 * $l - 1));

        switch ($max) {
            case $r:
                $h = 60 * fmod((($g - $b) / $d), 6);
                if ($b > $g) {
                    $h += 360;
                }
                break;

            case $g:
                $h = 60 * (($b - $r) / $d + 2);
                break;

            case $b:
                $h = 60 * (($r - $g) / $d + 4);
                break;
        }
    }

    return array(round($h, 2), round($s, 2), round($l, 2));
}
//source : https://gist.github.com/brandonheyer/5254516
function hslToRgb($h, $s, $l)
{
    $r = 0;
    $g = 0;
    $b = 0;

    $c = (1 - abs(2 * $l - 1)) * $s;
    $x = $c * (1 - abs(fmod(($h / 60), 2) - 1));
    $m = $l - ($c / 2);

    if ($h < 60) {
        $r = $c;
        $g = $x;
        $b = 0;
    } else if ($h < 120) {
        $r = $x;
        $g = $c;
        $b = 0;
    } else if ($h < 180) {
        $r = 0;
        $g = $c;
        $b = $x;
    } else if ($h < 240) {
        $r = 0;
        $g = $x;
        $b = $c;
    } else if ($h < 300) {
        $r = $x;
        $g = 0;
        $b = $c;
    } else {
        $r = $c;
        $g = 0;
        $b = $x;
    }

    $r = ($r + $m) * 255;
    $g = ($g + $m) * 255;
    $b = ($b + $m) * 255;

    return array(floor($r), floor($g), floor($b));
}
