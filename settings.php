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

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    $options = [
        "Aerotis" => "Aerotis",
        "Allison" => "Allison",
        "Autography" => "Autography",
        "Creata" => "Creata",
        "Tomatoes" => "Tomatoes",
        "Wishloved" => "Wishloved",
    ];

    $imagens = "<br>";
    foreach ($options as $option) {
        $imagens .= " <img src='{$CFG->wwwroot}/mod/certificatebeautiful/_editor/fonts/_signature-{$option}/_signatre-{$option}.png'>";
    }

    $settings->add(new admin_setting_heading('certificatebeautiful_method_heading',
        get_string('config_signature_heading', 'certificatebeautiful'),
        get_string('config_signature_heading_desc', 'certificatebeautiful', count($options)) . $imagens));


    $setting = new admin_setting_configcheckbox('certificatebeautiful/config_signature_enable',
        get_string('config_signature_enable', 'certificatebeautiful'),
        get_string('config_signature_enable_desc', 'certificatebeautiful'), 1);
    $settings->add($setting);

    $setting = new admin_setting_configselect('certificatebeautiful/config_signature_typography',
        get_string('config_signature_typography', 'certificatebeautiful'),
        get_string('config_signature_typography_desc', 'certificatebeautiful'), 'Aerotis', $options);
    $settings->add($setting);

    $setting = new admin_setting_configtext_with_maxlength('certificatebeautiful/config_signature_text',
        get_string('config_signature_text', 'certificatebeautiful'),
        get_string('config_signature_text_desc', 'certificatebeautiful'), substr($USER->lastname, 0, 10), PARAM_TEXT, 10);
    $settings->add($setting);

    $setting = new admin_setting_configcolourpicker('certificatebeautiful/config_signature_color',
        get_string('config_signature_color', 'certificatebeautiful'),
        get_string('config_signature_color_desc', 'certificatebeautiful'), "#324a55");
    $settings->add($setting);

}