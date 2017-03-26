<?php

if ($_GET['hub_mode'] === 'subscribe' && $_GET['hub_verify_token'] === 'my_token') {
    echo $_GET['hub_challenge'];
} else {
    http_response_code(403);
}
