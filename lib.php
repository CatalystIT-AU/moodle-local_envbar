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

/**
 * Environment bar library.
 *
 * @package   local_envbar
 * @author    Grigory Baleevskiy (grigory@catalyst-au.net)
 * @author    Nicholas Hoobin <nicholashoobin@catalyst-au.net>
 * @copyright Catalyst IT
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * lib.php isn't always called, we need to hook something to ensure it runs.
 *
 * @param object $navigation
 * @param object $course
 * @param object $module
 * @param object $cm
 */
function local_envbar_extend_navigation($navigation, $course = null, $module = null, $cm = null) {

    // Why is this even being called in ajax scripts?
    if (CLI_SCRIPT or AJAX_SCRIPT) {
        return;
    }

    require_once(dirname(__FILE__).'/locallib.php');
    local_envbar_inject();
}

