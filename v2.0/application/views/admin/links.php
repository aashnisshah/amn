<?php
    if(isset($status)) {
        echo $status;
    }
?>

    <a href="<?php echo site_url("links/index/all"); ?>">
        <button id="addLinkButton" class="btn btn-info btn-lg" type="button">
            All
        </button>
    </a>
    <a href="<?php echo site_url("links/index/pending"); ?>">
        <button id="addLinkButton" class="btn btn-info btn-lg" type="button">
            Pending
        </button>
    </a>
    <a href="<?php echo site_url("links/index/accepted"); ?>">
        <button id="addLinkButton" class="btn btn-info btn-lg" type="button">
            Accepted
        </button>
    </a>
    <a href="<?php echo site_url("links/index/rejected"); ?>">
        <button id="addLinkButton" class="btn btn-info btn-lg" type="button">
            Rejected
        </button>
    </a>
    <a href="<?php echo site_url("links/index/inactive"); ?>">
        <button id="addLinkButton" class="btn btn-info btn-lg" type="button">
            Inactive
        </button>
    </a>

    <h2><?php echo ucfirst($header); ?> Links</h2>
