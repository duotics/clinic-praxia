<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{$title}</title>
    <meta name="author" content="{$author}">
    <meta name="description" content="{$description}">
    <link rel="shortcut icon" href="{$favicon}" type="image/x-icon">
    {if isset($bodyBg)}
        <style>
            .body-login {
                background-image: url("{$bodyBg}");
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }
        </style>
    {/if}
{$styles}
</head>
<body class="{$bodyClass}">
    {$scripts}
