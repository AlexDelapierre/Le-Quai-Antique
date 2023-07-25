<?php
$subject = getcwd();
$to="alexandredelapierre@gmail.com";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

$gitstatus = shell_exec("git status -s");
$gitstatus = !empty($gitstatus) ? "<h3>git status</h3>".$gitstatus : "";
$gitreset = "";

if(!empty($gitstatus)){
  $gitreset = shell_exec("git reset --hard");
  $gitreset = !empty($gitreset) ? "<h3>git reset</h3>".$gitreset : "";
}

$gitpull = "<h3>git pull</h3>".shell_exec("git pull -v");
$message = nl2br($gitstatus.$gitreset.$gitpull);

print("<h1>$subject</h1>");
print(nl2br($message));
mail($to, $subject, $message, $headers);