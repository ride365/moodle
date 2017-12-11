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
 * Planet eStream Authentication Plugin
 *
 * @package    filter_estreamauth
 * @copyright  Planet eStream
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */
// require_once('../../config.php');
defined('MOODLE_INTERNAL') || die();
class filter_estreamauth extends moodle_text_filter {

    private function userobfuscate($strx) {

        $strbase64chars = '0123456789aAbBcCDdEeFfgGHhiIJjKklLmMNnoOpPQqRrsSTtuUvVwWXxyYZz/+=';
        $strbase64string = base64_encode($strx);
        if ($strbase64string == '') {
            return '';
        }
        $strobfuscated = '';
        for ($i = 0; $i < strlen ($strbase64string); $i ++) {
            $intpos = strpos($strbase64chars, substr($strbase64string, $i, 1));
            if ($intpos == - 1) {
                return '';
            }
            $intpos += strlen($strbase64string ) + $i;
            $intpos = $intpos % strlen($strbase64chars);
            $strobfuscated .= substr($strbase64chars, $intpos, 1);

        }
        return urlencode($strobfuscated);
    }
    public function filter($text, array $options = array()) {
        global $USER;
        $delta = $this->userobfuscate($USER->username);
        return str_replace('ESDLTA', $delta, $text);
    }
}