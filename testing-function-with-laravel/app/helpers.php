<?php

function link_to_by_custom($url, $body, $parameters = null)
{
    // slime
    // return "<a href='http://:/dogs/1'>Show Dog</a>";

    // generalize
    $url = url($url);
    $attributes = $parameters ? HTML::attributes($parameters) : '';

    return "<a href='{$url}'{$attributes}>{$body}</a>";
}

?>