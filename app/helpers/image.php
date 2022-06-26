<?php
function delete_image($url) {
    if (unlink($url)) {
        return true;
    }
    return false;
}