<?php

require_once('../../config.php');
require_once('lib.php');

$id = required_param('id', PARAM_INT); // Course ID

$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);

require_course_login($course);
$PAGE->set_url('/mod/skillsynth/index.php', array('id' => $id));
$PAGE->set_pagelayout('incourse');

// Get all skillsynth activities in this course.
$skillsynths = get_all_instances_in_course('skillsynth', $course);

$PAGE->set_title($course->fullname);
$PAGE->set_heading($course->fullname);
echo $OUTPUT->header();

if (!$skillsynths) {
    echo $OUTPUT->notification(get_string('therearenot', 'moodle', get_string('modulenameplural', 'skillsynth')));
    echo $OUTPUT->footer();
    return;
}

$table = new html_table();
$table->head = array(get_string('modulename', 'skillsynth'));
$table->data = array();
foreach ($skillsynths as $skillsynth) {
    $url = new moodle_url('/mod/skillsynth/view.php', array('id' => $skillsynth->coursemodule));
    $link = html_writer::link($url, format_string($skillsynth->name));
    $table->data[] = array($link);
}

echo html_writer::table($table);

echo $OUTPUT->footer();
