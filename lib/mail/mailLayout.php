<?php 
namespace system\lib\mail;

trait mailLayout 
{
    private $data;

    public function layout(string $name, $data = null)
    {
        $this->data = $data;
        $layout = db()->fetch('SELECT * FROM `mail_layout` WHERE `name` = "' . $name . '"', []);
        if($layout){
            $this->subject = $this->view(htmlspecialchars_decode($layout->subject));
            $this->body = $this->view(htmlspecialchars_decode($layout->body));            
        }else{
            db()->query('INSERT INTO `mail_layout` (`name`,`subject`,`body`,`description`) VALUES ("' . $name . '","---","---",NULL)', []);
        }
        return $this;
    }

    private function view($str)
    {
        if(!$this->data){
            return $str;
        }

        preg_match_all('/\{\{\s*\$(.*?)\s*\}\}?/si', $str, $matches);
        foreach ($matches[1] as $a => $i) {
            $str = str_replace($matches[0][$a], isset($this->data[$i]) ? $this->data[$i] : '', $str);
        }
        return $str;
    }
}