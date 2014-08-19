<h2>Welcome <?php echo $username; ?></h2>

<?php

    echo $this->session->userdata['username'];
    print_r($this->session->userdata['logged_in']);
    echo $this->session->userdata['id'];

?>
