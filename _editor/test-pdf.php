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
 * @package     mod_certificatebeautiful
 * @copyright   2024 Eduardo Kraus https://eduardokraus.com/
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_once("{$CFG->libdir}/tablelib.php");
require_once("{$CFG->dirroot}/mod/certificatebeautiful/lib.php");

global $PAGE, $USER, $CFG;

require_login();
$context = context_system::instance();
require_capability('mod/certificatebeautiful:addinstance', $context);

$id = optional_param('id', false, PARAM_INT);
$htmldata = optional_param('htmldata', false, PARAM_RAW);
$cssdata = optional_param('cssdata', false, PARAM_RAW);

if ($htmldata && $cssdata) {
    require_sesskey();
    $certificatebeautifulmodel = (object)[
        "id" => $id,
        "name" => 'name',
        "pages_info_object" => [
            (object)[
                "htmldata" => $htmldata,
                "cssdata" => $cssdata
            ]
        ]
    ];
} else {
    if ($id === false) {
        foreach (certificatebeautiful_list_all_models() as $key => $model) {
            echo "<p><a href='?id={$key}'>{$model['key']}</a></p>";
        }

        echo "<h4><a href='?id=-2'>Abrir todos os certificados</a></p>";

        die();
    } else if ($id == -2) {
        $certificatebeautifulmodel = (object)[
            "id" => $id,
            "name" => 'all',
            "pages_info_object" => []
        ];
        foreach (certificatebeautiful_list_all_models() as $key => $model) {
            $certificatebeautifulmodel->pages_info_object[] = (object)[
                "htmldata" => \mod_certificatebeautiful\model\get_template_file::load_template_file($model['key']),
                "cssdata" => ""
            ];
        }
    } else {
        if ($id == -1) {
            $certificatebeautifulmodel = (object)[
                "id" => $id,
                "name" => 'sumary-secound-page',
                "pages_info_object" => [
                    (object)[
                        "htmldata" => \mod_certificatebeautiful\model\get_template_file::load_template_file('sumary-secound-page'),
                        "cssdata" => ""
                    ]
                ]
            ];
        } else {
            $models = certificatebeautiful_list_all_models();
            $model = $models[$id];

            $certificatebeautifulmodel = (object)[
                "id" => $id,
                "name" => $model['key'],
                "pages_info_object" => [
                    (object)[
                        "htmldata" => \mod_certificatebeautiful\model\get_template_file::load_template_file($model['key']),
                        "cssdata" => ""
                    ],
                    (object)[
                        "htmldata" => \mod_certificatebeautiful\model\get_template_file::load_template_file("sumary-secound-page"),
                        "cssdata" => ""
                    ]
                ]
            ];
        }
    }
}

$certificatebeautiful = (object)[
    'name' => "teste",
    "description" => get_string('default-description', 'certificatebeautiful')
];
$certificatebeautifulissie = (object)[
    'name' => "teste",
    "code" => "CODE-EX"
];
$user = $DB->get_record_sql("SELECT * FROM {user}   WHERE id > 1 ORDER BY RAND() LIMIT 1");
$course = $DB->get_record_sql("SELECT * FROM {course} WHERE id > 1 ORDER BY RAND() LIMIT 1");

require_once("{$CFG->dirroot}/mod/certificatebeautiful/classes/pdf/page_pdf.php");
$pagepdf = new \mod_certificatebeautiful\pdf\page_pdf();
$pdf = $pagepdf->create_pdf($certificatebeautiful, $certificatebeautifulissie, $certificatebeautifulmodel, $user, $course);

header('Content-Type: application/pdf');
echo $pdf;
