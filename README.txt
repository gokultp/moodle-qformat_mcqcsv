moodle-qformat_giftdocx
========================

Moodle import format similar to gift, but for a docx file with media files

This plugin allow import of questions with images using the GIFT format syntax.

Written by Gokul T P

To install using git, type this command in the root of your Moodle install
    git clone git://github.com/gokultp/giftdocx question/format/giftmedia
Another way to install is to download the zip file, unzip it, and place it in the directory
moodle/question/format/. (You will need to rename the directory moodle-qformat_giftdocx-master to giftdocx).

WARNING : This version of the report is compatible with Moodle 2.6 or later.
Be sure to install the right version for your Moodle version.

Create the docx file in gift format and when inserting an image add a tag ';img' before the image or at
the position which image has to displayed, a dem.docx is provided.
