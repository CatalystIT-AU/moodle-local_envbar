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
 * Environment bar config.
 *
 * @package   local_envbar
 * @author    Grigory Baleevskiy (grigory@catalyst-au.net)
 * @author    Nicholas Hoobin <nicholashoobin@catalyst-au.net>
 * @copyright Catalyst IT
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.'); // It must be included from a Moodle page.
}

/**
 * Helper function to update data, or insert if it does not exist.
 * @param stdClass $data
 * @return boolean|number return value for the update
 */
function update_envbar($data) {
    global $DB;

    $data = base64_encode_record($data);

    $result = $DB->get_records('local_envbar', array('id' => $data->id));

    if (empty($result)) {
        $ret = $DB->insert_record('local_envbar', $data);
    } else {
        $ret = $DB->update_record('local_envbar', $data);
    }

    return $ret;
}

/**
 * Helper function to delete data.
 * @param int $id
 * @return boolean|number return value for the delete
 */
function delete_envbar($id) {
    global $DB;
    $ret = $DB->delete_records('local_envbar', array('id' => $id));

    return $ret;
}

/**
 * Helper function get records, will perform base64_decode on the fields.
 * @param array $array array of query parameters
 * @return array $result array of records
 */
function envbar_get_records($array = null) {
    global $DB;

    $result = $DB->get_records('local_envbar', $array);
    $result = base64_decode_records($result);
    return $result;

}

/**
 * Helper function to base64 decode the matchpattern and showtext fields.
 * @param array $data
 * @return array $data
 */
function base64_decode_records($data) {
    foreach ($data as $record) {
        $record->matchpattern = base64_decode($record->matchpattern);
        $record->showtext = base64_decode($record->showtext);
    }
    return $data;
}

/**
 * Helper function to base64 encode the matchpattern and showtext fields.
 * @param array $data
 * @return array $data
 */
function base64_encode_record($data) {
    $data->matchpattern = base64_encode($data->matchpattern);
    $data->showtext = base64_encode($data->showtext);

    return $data;
}
