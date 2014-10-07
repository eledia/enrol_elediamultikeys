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

$string['customwelcomemessage'] = 'Angepasste Begrüßungsnachricht';
$string['defaultrole'] = 'Standardmäßige Rollenzuweisung';
$string['defaultrole_desc'] = 'Wählen Sie eine Rolle aus, die an Nutzer/innen bei der Selbsteinschreibung zugewiesen werden soll';
$string['enrolenddate'] = 'Ende';
$string['enrolenddaterror'] = 'Bei der Einschreibung muss das Ende später als der Beginn sein';
$string['enrolme'] = 'Einschreiben';
$string['enrolperiod'] = 'Einschreibezeitraum';
$string['enrolperiod_desc'] = 'Standardmäßige Dauer der Einschreibung (in Sekunden)';
$string['enrolstartdate'] = 'Beginn';

$string['longtimenosee'] = 'Inaktive abmelden nach';
$string['longtimenosee_help'] = 'Wenn Nutzer/innen lange Zeit nicht mehr auf einen Kurs zugegriffen haben, werden sie automatisch abgemeldet. Dieser Parameter legt die maximale Inaktivitätsdauer fest.';
$string['maxenrolled'] = 'Max. eingeschriebene Nutzer/innen';
$string['maxenrolled_help'] = 'Diese Einstellung legt die Maximalzahl möglicher Nutzer/innen mit Selbsteinschreibung fest. (0 = ohne Beschränkung)';
$string['maxenrolledreached'] = 'Die maximale Anzahl der erlaubten Nutzer/innen mit Selbsteinschreibung ist bereits erreicht
';
$string['password'] = 'Einschreibeschlüssel';
$string['password_help'] = 'Ein Einschreibeschlüssel erlaubt den Zugriff auf einen Kurs ausschließlich für diejenigen, die den Einschreibeschlüssel kennen.

Wenn das Feld leer bleibt, können sich alle Nutzer/innen der Moodle-Instanz im Kurs einschreiben.

Wenn ein Einschreibeschlüssel angegeben ist, müssen alle Nutzer/innen notwendigerweise bei der Kurseinschreibung den Einschreibeschlüssel eingeben. Beachten Sie, dass Nutzer/innen den Einschreibeschlüssel nur einmal bei der Kurseinschreibung eingeben müssen und danach dauerhaft eingeschriebene Kursteilnehmer/innen sind. ';
$string['passwordinvalid'] = 'Falscher Einschreibeschlüssel! Bitte versuchen Sie es noch einmal.';
$string['passwordinvalidhint'] = 'Falscher Einschreibeschlüssel! Bitte versuchen Sie es noch einmal.<br /> (Hinweis: Das erste Zeichen ist ein \'{$a}\')';
$string['pluginname'] = 'eLeDia Kurscode Einschreibung';
$string['pluginname_desc'] = 'Dies ist ein Einschreibungsplugin von eLeDia.
<ul>
<li>Die Nutzer schreiben sich mit Kurscodes ein, die im Block "Kurscode Einschreibung" durch den Administrator erzeugt werden können.</li>
<li>Im Block "Kurscode Einschreibung" werden Kurscodes für einen Kurs erzeugt und an eine E-Mail-Adresse versandt.</li>
<li>Jeder Kurscode gilt nur für einen Kurs und kann nur für eine Einschreibung verwendet werden.</li>
</ul>';
$string['requirepassword'] = 'Einschreibeschlüssel notwendig';
$string['requirepassword_desc'] = 'Die Verwendung eines Einschreibeschlüssel ist notwendig. Mit dieser Einstellung wird in neuen Kursen ein Einschreibeschlüssel gesetzt und in bestehenden Kursen das Löschen des Einschreibeschlüssels verhindert.';
$string['role'] = 'Rolle zuweisen';
$string['elediamultikeys:config'] = 'Selbsteinschreibung konfigurieren';
$string['elediamultikeys:manage'] = 'Eingeschriebene Nutzer/innen verwalten';
$string['elediamultikeys:unenrol'] = 'Nutzer/innen aus dem Kurs abmelden';
$string['elediamultikeys:unenrolself'] = 'Sich selber aus dem Kurs abmelden';
$string['sendcoursewelcomemessage'] = 'Begrüßungsnachricht für Kurse versenden';
$string['sendcoursewelcomemessage_help'] = 'Wenn diese Option aktiviert ist, erhalten alle Nutzer/innen eine Begrüßungsnachricht per E-Mail, wenn sie sich selber in einen Kurs eingeschrieben haben.';
$string['showhint'] = 'Hinweis zeigen';
$string['showhint_desc'] = 'Erstes Zeichen des Einschreibeschlüssels zeigen';
$string['status'] = 'Selbsteinschreibung';
$string['status_desc'] = 'Nutzer/innen erlauben, sich standardmäßig selber in Kurse einzuschreiben';
$string['status_help'] = 'Diese Einstellung legt fest, ob Nutzer/innen sich selber in einem Kurs einschreiben (und mit der entsprechenden Berechtigung auch wieder abmelden) dürfen.';
$string['unenrolselfconfirm'] = 'Möchten Sie sich wirklich selber aus dem Kurs "{$a}" abmelden?';
$string['usepasswordpolicy'] = 'Kennwortregeln benutzen';
$string['usepasswordpolicy_desc'] = 'Die standardmäßigen Kennwortregeln gelten auch für die Einschreibeschlüssel.';
$string['welcometocourse'] = 'Willkommen zu {$a}';
$string['welcometocoursetext'] = 'Willkommen im Kurs \'{$a->coursename}\'!

Falls Sie es nicht bereits erledigt haben, sollten Sie Ihr persönliches Nutzerprofil bearbeiten. Auf diese Weise können wir alle mehr über Sie erfahren und besser zusammenarbeiten:

{$a->profileurl}';
$string['keynotfound'] = 'Kurscode nicht gefunden';
$string['wrongkey'] = 'Falscher Kurscode für diesen Kurs';
$string['keyused'] = 'Kurscode wurde bereits verwendet';
$string['infomail'] = 'E-Mail Adresse für Einschreibe Information';
$string['infomail_help'] = 'Wenn eine Adresse festgelegt ist wird bei einer Einschreibung eine E-Mail an diese Adresse geschickt.';
$string['enrolkey_used'] = 'Einschreibschlüssel wurde verwendet';
$string['enrolkey_used_text'] = 'Ein Einschreibeschlüssel wurde verwendet:
Schlüssel: {$a->key}
Benutzer: {$a->user}
Kurs: {$a->course}
';
