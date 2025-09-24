<?php

defined('MOODLE_INTERNAL') || die();

/**
 * Adds a new skillsynth instance to a course.
 *
 * @param stdClass $skillsynth
 * @param mod_skillsynth_form $mform
 * @return int
 */
function skillsynth_add_instance(stdClass $skillsynth, mod_skillsynth_form $mform = null) {
    global $DB;
    $skillsynth->timecreated = time();
    $skillsynth->timemodified = $skillsynth->timecreated;

    // This will be the main table for the activity module itself.
    // Note: This is NOT the mdl_skillsynth_analysis table from the plan.
    // This is the standard table every activity module has.
    $skillsynth->id = $DB->insert_record('skillsynth', $skillsynth);

    return $skillsynth->id;
}

/**
 * Deletes a skillsynth instance.
 *
 * @param int $id
 * @return bool
 */
function skillsynth_delete_instance($id) {
    global $DB;

    if (!$skillsynth = $DB->get_record('skillsynth', ['id' => $id])) {
        return false;
    }

    // We'll need to clean up related analysis data here later.
    // $DB->delete_records('skillsynth_analysis', ['instanceid' => $skillsynth->id]);

    $DB->delete_records('skillsynth', ['id' => $skillsynth->id]);

    return true;
}

/**
 * Updates a skillsynth instance.
 *
 * @param stdClass $skillsynth
 * @param mod_skillsynth_form $mform
 * @return bool
 */
function skillsynth_update_instance(stdClass $skillsynth, mod_skillsynth_form $mform = null) {
    global $DB;
    $skillsynth->timemodified = time();
    $skillsynth->id = $skillsynth->instance;

    return $DB->update_record('skillsynth', $skillsynth);
}

/**
 * Returns a list of features that the skillsynth module supports.
 *
 * @param string $feature FEATURE_... constant for requested feature
 * @return mixed True if module supports feature, false if not, null if doesn't know
 */
function skillsynth_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:
            return true;
        case FEATURE_SHOW_DESCRIPTION:
            return true;
        case FEATURE_NO_VIEW_LINK:
            return false; // We want a view link.
        default:
            return null;
    }
}
