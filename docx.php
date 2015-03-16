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
 * GIFT with media format question importer.
 *
 * @package    qformat_giftdocx
 * @copyright  2015 Gokul T P
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

    $dir=$this->tempdir;
    function delete_all_between($beginning, $end, $string) {
        $beginningPos = strpos($string, $beginning);
        $endPos = strpos($string, $end);
        if ($beginningPos === false || $endPos === false) {
            return $string;
        }

        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

        return str_replace($textToDelete, '', $string);
        }

    function docx2text( $filename){

        $striped_content = '';
        $content = '';

        $zip = zip_open($filename);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
            }// end while

        zip_close($zip);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $max = substr_count($content, '<wp:posOffset>');
        for($i=0;$i<$max;$i++){
            $content = delete_all_between('<wp:posOffset>','</wp:posOffset>',$content);
            }
        $striped_content = strip_tags($content);

        return $striped_content;
        }


    function readZippedImages($filename,$dir) {

        $in=1;
        $imgs[0]='del';
        /*Create a new ZIP archive object*/
        $zip = new ZipArchive;

        /*Open the received archive file*/
        if (true === $zip->open($filename)) {
            for ($i=0; $i<$zip->numFiles;$i++) {


                /*Loop via all the files to check for image files*/
                $zip_element = $zip->statIndex($i);


                /*Check for images*/
                if(preg_match("([^\s]+(\.(?i)(jpg|jpeg))$)",$zip_element['name'])) {
                    $fp = fopen($dir.'/img'.$in.'.jpg', 'w');
                    fwrite($fp, $zip->getFromIndex($i));
                    $imgs[$in]='/img'.$in.'.jpg';
                    $in++;
                    fclose($fp);
                    }
                else if(preg_match("([^\s]+(\.(?i)(png))$)",$zip_element['name'])) {
                    $fp = fopen($dir.'/img'.$in.'.png', 'w');
                    fwrite($fp, $zip->getFromIndex($i));
                    $imgs[$in]='/img'.$in.'.png';
                    $in++;
                    fclose($fp);
                    }
                else if(preg_match("([^\s]+(\.(?i)(gif))$)",$zip_element['name'])) {
                    $fp = fopen($dir.'/img'.$in.'.gif', 'w');
                    fwrite($fp, $zip->getFromIndex($i));
                    $imgs[$in]='/img'.$in.'.gif';
                    $in++;
                    fclose($fp);
                    }
                else if(preg_match("([^\s]+(\.(?i)(bmp))$)",$zip_element['name'])) {
                    $fp = fopen($dir.'/img'.$in.'.bmp', 'w');
                    fwrite($fp, $zip->getFromIndex($i));
                    $imgs[$in]='/img'.$in.'.bmp';
                    $in++;
                    fclose($fp);
                    }
                }
            }

        $im[0]=$in-1;
        $im[1]=$imgs;
        return $im;
        }
    $im=readZippedImages($dir.'/gift.docx',$dir);
    $i = $im[0];
    $imgs = $im[1];

    $txt = docx2text($dir.'/gift.docx');

    $txts = explode(";img",$txt);

    foreach ($txts as &$val) 
        {
        $tmp .= $val."<br><img src = \"@@PLUGINFILE@@".$imgs[$i--]."\"> ";
        }
    $tmp = str_replace('<img src = "@@PLUGINFILE@@del">', "", $tmp);

    $fp = fopen($dir.'/t.txt', 'w');
    fwrite($fp,$tmp);
        
    fclose($fp);
