<?php 
namespace system\core\system;

class header
{
    public function location($url)
    {
        $url = empty($url) ? '/' : $url;
        header('Location: ' . $url);
        exit();
    }

    public function code($code = null)
    {
        if($code){
            http_response_code($code);
        }
        return $this;
    }

    public function data($data = null)
    {
        if ($data) {
            $_SESSION['data']  = $data;
        }
        return $this;
    }

    public function error($error = null)
    {
        if ($error) {
            $_SESSION['error']  = $error;
        }
        return $this;
    }
}