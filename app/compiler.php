<?php
if (isset($_POST['language'])) {
    $language = strtolower($_POST['language']);
    $code = $_POST['code'];

    $random = substr(md5(mt_rand()), 0, 7);
    $filePath = "temp/" . $random . "." . $language;
    $programFile = fopen($filePath, 'wb');
    fwrite($programFile, $code);
    fclose($programFile);

    switch ($language) {
        case "php":{
            $output = shell_exec("/usr/bin/php $filePath 2>&1");
            break;
        }
        case "python":{
            $output = shell_exec("/usr/bin/python $filePath 2>&1");
            break;
        }
        case "node":{
            rename($filePath, $filePath . ".js");
            $filePath .= '.js';
            $output = shell_exec("/opt/homebrew/opt/node@14/bin/node $filePath 2>&1");
            break;
        }
        case "c" :{
            $outputExe = $random . ".exe";
            shell_exec("gcc $filePath -o $outputExe");
            $output = shell_exec(__DIR__ . "//$outputExe");
            break;
        }
        case "cpp" :{
            $outputExe = $random . ".exe";
            shell_exec("g++ $filePath -o $outputExe");
            $output = shell_exec(__DIR__ . "//$outputExe");
        }
        default:{
            $output = "";
        }
    }
    unlink($filePath);
} else {
    $output = "Invalid data";
}

echo $output;
