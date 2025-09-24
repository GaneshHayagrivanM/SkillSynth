<?php

namespace mod_skillsynth;

defined('MOODLE_INTERNAL') || die();

class renderer extends \plugin_renderer_base {
    /**
     * Renders the skill analysis result.
     *
     * @param \stdClass $analysisdata The aggregated analysis data.
     * @return string The rendered HTML.
     */
    public function render_analysis_result(\stdClass $analysisdata): string {
        return $this->render_from_template('mod_skillsynth/analysis_results', $analysisdata);
    }
}
