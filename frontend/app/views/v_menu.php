<div class = "navbar navbar-inverse navbar-fixed-top" id="mainmenu">
    <div class = "container">
        <div class="navbar-header">
            <a href = "#" class = "navbar-brand hidden-sm hidden-md">Asphaleia</a>

            <button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
                <span class = "icon-bar"></span>
                <span class = "icon-bar"></span>
                <span class = "icon-bar"></span>
            </button>
        </div>
        <div class = "collapse navbar-collapse navHeaderCollapse">
            <ul class = "nav navbar-nav navbar-right">
                <li class='hidden-sm hidden-md'><a><img hidden id="ajaxloader" src="/asphaleia/img/ajax-loader.gif"></a></li>

                <li><a id="menudashboard" class="workspacetab" href='/asphaleia/dashboard'><span class="glyphicon glyphicon-dashboard"></span> <span class='hidden-sm hidden-md'>Dashboard</span></a></li>

                <li><a id="menuaddressobjects" class="workspacetab" href='/asphaleia/addressobjects'><span class="glyphicon glyphicon-dashboard"></span> <span class='hidden-sm hidden-md'>Address-Objects</span></a></li>

                <li class = "dropdown">
                    <a href='#' id="menuconfig" class = "dropdown-toggle" data-toggle = "dropdown"><span class="glyphicon glyphicon-off"></span> <b class = "caret"></b></a>
                    <ul class = "dropdown-menu">
                        <li><a href='/asphaleia/auth/logout'><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                        <li><a id="menushutdownbutton" href='/asphaleia/service/hold'><span class="glyphicon glyphicon-off"></span> Shutdown</a></li>
                        <li><a id="menurebootbutton" href='/asphaleia/service/hold'><span class="glyphicon glyphicon-repeat"></span> Reboot</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<div id="workspace"></div>

<script>
    require(['common'],function(methods) {
        methods.common();
    });
</script>