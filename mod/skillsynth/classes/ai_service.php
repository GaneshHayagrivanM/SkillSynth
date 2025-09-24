<?php

namespace mod_skillsynth;

defined('MOODLE_INTERNAL') || die();

class ai_service {

    /**
     * Simulates a call to the Gemini API to analyze a profile against a job description.
     *
     * @param string $profileText
     * @param string $jobDescriptionText
     * @return string A JSON string representing the analysis.
     */
    public function get_skill_analysis(string $profileText, string $jobDescriptionText): string {
        // In a real implementation, this would make an HTTP request to the Gemini API.
        // Here, we return a hardcoded JSON response for development purposes based on the agreed structure.
        $mockResponse = [
            'currentStrengths' => [
                'PHP Development',
                'Moodle Plugin Architecture',
                'JavaScript (AMD)',
                'SQL'
            ],
            'skillGaps' => [
                [
                    'skillName' => 'Automated Testing with Behat',
                    'skillDescription' => 'The job requires experience in writing automated tests for Moodle, and your profile lacks specific mentions of Behat or Cucumber.'
                ],
                [
                    'skillName' => 'React.js Frontend Development',
                    'skillDescription' => 'The job description lists React.js as a key skill for building modern user interfaces.'
                ],
                [
                    'skillName' => 'CI/CD Pipeline Configuration',
                    'skillDescription' => 'Experience with Continuous Integration and Deployment pipelines (e.g., using GitHub Actions) is highly desired.'
                ]
            ]
        ];

        return json_encode($mockResponse);
    }

    /**
     * Simulates a call to the Gemini API to find learning resources for a specific skill.
     *
     * @param string $skillName
     * @return array An array of learning resources.
     */
    public function get_learning_resources(string $skillName): array {
        // This simulates finding resources for a given skill.
        // The results are hardcoded for this mock service.
        $resources = [
            [
                'title' => 'Official ' . $skillName . ' Documentation',
                'type' => 'Documentation',
                'url' => '#' // Using '#' for placeholder links
            ],
            [
                'title' => 'Introduction to ' . $skillName . ' on YouTube',
                'type' => 'YouTube Video',
                'url' => '#'
            ],
            [
                'title' => 'Advanced ' . $skillName . ' Techniques (Article)',
                'type' => 'Article',
                'url' => '#'
            ]
        ];

        return $resources;
    }
}
