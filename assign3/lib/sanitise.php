<?php
    function sanitise($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }
?>