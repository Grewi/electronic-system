<?php

namespace system\core\validate;

trait validateSanit
{
    private $list = [
        'onabort','onafterprint','onautocomplete','onautocompleteerror',
        'onbeforeprint','onbeforeunload','onblur','oncancel','oncanplay',
        'oncanplaythrough','onchange','onclick','onclose','oncontextmenu',
        'oncopy','oncuechange','oncut','ondblclick','ondrag','ondragend',
        'ondragenter','ondragexit','ondragleave','ondragover','ondragstart',
        'ondrop','ondurationchange','onemptied','onended','onerror','onfocus',
        'onhashchange','oninput','oninvalid','onkeydown','onkeypress','onkeyup',
        'onload','onloadeddata','onloadedmetadata','onloadstart','onmessage',
        'onmousedown','onmouseenter','onmouseleave','onmousemove','onmouseout',
        'onmouseover','onmouseup','onmousewheel','onwheel','onoffline','ononline',
        'onpagehide','onpageshow','onpaste','onpause','onplay','onplaying','onpopstate',
        'onprogress','onratechange','onreset','onresize','onscroll','onsearch','onseeked',
        'onseeking','onselect','onshow','onsort','onstalled','onstorage','onsubmit',
        'onsuspend','ontimeupdate','ontoggle','onunload','onvolumechange',
        'onwaiting','ontouchstart','ontouchmove','ontouchend','ontouchcancel',
    ];

    private $badTags = [
        'audio','base','bdi','bdo','body','button','canvas','data','datalist','dialog','embed','fieldset',
        'figcaption','form','head','html','iframe','input','label','legend','link','main','map','meta','object',
        'optgroup','option','output','param','ruby','rt','rp','samp','script','select','style','template','textarea',
        'title','var',
    ];

    private $tegs = [
        'a','abbr','address','area','article','aside','b','blockquote','br','caption','cite','code','col',
        'colgroup','dd','del','details','dfn','div','dl','dt','em','figure','footer','h1','h2','h3','h4','h5','h6',
        'header','hr','i','img','ins','kbd','li','mark','meter','nav','noscript','ol','p','picture','pre','progress',
        'q','rb','rtc','s','section','small','source','span','strong','sub','summary','sup','table','tbody','td','tfoot',
        'th','thead','time','tr','track','u','ul','video','wbr',
    ];

    private $badAttr = [
        'accept','accept-charset','accesskey','action','async','autocomplete','autofocus','autoplay','autosave',
        'challenge','charset','checked','code','codebase','content','contenteditable','contextmenu','data','defer',
        'dirname','disabled','draggable','dropzone','enctype','for','form', 'formaction','hreflang','http-equiv',
        'icon','ismap','itemprop','keytype','language','list','low','manifest','max','maxlength','method','min',
        'multiple','name','novalidate','optimum','pattern','pattern','placeholder','radiogroup','readonly','required',
        'rows','sandbox','seamless','selected','sizes','srcdoc','step','type','usemap','value','wrap'
    ];

    private $attr = [
        'align','alt','bgcolor','border','buffered','cite','class','color','cols','colspan','controls','coords',
        'datetime','default','dir','download','headers','height','hidden','high','href','id','kind','label','lang',
        'loop','media','open','ping','poster','preload','pubdate','rel','reversed','rowspan','spellcheck','scope',
        'scoped','shape','size','span','src','srclang','srcset','start','style','summary','tabindex','target','title',
        'width',
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
