<?php

//Запускает проверку прав пользователя
function user_rules($rule, $user_id = null)
{
    return \app\rules\rulesUser::rules($rule, $user_id);
}

function company_rules($rule)
{
    return \app\rules\rulesCompany::rules($rule);
}