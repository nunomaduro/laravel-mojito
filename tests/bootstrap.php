<?php

use Tests\FakeView;

function view(string $name, array $_a, array $_b): FakeView
{
    return new FakeView($name);
}
