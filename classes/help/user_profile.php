<?php
// This file is part of the mod_certificatebeautiful plugin for Moodle - http://moodle.org/
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
 * User: Eduardo Kraus
 * Date: 11/01/2024
 * Time: 13:08
 */

namespace mod_certificatebeautiful\help;

class user_profile extends help_base {
    /**
     * @return array
     * @throws \coding_exception
     */
    public static function table_structure() {
        return [
            ['key' => 'NAME', 'label' => get_string('help_user_profile', 'certificatebeautiful')],
        ];
    }

    /**
     * @param $user
     * @return array
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function get_data($user) {
        global $CFG, $DB;

        $userinfofields = $DB->get_records('user_info_field');
        if ($userinfofields) {
            $data = [];
            foreach ($userinfofields as $userinfofield) {
                require_once($CFG->dirroot . '/user/profile/field/' . $userinfofield->datatype . '/field.class.php');
                $newfield = 'profile_field_' . $userinfofield->datatype;

                /** @var \profile_field_base $formfield */
                $formfield = new $newfield($userinfofield->id, $user->id);
                if ($formfield->is_visible() && !$formfield->is_empty()) {
                    if ($userinfofield->datatype == 'checkbox') {
                        $data[$userinfofield->shortname] = $formfield->data == 1 ? get_string('yes') : get_string('no');
                    } else {
                        $data[$userinfofield->shortname] = $formfield->display_data();
                    }
                }
            }
            return $data;
        }

        return [];
    }
}
