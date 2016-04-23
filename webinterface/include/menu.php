<ul class="sidebar-menu">
<li class="header">FEATURE</li>
<li class="<?php echo ($_SERVER['PHP_SELF'] == "/commands.php" ? "" : "in")?>active"><a href="commands.php"><i class="fa fa-exclamation"></i> <span>Commands</span></a></li>
<li class="<?php echo ($_SERVER['PHP_SELF'] == "/users.php" ? "" : "in")?>active"><a href="users.php"><i class="fa fa-users"></i> <span>Users</span></a></li>
<li class="<?php echo ($_SERVER['PHP_SELF'] == "/filter.php" ? "" : "in")?>active"><a href="filter.php"><i class="fa fa-ban"></i> <span>Anti-Spam</span></a></li>
    <li class="<?php echo($_SERVER['PHP_SELF'] == "/quotes.php" ? "" : "in") ?>active"><a href="quotes.php"><i class="fa fa-quote-right"></i> <span>Quotes</span></a></li>
    <li class="<?php echo($_SERVER['PHP_SELF'] == "/items.php" ? "" : "in") ?>active"><a href="items.php"><i class="fa fa-list"></i> <span>Items</span></a></li>
<li class="<?php echo($_SERVER['PHP_SELF'] == "/botsettings.php" ? "" : "in") ?>active"><a href="botsettings.php"><i class="fa fa-wrench"></i> <span>Settings</span></a></li>
</ul><!-- /.sidebar-menu -->
<?php include 'function/togglebot.php'; ?>
</section>
<!-- <li class="treeview">
    <a href="#"><i class="fa fa-ban"></i> <span>Anti-Spam</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="#">Linkfilter</a></li>
        <li><a href="#">Blacklist Words</a></li>
    </ul>
</li>
-->