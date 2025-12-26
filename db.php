<?php

$envPath = __DIR__ . '/.env';

if (!file_exists($envPath)) {
  die('Environment file not found.');
}

$env = parse_ini_file($envPath);

$con = mysqli_connect(
  $env['DB_HOST'] ?? 'localhost',
  $env['DB_USER'] ?? 'root',
  $env['DB_PASS'] ?? '',
  $env['DB_NAME'] ?? '',
  isset($env['DB_PORT']) ? (int)$env['DB_PORT'] : 3306
);

if (!$con) {
  die('Database connection failed: ' . mysqli_connect_error());
}
