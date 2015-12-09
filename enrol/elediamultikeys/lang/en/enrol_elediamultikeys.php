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

$string['customwelcomemessage'] = 'Custom welcome message';
$string['defaultrole'] = 'Default role assignment';
$string['defaultrole_desc'] = 'Select role which should be assigned to users during self enrolment';
$string['enrolenddate'] = 'End date';
$string['enrolenddaterror'] = 'Enrolment end date cannot be earlier than start date';
$string['enrolme'] = 'Enrol me';
$string['enrolperiod'] = 'Enrolment period';
$string['enrolperiod_desc'] = 'Default length of the enrolment period (in seconds).';
$string['enrolstartdate'] = 'Start date';

$string['longtimenosee'] = 'Unenrol inactive after';
$string['longtimenosee_help'] = 'If users haven\'t accessed a course for a long time, then they are automatically unenrolled. This parameter specifies that time limit.';
$string['maxenrolled'] = 'Max enroled users';
$string['maxenrolled_help'] = 'Specifies the maximum number of users that can self enrol. 0 means no limit.';
$string['maxenrolledreached'] = 'Maximum number of users allowed to self-enrol was already reached.';
$string['password'] = 'Enrolment key';
$string['password_help'] = 'An enrolment key enables access to the course to be restricted to only those who know the key.

If the field is left blank, any user may enrol in the course.

If an enrolment key is specified, any user attempting to enrol in the course will be required to supply the key. Note that a user only needs to supply the enrolment key ONCE, when they enrole in the course.';
$string['passwordinvalid'] = 'Incorrect enrolment key, please try again';
$string['passwordinvalidhint'] = 'That enrolment key was incorrect, please try again<br />
(Here\'s a hint - it starts with \'{$a}\')';
$string['pluginname'] = 'Key enrolment';
$string['pluginname_desc'] = '<h3>This plugin is crated by eLeDia.</h3>
<p>Users can enrol itself by the key, that is created on the block "One time course enrolment" by the Administrator.</p>';
$string['requirepassword'] = 'Require enrolment key';
$string['requirepassword_desc'] = 'Require enrolment key in new courses and prevent removing of enrolment key from existing courses.';
$string['role'] = 'Assign role';
$string['elediamultikeys:config'] = 'Configure self enrol instances';
$string['elediamultikeys:manage'] = 'Manage enrolled users';
$string['elediamultikeys:unenrol'] = 'Unenrol users from course';
$string['elediamultikeys:unenrolself'] = 'Unenrol self from the course';
$string['sendcoursewelcomemessage'] = 'Send course welcome message';
$string['sendcoursewelcomemessage_help'] = 'If enabled, users receive a welcome message via email when they self-enrol in a course.';
$string['showhint'] = 'Show hint';
$string['showhint_desc'] = 'Show first letter of the guest access key.';
$string['status'] = 'Allow self enrolments';
$string['status_desc'] = 'Allow users to self enrol into course by default.';
$string['status_help'] = 'This setting determines whether a user can enrol (and also unenrol if they have the appropriate permission) themselves from the course.';
$string['unenrolselfconfirm'] = 'Do you really want to unenrol yourself from course "{$a}"?';
$string['usepasswordpolicy'] = 'Use password policy';
$string['usepasswordpolicy_desc'] = 'Use standard password policy for enrolment keys.';
$string['welcometocourse'] = 'Welcome to {$a}';
$string['welcometocoursetext'] = 'Welcome to {$a->coursename}!

If you have not done so already, you should edit your profile page so that we can learn more about you:

  {$a->profileurl}';
$string['missing_enrol_key']= 'Please enter a valid enrolment key';
$string['keynotfound'] = 'key not found';
$string['keyused'] = 'key was already used';
$string['infomail'] = 'Mail adress for enrol information';
$string['infomail_help'] = 'If an adress is defined a mail will be sent to this address on each key enrolment.';
$string['enrolkey_used'] = 'Enrol key is used';
$string['enrolkey_used_text'] = 'One enrol key is used:
Key: {$a->key}
User: {$a->user}
Course: {$a->course}
';
