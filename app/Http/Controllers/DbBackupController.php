<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Auth;

class DbBackupController extends Controller
{
    public function backup()
{
    $fileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    $backupPath = storage_path('app/backups/' . $fileName);

    // Replace these variables with your database credentials
    $dbUser = env('DB_USERNAME');
    $dbPassword = env('DB_PASSWORD');
    $dbName = env('DB_DATABASE');

    // Execute mysqldump command with output redirection
    $command = sprintf(
        'mysqldump -u%s -p%s %s > %s',
        escapeshellarg($dbUser),
        escapeshellarg($dbPassword),
        escapeshellarg($dbName),
        escapeshellarg($backupPath)
    );

    // Set a longer timeout for the process (in seconds)
    $timeout = 3600; // 10 minutes timeout

    try {
        $process = Process::fromShellCommandline($command);
        $process->setTimeout($timeout);
        $process->mustRun();

        // Optionally, handle success here
        echo 'Database backup successful.';
    } catch (ProcessFailedException $exception) {
        // Handle or display error message
        echo 'Database backup failed: ' . $exception->getMessage();
    }
}
//     public function backup()
// {
//     $fileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql.gz';
//     $backupPath = storage_path('app/backups/' . $fileName);

//     // Replace these variables with your database credentials
//     $dbUser = env('DB_USERNAME');
//     $dbPassword = env('DB_PASSWORD');
//     $dbName = env('DB_DATABASE');

//     // Execute mysqldump command with compression
//     $process = new Process([
//         'mysqldump',
//         '-u' . $dbUser,
//         '-p' . $dbPassword,
//         '--single-transaction', // Optional: Use transactions for consistent backup
//         '--quick', // Optional: Speeds up dumping of tables
//         '--compress', // Optional: Compress the backup output
//         $dbName,
//     ]);

//     // Set a longer timeout for the process (in seconds)
//     $process->setTimeout(600); // 10 minutes timeout

//     try {
//         // Pipe the output through gzip and save to file
//         $process->setOutput($backupPath);
//         $process->mustRun();

//         // Optionally, handle success here
//         echo 'Database backup successful.';
//     } catch (ProcessFailedException $exception) {
//         // Handle or display error message
//         echo 'Database backup failed: ' . $exception->getMessage();
//     }
// }

}
