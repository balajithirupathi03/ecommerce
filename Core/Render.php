<?php

trait Render
{
    public function render($redirctPath, $message)
    {
        require 'Public/View/Html/' . $redirctPath . '.php';
    }
}
