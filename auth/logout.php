<?php
session_start();
session_unset();
session_destroy();

header('Location: ../?loggedout');

?>
<script src="../taskido/javascript/visitors.js"></script>
