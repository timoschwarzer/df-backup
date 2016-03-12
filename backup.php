<?php
/**
 * Copyright (C) Timo Schwarzer
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 *
 * 1. Save backup.php and backup.config.php to the main directory of your webserver
 * 2. Edit backup.config.php
 * 3. Run this file with PHP 5.56 or higher:
 *    php -f backup.php
 *
 */

require "backup.config.php";

// Backup
$date = date("Ymd", time());
$gen_dir_name = BACKUP_DIR."/".$date;
$counter = 0;
while (file_exists($gen_dir_name.($counter > 0 ? "_".$counter : ""))) {
    $counter++;
}
$dir_name = $gen_dir_name.($counter > 0 ? "_".$counter : "");

// Create directories
print "Backing up to ".$dir_name."\n";
if (!is_dir(BACKUP_DIR)) mkdir(BACKUP_DIR);
if (!is_dir($dir_name)) mkdir($dir_name);


// Dump databases
print "Dumping databases...\n";
foreach (DATABASES as $db => $pwd) {
    print "  $db... ";
    exec("mysqldump -h ".DB_HOST." -u $db -p'$pwd' $db > '$dir_name/{$db}_dump_$date.sql' 2> /dev/null");
    print "done.\n";
}

// Backup files
print "Backing up files...\n";
$exclude_args = "";
foreach (EXCLUDES as $exclude) {
    $exclude_args.="--exclude='$exclude' ";
}
$exclude_args .= "--exclude='".BACKUP_DIR."'";
if (file_exists("/tmp/backup.tgz")) unlink("/tmp/backup.tgz");
exec("tar -cvzf /tmp/backup.tgz $exclude_args ".FILES_DIR." 2> /dev/null");

// Save backup
print "Saving backup...\n";
rename("/tmp/backup.tgz", $dir_name."/"."files_".$date.".tgz");

// Set permissions
print "Setting permissions...\n";
exec("chmod -R 700 '".$dir_name."'");

print "Done.";