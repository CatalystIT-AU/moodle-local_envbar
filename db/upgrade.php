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
 * Database upgrades.
 *
 * @package   local_envbar
 * @author    Grigory Baleevskiy (grigory@catalyst-au.net)
 * @copyright Catalyst IT
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Database upgrade.
 * @param string $oldversion the version we are upgrading from.
 * @return bool success
 */
function xmldb_local_envbar_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager(); // Loads ddl manager and xmldb classes.

    if ($oldversion < 2016041501) {
        // Define table local_envbar_configset to be renamed to local_envbar.
        $table = new xmldb_table('local_envbar_configset');

        // Launch rename table for local_envbar.
        if ($dbman->table_exists($table, 'local_envbar')) {
            $dbman->rename_table($table, 'local_envbar');
        }

        // Envbar savepoint reached.
        upgrade_plugin_savepoint(true, 2016041501, 'local', 'envbar');
    }

    if ($oldversion < 2016041505) {

        $table = new xmldb_table('local_envbar');
        $bgfield = new xmldb_field('colorbg', XMLDB_TYPE_CHAR, '64', null, XMLDB_NOTNULL, null, null, 'id');
        $textfield = new xmldb_field('colortext', XMLDB_TYPE_CHAR, '64', null, XMLDB_NOTNULL, null, null, 'id');

        $dbman->rename_field($table, $bgfield, 'colourbg');
        $dbman->rename_field($table, $textfield, 'colourtext');

        upgrade_plugin_savepoint(true, 2016041505, 'local', 'envbar');
    }

    if ($oldversion < 2016041510) {

        // Define index idx_match (unique) to be dropped form local_envbar.
        $table = new xmldb_table('local_envbar');
        $index = new xmldb_index('idx_match', XMLDB_INDEX_UNIQUE, array('matchpattern'));

        // Conditionally launch drop index idx_match.
        if ($dbman->index_exists($table, $index)) {
            $dbman->drop_index($table, $index);
        }

        // Envbar savepoint reached.
        upgrade_plugin_savepoint(true, 2016041510, 'local', 'envbar');
    }

    return true;
}
