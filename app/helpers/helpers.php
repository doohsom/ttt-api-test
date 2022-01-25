<?php

function validateInput($data)
{
    $new_data = array();
    foreach($data as $key => $value){
        $new_data[$key] = htmlspecialchars(strip_tags($value));
    }
    return $new_data;
}

function requiredFields($data, $required)
{
    $field = array();
    foreach ($required as $i => $value){
        if(!isset($data[$value]) || $data[$value] === ""){
            $field[$value] = 'This field is required';
        }
    }
    return $field;
}

function validTile($tile, $tile_array)
{
    if(!in_array($tile, $tile_array)) {
        return false;
    }
    return true;
}

function isVerticalWin($positions, $current) {
    $mod = $current % 10;
    return (in_array($mod + 10, $positions) &&
        in_array($mod + 20,  $positions) &&
        in_array($mod + 10,  $positions));
}

function isHorizontalWin($positions, $current) {
    $mod = round((int)$current / 10);
    return (in_array(($mod * 10) + 1, $positions) &&
        in_array(($mod * 10) + 2,  $positions) &&
        in_array(($mod * 10) + 3,  $positions));
}

function isDiagonalWin($positions) {
    if((in_array(11, $positions) && in_array(22,  $positions) && in_array(33,  $positions)) ||
      (in_array(13, $positions) && in_array(22,  $positions) && in_array(31,  $positions)) ){
        return true;
    }
}

