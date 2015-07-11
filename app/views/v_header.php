<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/asphaleia/css/bootstrap.css" type="text/css" rel="stylesheet">
    <link href="/asphaleia/css/my.css" type="text/css" rel="stylesheet">
    <?php if ($data == "login") { ?>
        <link href="/asphaleia/css/login.css" type="text/css" rel="stylesheet">
    <?php } ?>
    <script type="text/javascript" data-main="/phpietadmin/js/common" src="/asphaleia/js/lib/require.js"></script>
    <noscript>
        <div class = "container">
            <div class="alert alert-warning" role="alert"><h3 align="center">Warning - JavaScript is disabled. This application won't work correctly!</h3></div>
        </div>
    </noscript>
    <title>phpietadmin</title>
</head>
<body>
<div hidden id="offlinemessage">
    Server connection failed... <img src="/asphaleia/img/ajax-loader.gif">
</div>