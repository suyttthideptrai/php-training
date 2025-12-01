<?php
$phpBinary = PHP_BINARY;
require_once __DIR__ . '/linhtinh/Parsedown.php';



function markdown($text) {

    $CODE_DEL = '&&&';
    $EXECUTABLE = '+';

    $Parsedown = new Parsedown();

    if (!str_contains($text, $CODE_DEL)) {
        return $Parsedown->text($text);
    }

    $parts = explode($CODE_DEL, $text);
    $result = '';
    foreach ($parts as $index => $part) {
        if (str_starts_with($parts[$index], $EXECUTABLE)) {
            $trimmed = trim($parts[$index]);
            $code = substr($trimmed, 1);
            $output = exec_use_current_php($code);
            $result .= '<pre><code>' . $output . '</code></pre>';
        } else {
            $result .= $Parsedown->text($parts[$index]);
        }
    }
    return $result;
}

function exec_use_current_php($cmd) {
    global $phpBinary;

    $output = [];
    $returnCode = 0;

    // Process for windows, TODO: unix later
    $cmd = str_replace('"', "'", $cmd);
    $cmd = trim($cmd);
    $cmd = preg_replace('/\r\n|\r|\n/', '', $cmd);

    $mergeCmd = "$phpBinary -r \"$cmd\"";

    // echo "Debug: Full command to execute: " . $mergeCmd . "\n";
    exec($mergeCmd, $output, $returnCode);
    // print_r($output);

    if ($returnCode !== 0) {
        return "Error executing code. Return code: $returnCode";
    }
    return $output[0];
}