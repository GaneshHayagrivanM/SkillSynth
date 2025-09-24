# SkillSynth AI

SkillSynth AI is a Moodle plugin designed to help users analyze their skills against job descriptions. By leveraging the power of AI, it identifies skill strengths and gaps, and suggests relevant learning resources to help users bridge those gaps and advance their careers.

## Features

- **Skill Analysis:** Compares a user's resume or professional profile against a target job description.
- **Strength & Gap Identification:** Clearly lists current strengths and identifies areas for improvement (skill gaps).
- **Learning Recommendations:** Suggests learning resources for each identified skill gap.
- **Moodle Integration:** Seamlessly integrates into the Moodle LMS as an activity module.
- **Configurable:** Administrators can set the AI service API key and configure rate limits for analyses.

## How It Works

1.  A user navigates to a SkillSynth activity within a Moodle course.
2.  They are presented with a form to enter their profile/resume text and the text of a job description.
3.  Upon submission, SkillSynth sends this information to an AI service (e.g., Google Gemini) for analysis.
4.  The AI service returns a structured analysis of strengths and skill gaps.
5.  For each skill gap, SkillSynth fetches a list of suggested learning resources.
6.  The complete analysis, including strengths, gaps, and learning resources, is displayed to the user.
7.  The analysis result is saved for the user for future reference.

## Installation

1.  Download the plugin files.
2.  Place the `skillsynth` directory into the `mod/` directory of your Moodle installation.
3.  Log in to your Moodle site as an administrator.
4.  Navigate to "Site administration" > "Notifications".
5.  Moodle will detect the new plugin and guide you through the installation/upgrade process.

## Configuration

After installation, you need to configure the plugin:

1.  Go to "Site administration" > "Plugins" > "Activity modules" > "SkillSynth AI".
2.  **Google Gemini API Key:** Enter your API key for the Google Gemini service. This is required for the analysis to work.
3.  **Analyses per day:** Set the maximum number of times a user can perform an analysis within a 24-hour period. This helps to control API costs.

## Usage

1.  As a course creator, add a "SkillSynth AI" activity to your course.
2.  Give it a name and an introduction.
3.  Students or users in the course can then click on the activity.
4.  They will see the form to paste their profile and a job description.
5.  After submitting, they will receive their personalized skill analysis.

## Technical Details

- **Backend:** PHP, designed for Moodle's plugin architecture.
- **Frontend:** Moodle forms and Mustache templates for rendering.
- **Database:**
    - `skillsynth`: Stores the instances of the SkillSynth activity.
    - `skillsynth_analysis`: Stores the JSON-encoded analysis results for each user submission.
- **AI Service:** The `ai_service.php` class is responsible for interacting with the external AI API. It is designed to be extensible for other AI services.

## Contributing

Contributions are welcome! If you would like to contribute to SkillSynth AI, please follow these steps:

1.  Fork the repository.
2.  Create a new branch for your feature or bug fix.
3.  Make your changes.
4.  Submit a pull request with a clear description of your changes.

## License

This plugin is licensed under the [GNU GPL v3 License](http://www.gnu.org/copyleft/gpl.html).
