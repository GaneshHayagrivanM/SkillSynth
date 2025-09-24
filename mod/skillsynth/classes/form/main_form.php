<?php

namespace mod_skillsynth\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

class main_form extends \moodleform {

    /**
     * Form definition.
     */
    protected function definition() {
        $mform = $this->_form;

        $mform->addElement('header', 'header_analysis', get_string('header_analysis', 'mod_skillsynth'));

        $mform->addElement('textarea', 'profiletext', get_string('profiletext', 'mod_skillsynth'), 'wrap="virtual" rows="15" cols="50"');
        $mform->addHelpButton('profiletext', 'profiletext', 'mod_skillsynth');
        $mform->setType('profiletext', PARAM_TEXT);
        $mform->addRule('profiletext', get_string('required'), 'required', null, 'client');

        $mform->addElement('textarea', 'jobdescriptiontext', get_string('jobdescriptiontext', 'mod_skillsynth'), 'wrap="virtual" rows="15" cols="50"');
        $mform->addHelpButton('jobdescriptiontext', 'jobdescriptiontext', 'mod_skillsynth');
        $mform->setType('jobdescriptiontext', PARAM_TEXT);
        $mform->addRule('jobdescriptiontext', get_string('required'), 'required', null, 'client');

        $this->add_action_buttons(true, get_string('submit_analysis', 'mod_skillsynth'));
    }

    /**
     * Validation.
     *
     * @param array $data
     * @param array $files
     * @return array
     */
    function validation($data, $files) {
        $errors = parent::validation($data, $files);
        // Add any custom server-side validation here if needed in the future.
        return $errors;
    }
}
