<?php

$con = mysqli_connect(
    'localhost',
    'root',
    '',
    'motorstart',
    3306
);


if (!$con) {
    die('Database connection failed: ' . mysqli_connect_error());
}
