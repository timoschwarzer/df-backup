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

const FILES_DIR = "/kunden/XXXXXX_XXXXXX/"; // Must be absolute
const BACKUP_DIR = FILES_DIR."backup"; // Directory where backups are stored in

const DB_HOST = "127.0.0.3";
const DATABASES = [
    "dbXXXXXX_1" =>  "password1",
    "dbXXXXXX_2" =>  "password2"
];

const EXCLUDES = [
    "*.log",
    FILES_DIR."someDirectoryToExclude"
];
