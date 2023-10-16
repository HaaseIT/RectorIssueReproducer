<?php

class Baz
{
    public function doSomething() {
        /** @var object|null $bar */
        $bar = $fooo->getBar();
        $bat = $bar->getRelatedId();
    }
}
