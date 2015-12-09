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

/**
 *
 *
 * @package enrol
 * @category eledia_multikeys
 * @copyright 2013 eLeDia GmbH {@link http://www.eledia.de}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class enrol_elediamultikeys_plugin extends enrol_plugin {

    /**
     * Returns optional enrolment information icons.
     *
     * This is used in course list for quick overview of enrolment options.
     *
     * We are not using single instance parameter because sometimes
     * we might want to prevent icon repetition when multiple instances
     * of one type exist. One instance may also produce several icons.
     *
     * @param array $instances all enrol instances of this type in one course
     * @return array of pix_icon
     */
    public function get_info_icons(array $instances) {
        $key = false;
        $nokey = false;
        foreach ($instances as $instance) {
            if ($instance->password or $instance->customint1) {
                $key = true;
            } else {
                $nokey = true;
            }
        }
        $icons = array();
        if ($nokey) {
            $icons[] = new pix_icon('withoutkey', get_string('pluginname', 'enrol_elediamultikeys'), 'enrol_elediamultikeys');
        }
        if ($key) {
            $icons[] = new pix_icon('withkey', get_string('pluginname', 'enrol_elediamultikeys'), 'enrol_elediamultikeys');
        }
        return $icons;
    }

    /**
     * Returns localised name of enrol instance
     *
     * @param object $instance (null is accepted too)
     * @return string
     */
    public function get_instance_name($instance) {
        global $DB;

        if (empty($instance->name)) {
            if (!empty($instance->roleid) and $role = $DB->get_record('role', array('id'=>$instance->roleid))) {
                $role = ' (' . role_get_name($role, context_course::instance($instance->courseid)) . ')';
            } else {
                $role = '';
            }
            $enrol = $this->get_name();
            return get_string('pluginname', 'enrol_'.$enrol) . $role;
        } else {
            return format_string($instance->name);
        }
    }

    public function roles_protected() {
        // Users may tweak the roles later.
        return false;
    }

    public function allow_unenrol(stdClass $instance) {
        // Users with unenrol cap may unenrol other users manually manually.
        return true;
    }

    public function allow_manage(stdClass $instance) {
        // Users with manage cap may tweak period and status.
        return true;
    }

    public function show_enrolme_link(stdClass $instance) {
        return ($instance->status == ENROL_INSTANCE_ENABLED);
    }

    /**
     * Sets up navigation entries.
     *
     * @param object $instance
     * @return void
     */
    public function add_course_navigation($instancesnode, stdClass $instance) {
        if ($instance->enrol !== 'elediamultikeys') {
             throw new coding_exception('Invalid enrol instance type!');
        }

        $context = context_course::instance($instance->courseid);
        if (has_capability('enrol/elediamultikeys:config', $context)) {
            $managelink = new moodle_url('/enrol/elediamultikeys/edit.php', array('courseid'=>$instance->courseid, 'id'=>$instance->id));
            $instancesnode->add($this->get_instance_name($instance), $managelink, navigation_node::TYPE_SETTING);
        }
    }

    /**
     * Returns edit icons for the page with list of instances
     * @param stdClass $instance
     * @return array
     */
    public function get_action_icons(stdClass $instance) {
        global $OUTPUT;

        if ($instance->enrol !== 'elediamultikeys') {
            throw new coding_exception('invalid enrol instance!');
        }
        $context = context_course::instance($instance->courseid);

        $icons = array();

        if (has_capability('enrol/elediamultikeys:config', $context)) {
            $editlink = new moodle_url("/enrol/elediamultikeys/edit.php", array('courseid'=>$instance->courseid, 'id'=>$instance->id));
            $icons[] = $OUTPUT->action_icon($editlink, new pix_icon('i/edit', get_string('edit'), 'core', array('class'=>'icon')));
        }

        return $icons;
    }

    /**
     * Returns link to page which may be used to add new instance of enrolment plugin in course.
     * @param int $courseid
     * @return moodle_url page url
     */
    public function get_newinstance_link($courseid) {
        $context = context_course::instance($courseid);

        if (!has_capability('moodle/course:enrolconfig', $context) or !has_capability('enrol/manual:config', $context)) {
            return NULL;
        }
        // multiple instances supported - different roles with different password
        return new moodle_url('/enrol/elediamultikeys/edit.php', array('courseid'=>$courseid));
    }

    /**
     * Creates course enrol form, checks if form submitted
     * and enrols user if necessary. It can also redirect.
     *
     * @param stdClass $instance
     * @return string html text, usually a form in a text box
     */
    public function enrol_page_hook(stdClass $instance) {
        global $CFG, $OUTPUT, $SESSION, $USER, $DB;

        if (isguestuser()) {
            // Can not enrol guest!!
            return null;
        }
        if ($DB->record_exists('user_enrolments', array('userid'=>$USER->id, 'enrolid'=>$instance->id))) {
            return null;
        }

        if ($instance->enrolstartdate != 0 and $instance->enrolstartdate < time()) {
            return null;
        }

        if ($instance->enrolenddate != 0 and $instance->enrolenddate > time()) {
            return null;
        }

        if ($instance->customint3 > 0) {
            // Max enrol limit specified.
            $count = $DB->count_records('user_enrolments', array('enrolid'=>$instance->id));
            if ($count >= $instance->customint3) {
                // Bad luck, no more self enrolments here.
                return $OUTPUT->notification(get_string('maxenrolledreached', 'enrol_elediamultikeys'));
            }
        }

        require_once("$CFG->dirroot/enrol/elediamultikeys/locallib.php");
        require_once("$CFG->dirroot/group/lib.php");

        $form = new enrol_elediamultikeys_enrol_form(NULL, $instance);
        $instanceid = optional_param('instance', 0, PARAM_INT);

        // On any error this shows the form for enrol again.
        ob_start();
        $form->display();
        $output = ob_get_clean();

        if ($instance->id == $instanceid) {
            if ($data = $form->get_data()) {
                $enrol = enrol_get_plugin('elediamultikeys');
                $timestart = time();
                if ($instance->enrolperiod) {
                    $timeend = $timestart + $instance->enrolperiod;
                } else {
                    $timeend = 0;
                }

                if ($onewaykey = $DB->get_record('block_eledia_multikeys',
                        array('code' => $data->enrolpassword))) {

                    if ($onewaykey->enrolid != $instance->id) {
                        $output = $OUTPUT->notification(get_string('passwordinvalid', 'enrol_elediamultikeys')).$output;
                        return $output;
                    }

                    if ($onewaykey->user) {// Key already used.
                        $output = $OUTPUT->notification(get_string('keyused', 'enrol_elediamultikeys')).$output;
                        return $output;
                    }

                    // Use key enrol duration if set.
                    if (!empty($onewaykey->enrol_duration)) {
                        $timeend = $timestart + ($onewaykey->enrol_duration * 24 * 60 * 60);
                    }

                    $cfginfomail = $this->get_config('infomail');
                    $this->enrol_user($instance, $USER->id, $instance->roleid, $timestart, $timeend);
                    if (!empty($cfginfomail)) {
                        $this->send_infomail($cfginfomail,
                                            $data->enrolpassword,
                                            $instance->courseid,
                                            $USER);
                    }

                    $onewaykey->user = $USER->id;
                    $onewaykey->timeused = time();
                    $DB->update_record('block_eledia_multikeys', $onewaykey);
                }else{// Key invalid.
                    $output = $OUTPUT->notification(get_string('keynotfound', 'enrol_elediamultikeys')).$output;
                    return $output;
                }

                // Send welcome.
                if ($instance->customint4) {
                    $this->email_welcome_message($instance, $USER);
                }
            }
        }

        return $OUTPUT->box($output);
    }

    /**
     * Add new instance of enrol plugin with default settings.
     * @param object $course
     * @return int id of new instance
     */
    public function add_default_instance($course) {
        $fields = array('customint1'  => $this->get_config('groupkey'),
                        'customint2'  => $this->get_config('longtimenosee'),
                        'customint3'  => $this->get_config('maxenrolled'),
                        'customint4'  => $this->get_config('sendcoursewelcomemessage'),
                        'enrolperiod' => $this->get_config('enrolperiod', 0),
                        'status'      => $this->get_config('status'),
                        'roleid'      => $this->get_config('roleid', 0));

        if ($this->get_config('requirepassword')) {
            $fields['password'] = generate_password(20);
        }

        return $this->add_instance($course, $fields);
    }

    /**
     * Send welcome email to specified user
     *
     * @param object $instance
     * @param object $user user record
     * @return void
     */
    protected function email_welcome_message($instance, $user) {
        global $CFG, $DB;

        $course = $DB->get_record('course', array('id'=>$instance->courseid), '*', MUST_EXIST);

        $a = new stdClass();
        $a->coursename = format_string($course->fullname);
        $a->profileurl = "$CFG->wwwroot/user/view.php?id=$user->id&course=$course->id";

        if (trim($instance->customtext1) !== '') {
            $message = $instance->customtext1;
            $message = str_replace('{$a->coursename}', $a->coursename, $message);
            $message = str_replace('{$a->profileurl}', $a->profileurl, $message);
        } else {
            $message = get_string('welcometocoursetext', 'enrol_elediamultikeys', $a);
        }

        $subject = get_string('welcometocourse', 'enrol_elediamultikeys', format_string($course->fullname));

        $context = context_course::instance($course->id);
        $rusers = array();
        if (!empty($CFG->coursecontact)) {
            $croles = explode(',', $CFG->coursecontact);
            $rusers = get_role_users($croles, $context, true, '', 'r.sortorder ASC, u.lastname ASC');
        }
        if ($rusers) {
            $contact = reset($rusers);
        } else {
            $contact = get_admin();
        }

        //directly emailing welcome message rather than using messaging
        email_to_user($user, $contact, $subject, $message);
    }

    /**
     * Enrol elediamultikeys cron support
     * @return void
     */
    public function cron() {
        global $DB;

        if (!enrol_is_enabled('elediamultikeys')) {
            return;
        }

        $plugin = enrol_get_plugin('elediamultikeys');

        $now = time();

        //note: the logic of self enrolment guarantees that user logged in at least once (=== u.lastaccess set)
        //      and that user accessed course at least once too (=== user_lastaccess record exists)

        // first deal with users that did not log in for a really long time
        $sql = "SELECT e.*, ue.userid
                  FROM {user_enrolments} ue
                  JOIN {enrol} e ON (e.id = ue.enrolid AND e.enrol = 'elediamultikeys' AND e.customint2 > 0)
                  JOIN {user} u ON u.id = ue.userid
                 WHERE :now - u.lastaccess > e.customint2";
        $rs = $DB->get_recordset_sql($sql, array('now'=>$now));
        foreach ($rs as $instance) {
            $userid = $instance->userid;
            unset($instance->userid);
            $plugin->unenrol_user($instance, $userid);
            mtrace("unenrolling user $userid from course $instance->courseid as they have did not log in for $instance->customint2 days");
        }
        $rs->close();

        // Now unenrol from course user did not visit for a long time.
        $sql = "SELECT e.*, ue.userid
                  FROM {user_enrolments} ue
                  JOIN {enrol} e ON (e.id = ue.enrolid AND e.enrol = 'elediamultikeys' AND e.customint2 > 0)
                  JOIN {user_lastaccess} ul ON (ul.userid = ue.userid AND ul.courseid = e.courseid)
                 WHERE :now - ul.timeaccess > e.customint2";
        $rs = $DB->get_recordset_sql($sql, array('now'=>$now));
        foreach ($rs as $instance) {
            $userid = $instance->userid;
            unset($instance->userid);
            $plugin->unenrol_user($instance, $userid);
            mtrace("unenrolling user $userid from course $instance->courseid as they have did not access course for $instance->customint2 days");
        }
        $rs->close();

        flush();
    }

    /**
     * Gets an array of the user enrolment actions
     *
     * @param course_enrolment_manager $manager
     * @param stdClass $ue A user enrolment object
     * @return array An array of user_enrolment_actions
     */
    public function get_user_enrolment_actions(course_enrolment_manager $manager, $ue) {
        $actions = array();
        $context = $manager->get_context();
        $instance = $ue->enrolmentinstance;
        $params = $manager->get_moodlepage()->url->params();
        $params['ue'] = $ue->id;
        if ($this->allow_unenrol($instance) && has_capability("enrol/elediamultikeys:unenrol", $context)) {
            $url = new moodle_url('/enrol/unenroluser.php', $params);
            $actions[] = new user_enrolment_action(new pix_icon('t/delete', ''), get_string('unenrol', 'enrol'), $url, array('class'=>'unenrollink', 'rel'=>$ue->id));
        }
        return $actions;
    }

    function send_infomail($address, $key, $courseid, $user) {
        global $DB, $CFG;

        $course = $DB->get_record('course', array('id'=>$courseid));

        $data = new stdClass();
        $data->key = $key;
        $data->user = fullname($user);
        $data->course = $course->fullname.' ('.$course->shortname.')';

        $recipient = new stdClass();
        $recipient->lang        = current_language();
        $recipient->firstaccess = time();
        $recipient->mnethostid  = $CFG->mnet_localhost_id;
        $recipient->email        = $address;

        $supportuser = core_user::get_support_user();

        $subject = get_string('enrolkey_used', 'enrol_elediamultikeys');
        $message     = get_string('enrolkey_used_text', 'enrol_elediamultikeys', $data);
        $messagehtml = text_to_html($message, false, false, true);

        $user->mailformat = 1;  // Always send HTML version as well.

        return email_to_user($recipient, $supportuser, $subject, $message, $messagehtml);
    }
}

/**
 * Indicates API features that the enrol plugin supports.
 *
 * @param string $feature
 * @return mixed True if yes (some features may use other values)
 */
function enrol_elediamultikeys_supports($feature) {
    switch($feature) {
        case ENROL_RESTORE_TYPE: return ENROL_RESTORE_EXACT;

        default: return null;
    }
}
