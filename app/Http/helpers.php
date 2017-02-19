<?php

function account()
{
     return (object) config("account");
}

/**
 * Truncate all the database tables. 
 * @throws \Exception if APP_DEBUG is 'false' in ../.env
 * @param array $models array of all the models to truncate
 */
function resetDatabase(array $models = [App\Transaction::class, App\Transfert::class, App\Value::class])
{
    if(config('app')['debug'] === false)
        throw new \Exception('ERROR: clearDB() in ../app/Http/helpers.php shouldn\'t be called when APP_DEBUG is \'false\' in ../.env.');

    foreach($models as $m)
        $m::truncate();

    \App\Value::set(account()->base_value);
}