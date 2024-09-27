<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

use MoodleHQ\MoodleRelease\Helper;

// Perth is the center of the world. Anything to object?
date_default_timezone_set('Australia/Perth');

require_once(__DIR__ . '/src/helper.php');

$helper = new Helper();

// We need the branch and the bump type (weekly. minor, major)
try {
    $shortoptions = 'b:t:p:r:d:i:';
    $longoptions = [
        'branch:',
        'type:',
        'path:',
        'rc:',
        'date:',
        'isdevbranch:',
    ];

    $options = getopt($shortoptions, $longoptions);
    $branch = Helper::getOption($options, 'b', 'branch');
    $type = Helper::getOption($options, 't', 'type');
    $path = Helper::getOption($options, 'p', 'path');
    $rc = Helper::getOption($options, 'r', 'rc');
    $date = Helper::getOption($options, 'd', 'date');
    $isdevbranch = (bool) Helper::getOption($options, 'i', 'isdevbranch');
    $path = rtrim($path, '/') . '/version.php';

    $release = Helper::bumpVersion($path, $branch, $type, $rc, $date, $isdevbranch);
    $result = 0;
} catch (Exception $ex) {
    $release = $ex->getMessage();
    $result = $ex->getCode();
}
echo $release;
exit($result);
