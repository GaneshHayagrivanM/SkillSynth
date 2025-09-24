<?php

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    // Create the admin settings page.
    $settings = new admin_settingpage('mod_skillsynth_settings', get_string('pluginadministration', 'mod_skillsynth'));

    // API Key setting.
    $settings->add(new admin_setting_configpasswordunmask(
        'mod_skillsynth/apikey',
        get_string('apikey', 'mod_skillsynth'),
        get_string('apikeydesc', 'mod_skillsynth'),
        '',
        PARAM_TEXT
    ));

    // Rate limit setting.
    $settings->add(new admin_setting_configtext(
        'mod_skillsynth/ratelimit',
        get_string('ratelimit', 'mod_skillsynth'),
        get_string('ratelimitdesc', 'mod_skillsynth'),
        5,
        PARAM_INT
    ));

    $ADMIN->add('modsettings', $settings);
}
