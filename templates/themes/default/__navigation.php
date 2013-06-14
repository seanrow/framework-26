<?php 

Loader::helper("user"); 

$navigation_collapsed = array();
$navigation_collapsed_link = array_fill_keys(array("user", "dashboard", "report", "docs"), "collapsed");
$navigation_collapsed_menu = array_fill_keys(array("user", "dashboard", "report", "docs"), "collapse");

$navigation_collapsed_link[Config::get("controller")] = "";
$navigation_collapsed_menu[Config::get("controller")] = "collapse in";
?> 
<div class="sidebar-nav">
    <center>
        <img src="<?php echo Config::get("base_url"); ?>templates/images/sparrow_logo_square.jpg">
    </center>
    <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>Dashboard</a>
    <ul id="dashboard-menu" class="nav nav-list <?php echo $navigation_collapsed_link["dashboard"]; ?>">
        <li>
            <a href="<?php echo Config::url("dashboard"); ?>">
                <i class="icon icon-home"></i>
                Home
            </a>
        </li>
    </ul>
    
    <a href="#report-menu" class="nav-header <?php echo $navigation_collapsed_link["report"]; ?>" data-toggle="collapse">
        <i class="icon-exclamation-sign"></i>Log Reports <i class="icon-chevron-up"></i></a>
    <ul id="report-menu" class="nav nav-list <?php echo $navigation_collapsed_menu["report"]; ?>">
        <li><a href="<?php echo Config::url("dashboard/logs/outgoing"); ?>">Outgoing Logs</a></li>
        <li><a href="<?php echo Config::url("dashboard/logs/access"); ?>">Access Logs</a></li>
    </ul>

    <a href="#docs-menu" class="nav-header <?php echo $navigation_collapsed_link["docs"]; ?>" data-toggle="collapse">
        <i class="icon-book"></i>API Documentation <i class="icon-chevron-up"></i>
    </a>

    <ul class="nav nav-list <?php echo $navigation_collapsed_menu["docs"]; ?>" id="docs-menu" >
        <li><a href="<?php echo Config::get("base_url"); ?>docs"><i class="icon-cloud"></i>Introduction</a></li>
        <li><a href="<?php echo Config::get("base_url"); ?>docs/outgoing_api"><i class="icon-cloud"></i>Outgoing API</a></li>
        <li><a href="<?php echo Config::get("base_url"); ?>docs/incoming_api"><i class="icon-cloud"></i>Incoming API</a></li>
        <li><a href="<?php echo Config::get("base_url"); ?>docs/outgoing_example"><i class="icon-cloud"></i>Outgoing Example</a></li>
        <li><a href="<?php echo Config::get("base_url"); ?>docs/incoming_example"><i class="icon-cloud"></i>Incoming Example</a></li>
        <li><a href="<?php echo Config::get("base_url"); ?>docs/reply_messages"><i class="icon-cloud"></i>Reply Messages</a></li>
    </ul>
</div>
