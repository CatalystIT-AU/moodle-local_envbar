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
 * local_envbar
 *
 * @package    local_envbar
 * @copyright  2016 Brendan Heywood <brendan@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_envbar\task;

use local_envbar\local\envbarlib;

/**
 * checkprod
 *
 * @package    local_envbar
 * @copyright  2016 Brendan Heywood <brendan@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class checkprod extends \core\task\scheduled_task {

    /**
     * Get task name
     */
    public function get_name() {
        return get_string('pluginname', 'local_envbar');
    }

    /**
     * Execute task
     */
    public function execute() {
        global $CFG;

        // Are we on the production env?
        if (envbarlib::getprodwwwroot() === $CFG->wwwroot) {
            set_config('prodlastcheck', time(), 'local_envbar');
        }

    }
}


