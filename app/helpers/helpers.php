<?php

/**
 * @param $data
 * @return array
 * trims input
 */
function validateInput($data) : array
{
    $new_data = array();
    foreach($data as $key => $value){
        $new_data[$key] = htmlspecialchars(strip_tags($value));
    }
    return $new_data;
}

/**
 * @param $data
 * @param $required
 * @return array
 * validates inputs
 */
function requiredFields($data, $required): array
{
    $field = array();
    foreach ($required as $i => $value){
        if(!isset($data[$value]) || $data[$value] === ""){
            $field[$value] = 'This field is required';
        }
    }
    return $field;
}

/**
 * @param $tile
 * @param $tile_array
 * @return bool
 * check if tile is  valid tile i.e 44 is not a valid tile but 11, 12 are valid tiles
 */
function validTile($tile, $tile_array) : bool
{
    if(!in_array($tile, $tile_array)) {
        return false;
    }
    return true;
}

/**
 * @param $positions
 * @param $current
 * @return bool
 * returns true if user has a tile that fills a vertical space
 */
function isVerticalWin($positions, $current): bool
{
    $mod = $current % 10;
    return (in_array($mod + 10, $positions) &&
        in_array($mod + 20,  $positions) &&
        in_array($mod + 10,  $positions));
}

/**
 * @param $positions
 * @param $current
 * @return bool
 * * returns true if user has a tile that fills a horizontal space
 */
function isHorizontalWin($positions, $current): bool
{
    $mod = round((int)$current / 10);
    return (in_array(($mod * 10) + 1, $positions) &&
        in_array(($mod * 10) + 2,  $positions) &&
        in_array(($mod * 10) + 3,  $positions));
}

/**
 * @param $positions
 * @return bool
 * * returns true if user has a tile that fills a diagonal space
 */
function isDiagonalWin($positions): bool
{
    if((in_array(11, $positions) && in_array(22,  $positions) && in_array(33,  $positions)) ||
      (in_array(13, $positions) && in_array(22,  $positions) && in_array(31,  $positions)) ){
        return true;
    }
    return false;
}

