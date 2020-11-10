<?php

function decode($param) {
    return json_decode(json_encode($param), true);
}
