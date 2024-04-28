<?php
// Server credentials
$server = 'linux.inf.u-szeged.hu';
$username = 'h879755';
$password = '06303023510a';

echo 'try to connect to SSH server';
// Connect to the SSH server
$connection = ssh2_connect($server);

if (!$connection) {
    die('Connection failed');
}

// Authenticate with the SSH server
if (!ssh2_auth_password($connection, $username, $password)) {
    die('Authentication failed');
}

echo 'Connected to SSH server';

// Now you can execute commands on the server using ssh2_exec() or other SSH functions

// Close the SSH connection
ssh2_disconnect($connection);
?>