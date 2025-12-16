<?php
require 'vendor/autoload.php';
\ = \App\\Models\\User::where('type','company')->first();
if (!\) {
    echo 'no user';
} else {
    echo 'id:' . \->id .  \n;
    print_r(\->roles->pluck('name')->toArray());
}
