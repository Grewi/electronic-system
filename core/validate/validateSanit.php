<?php

namespace system\core\validate;

trait validateSanit
{
    private $list = [
        'onabort',
        'onafterprint',
        'onautocomplete',
        'onautocompleteerror',
        'onbeforeprint',
        'onbeforeunload',
        'onblur',
        'oncancel',
        'oncanplay',
        'oncanplaythrough',
        'onchange',
        'onclick',
        'onclose',
        'oncontextmenu',
        'oncopy',
        'oncuechange',
        'oncut',
        'ondblclick',
        'ondrag',
        'ondragend',
        'ondragenter',
        'ondragexit',
        'ondragleave',
        'ondragover',
        'ondragstart',
        'ondrop',
        'ondurationchange',
        'onemptied',
        'onended',
        'onerror',
        'onfocus',
        'onhashchange',
        'oninput',
        'oninvalid',
        'onkeydown',
        'onkeypress',
        'onkeyup',
        'onload',
        'onloadeddata',
        'onloadedmetadata',
        'onloadstart',
        'onmessage',
        'onmousedown',
        'onmouseenter',
        'onmouseleave',
        'onmousemove',
        'onmouseout',
        'onmouseover',
        'onmouseup',
        'onmousewheel',
        'onwheel',
        'onoffline',
        'ononline',
        'onpagehide',
        'onpageshow',
        'onpaste',
        'onpause',
        'onplay',
        'onplaying',
        'onpopstate',
        'onprogress',
        'onratechange',
        'onreset',
        'onresize',
        'onscroll',
        'onsearch',
        'onseeked',
        'onseeking',
        'onselect',
        'onshow',
        'onsort',
        'onstalled',
        'onstorage',
        'onsubmit',
        'onsuspend',
        'ontimeupdate',
        'ontoggle',
        'onunload',
        'onvolumechange',
        'onwaiting',
        'ontouchstart',
        'ontouchmove',
        'ontouchend',
        'ontouchcancel',
    ];
    public function scriptsDelete()
    {
        $data = $this->data[$this->currentName];
        $data = $this->inline($data);
        $data = $this->script($data);
        $this->setReturn($data);
    }

    private function inline($text)
    {
        //Все теги
        $test = false;
        preg_match_all('/<(.*?) \s*(.*?)\s*>/i', $text, $matches);
        foreach ($matches[2] as $a1 => $tag) {
            foreach ($this->list as $a2 => $i) {
                preg_match_all('/\s*(' . $i . '\s*=\s*\"(.*?)\")\s*/i', $tag, $matches2);
                preg_match_all("/\s*(" . $i . "\s*=\s*\'(.*?)\')\s*/i", $tag, $matches3);
                preg_match_all("/\s*(" . $i . "\s*=\s*\`(.*?)\`)\s*/i", $tag, $matches4);
                $arr = array_merge($matches2, $matches3, $matches4);
                foreach ($arr as $a3 => $i2) {
                    if (!empty($i2)) {
                        $test = true;
                        $str = $matches[0][$a1]; //Полная строка
                        $str2 = str_replace($i2, '', $str); //Изменённая строка
                        $text = str_replace($str, $str2, $text);
                    }
                }
                preg_match_all("/\s*(" . $i . "\s*=\s*\'(.*?)\')\s*/i", $tag, $matches2);
            }
            //Все параметры 
        }
        if ($test) {
            return $this->inline($text);
        } else {
            return $text;
        }
    }

    private function script($text)
    {
        preg_match_all("/\s*\<script(.*?)\<\/script(.*?)\>\s*/i", $text, $matches);
        foreach($matches[0] as $a => $i){
            $text = str_replace($i, '', $text);
        }

        preg_match_all("/\s*\<\/?script(.*?)\>\s*/i", $text, $matches);
        foreach($matches[0] as $a => $i){
            $text = str_replace($i, '', $text);
        }
        return $text;
    }
}
