<?php


    function adminer_object()
    {
        class AdminerSoftware extends Adminer
        {
            function login($login, $password)
            {
                return ($login == 'admin' && $password == '');
            }
        }

        return new AdminerSoftware;
    }

    include __DIR__ . '/adminer.php';

