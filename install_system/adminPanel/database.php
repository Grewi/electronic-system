<?php
namespace system\install_system\adminPanel;
use system\core\validate\validate;

class database
{
    public static function mysql()
    {
        $sql = file_get_contents(SYSTEM . '/install_system/adminPanel/sql/mysql/admin.sql');
        db()->query($sql);

        $sql = file_get_contents(SYSTEM . '/install_system/adminPanel/sql/mysql/settings.sql');
        db()->query($sql);    
        
        $sql = file_get_contents(SYSTEM . '/install_system/adminPanel/sql/mysql/userRoleData.sql');
        db()->query($sql);    

        $sql = file_get_contents(SYSTEM . '/install_system/adminPanel/sql/mysql/images.sql');
        db()->query($sql);        
    } 

    public static function sqlite()
    {
        $arr = [
            'dataPageGenerator',
            'pageGenerator',
            'settings',
            'settingsCategory',
            'settingsType',
            'userRole',
            'insertSettingsCategory',
            'insertSettingsType',
            'insertUserRole',
            'images',
            'imagesCategories',
            'imageSize',
            'imageSizeInsert',
        ];

        foreach($arr as $i){
            $sql = file_get_contents(SYSTEM . '/install_system/adminPanel/sql/sqlite/' . $i . '.sql');
            db()->query($sql);            
        }         
    } 
}