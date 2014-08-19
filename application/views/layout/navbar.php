
<nav class="navbard navbar-inverse navbar-embossed navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
        </button>
        <a class="navbar-brand" href="<?php echo site_url(); ?>home/index">The Missing Link</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse-01">
        <?php
            if(isset($this->session->userdata['logged_in'])
                && $this->session->userdata['logged_in'] == 1) {
        ?>
        <ul class="nav navbar-nav">
            <li><a href="<?php echo site_url(); ?>home/index">Dashboard</a></li>
            <li><a href="<?php echo site_url(); ?>links/index/all">Links</a></li>
            <li><a href="<?php echo site_url(); ?>categories/index">Categories</a></li>
            <li><a href="<?php echo site_url(); ?>admin/info">Account</a></li>
            <li><a href="<?php echo site_url(); ?>display/index">Display Control</a></li>
        </ul>
        <?php
            }
        ?>
        <div class="container-fluid">
            <?php
                if(isset($this->session->userdata['logged_in'])
                    && $this->session->userdata['logged_in'] == 1) {
            ?>
                <p class="navbar-text navbar-right">
                    <a href="<?php echo site_url(); ?>home/logout">Sign Out</a>
                </p>
            <?php
                } else {
            ?>
                    <p class="navbar-text navbar-right">
                        <a href="<?php echo site_url(); ?>login">Sign In</a>
                    </p>
            <?php
                }
            ?>
        </div>
    </div>
</nav>
