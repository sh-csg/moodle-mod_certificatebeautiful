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
 * Date: 09/01/2024
 * Time: 12:15
 */

namespace mod_certificatebeautiful\model;

require_once($CFG->dirroot . '/lib/formslib.php');

class form_create_page extends \moodleform {

    public static function empty_page() {

        return (object)[
            "htmldata" => '<section id="topo" class="certificate-root"><div>' .
                get_string('certificate_page_empty', 'certificatebeautiful') . '</div></section>',
            "cssdata" => ""
        ];
    }

    /**
     * Form definition. Abstract method - always override!
     */
    protected function definition() {
    }
}
