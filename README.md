moodle-qformat_mcqcsv
========================

Moodle import format imports multiple choice questions from csv files

Written by Gokul T P

To install using git, type this command in the root of your Moodle install
    git clone git://github.com/gokultp/moodle-qformat_mcqcsv question/format/mcqcsv 
Another way to install is to download the zip file, unzip it, and place it in the directory
moodle/question/format/. (You will need to rename the directory moodle-qformat_mcqcsv -master to mcqcsv ).

WARNING : This version of the report is compatible with Moodle 2.6 or later.
Be sure to install the right version for your Moodle version.

Create the csv file using a spreadsheet application, in the format first row is filled with question title, 2nd row question text then next row is right answer, comment for right  answer in next then each of the next rows are filled with wrong answers and their comments, a demo.csv is provided.
