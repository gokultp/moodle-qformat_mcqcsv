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
 * Strings for component 'qformat_giftmedia', language 'en'
 *
 * @package    qformat_giftdocx
 * @copyright  2015 Gokul T P
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */



$dir=$this->tempdir;
$filename = $dir."/mcq.csv";
$handle = fopen($filename, "rb");
$contents = fread($handle, filesize($filename));

$rows = explode("\n",$contents);
$txt = "";
for($j=0;$j<count($rows)-1;$j++){
    $cols = explode(",",$rows[$j]);
    $txt .= "::".$cols[0]."::".$cols[1]."\r\n{=".$cols[2]."#".$cols[3];
    for($i=4;$i<count($cols);$i+=2){
        $txt .= "~".$cols[$i]."#".$cols[$i+1];
    }
    $txt .= "}\r\n\n";
 }
//echo $txt;
fclose($handle);

$fp = fopen($dir.'/t.txt', 'w');
        fwrite($fp,$txt);
        
        fclose($fp);

?>
