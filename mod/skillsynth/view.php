<?php

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/skillsynth/classes/form/main_form.php');
require_once($CFG->dirroot . '/mod/skillsynth/classes/ai_service.php');

$id = required_param('id', PARAM_INT); // Course module ID

// Get the course module record and other related records.
if (!$cm = get_coursemodule_from_id('skillsynth', $id, 0, false, MUST_EXIST)) {
    print_error('invalidcoursemodule');
}
if (!$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST)) {
    print_error('coursemisconf');
}
if (!$skillsynth = $DB->get_record('skillsynth', array('id' => $cm->instance), '*', MUST_EXIST)) {
    print_error('invalidcoursemodule');
}

require_course_login($course, true, $cm);
$PAGE->set_url('/mod/skillsynth/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($skillsynth->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->requires->css('/mod/skillsynth/styles.css');


// Instantiate the form.
$mform = new \mod_skillsynth\form\main_form();

// Form processing and display.
if ($mform->is_cancelled()) {
    // Handle form cancellation.
    redirect(new moodle_url('/course/view.php', array('id' => $course->id)));

} else if ($fromform = $mform->get_data()) {
    // This block handles the form submission.

    // 1. Rate Limiting Check
    $ratelimit = get_config('mod_skillsynth', 'ratelimit');
    if (empty($ratelimit) || $ratelimit < 0) {
        $ratelimit = 5; // A sensible default if not set or invalid.
    }
    $useranalysistime = time() - DAYSECS; // 24 hours ago
    $useranalysiscount = $DB->count_records_sql(
        "SELECT COUNT(*) FROM {skillsynth_analysis} WHERE userid = :userid AND timecreated >= :timecreated AND instanceid = :instanceid",
        ['userid' => $USER->id, 'timecreated' => $useranalysistime, 'instanceid' => $skillsynth->id]
    );

    if ($useranalysiscount >= $ratelimit) {
        // User has reached the limit. Display a notification and re-display the form.
        echo $OUTPUT->header();
        echo $OUTPUT->notification(get_string('ratelimit_exceeded', 'mod_skillsynth'));
        if (!empty($skillsynth->intro)) {
            echo $OUTPUT->box(format_text($skillsynth->intro, $skillsynth->introformat), 'generalbox', 'intro');
        }
        $mform->display();
        echo $OUTPUT->footer();
        die();
    }

    // 2. Get Analysis from AI Service
    $aiservice = new \mod_skillsynth\ai_service();
    $analysisjson = $aiservice->get_skill_analysis($fromform->profiletext, $fromform->jobdescriptiontext);
    $analysis = json_decode($analysisjson);

    if (is_null($analysis) || !isset($analysis->skillGaps) || !isset($analysis->currentStrengths)) {
        print_error('error_analysis_failed', 'mod_skillsynth');
    }

    // 3. Curate Learning Resources for each skill gap
    $analysis->skillGaps = array_map(function($gap) use ($aiservice) {
        $gap->learningResources = $aiservice->get_learning_resources($gap->skillName);
        return $gap;
    }, $analysis->skillGaps);

    // 4. Persist the aggregated data to the database
    $record = new \stdClass();
    $record->instanceid = $skillsynth->id;
    $record->userid = $USER->id;
    $record->analysisdata = json_encode($analysis);
    $record->timecreated = time();

    $DB->insert_record('skillsynth_analysis', $record);

    // 5. Display the results using the renderer.
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('analysis_results_header', 'mod_skillsynth'));
    $renderer = $PAGE->get_renderer('mod_skillsynth');
    echo $renderer->render_analysis_result($analysis);
    echo $OUTPUT->footer();
    die();

} else {
    // This is the first time the page is displayed or there was a validation error.
    echo $OUTPUT->header();

    // Print the introduction of the activity.
    if (!empty($skillsynth->intro)) {
        echo $OUTPUT->box(format_text($skillsynth->intro, $skillsynth->introformat), 'generalbox', 'intro');
    }

    $mform->display();
    echo $OUTPUT->footer();
}
