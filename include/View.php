<?php

/**
 * 模板引擎核心
 * 参考&来源：https://segmentfault.com/q/1010000002482919
 */

class view {
    var $tpl_dir = 'template';
    var $cache_dir = 'cache';
    var $tpl_ext = '.html';
    var $var_left = '{';
    var $var_right = '}';
    
    function __construct($config=array())
    {
        if(isset($config['tpl_dir'])) $this->tpl_dir = $config['tpl_dir'];
        if(isset($config['cache_dir'])) $this->cache_dir = $config['cache_dir'];
        if(isset($config['tpl_ext'])) $this->tpl_ext = $config['tpl_ext'];
        if(isset($config['var_left'])) $this->var_left = $config['var_left'];
        if(isset($config['var_right'])) $this->var_right = $config['var_right'];
    }

    function load($tplfilename)
    {
        if (!is_dir($this->cache_dir)) mkdir($this->cache_dir);
        if (!is_dir($this->tpl_dir)) mkdir($this->tpl_dir);

        $tplfile = $this->tpl_dir.'/'.$tplfilename.$this->tpl_ext;
        if(!file_exists($tplfile)) die('Template not found: '.$tplfile);
        return $this->cache($tplfilename, $tplfile);
    }

    //判断模板是否缓存，如模板文件有更改则重新编译
    function cache($tplname, $tpl_file)
    {
        $cache_file = $this->cache_dir.'/'.md5($tplname).'.php';
        if(!file_exists($cache_file) || filemtime($tpl_file)>filemtime($cache_file)){
            $this->compile($tpl_file, $cache_file);
        }
        return $cache_file;
    }

    //编译模板内容到PHP格式，并写入缓存
    function compile($tpl, $cache)
    {
        $body = file_get_contents($tpl);
        $vl = $this->var_left;
        $vr = $this->var_right;
        $patterns = array(
            "#<\?php\s*(.+?)\s*\?>#i", //转义php标签
            "#$vl\s*include=(.+?)\s*$vr#i",
            "#$vl\s*if\s+(.+?)\s*$vr#i",
            "#$vl\s*else\s*$vr#i",
            "#$vl\s*elseif\s+(.+?)\s*$vr#i",
            "#$vl\s*endif\s*$vr#i",
            "#$vl\s*/if\s*$vr#i",
            "#$vl\s*foreach\s+(.+?):(.+?)\s*$vr#i",
            "#$vl\s*endforeach\s*$vr#i",
            "#$vl\s*/foreach\s*$vr#i",
            "#$vl([0-9a-zA-Z_]+?)\.([0-9a-zA-Z_]+?)\.([0-9a-zA-Z_]+?)$vr#i",
            "#$vl([0-9a-zA-Z_]+?)\.([0-9a-zA-Z_]+?)$vr#i",
            "#$vl([0-9a-zA-Z_\[\]\'\"]+?)$vr#i",
            "#$vl([0-9a-zA-Z_]+?):(.*?)$vr#i",
            "#$vl:\s*(.+?)\s*$vr#i", //自定义php代码标签
            "#$vl@\s*(.+?)\s*$vr#i", //echo标签
        );
        $replacements = array(
            "&lt;?php \\1 ?&gt;",
            '<?php include $view->load("\\1"); ?>',
            "<?php if(\\1): ?>",
            "<?php else: ?>",
            "<?php elseif(\\1): ?>",
            "<?php endif; ?>",
            "<?php endif; ?>",
            "<?php if(count($\\1)>0):\$autoindex=0;foreach($\\1 as \\2):\$autoindex++; ?>",
            "<?php endforeach;endif; ?>",
            "<?php endforeach;endif; ?>",
            "<?php echo $\\1['\\2']['\\3']; ?>",
            "<?php echo $\\1['\\2']; ?>",
            "<?php echo $\\1; ?>",
            "<?php echo \\1(\\2); ?>",
            "<?php \\1; ?>",
            "<?php echo \\1; ?>",
        );
        $body = preg_replace($patterns, $replacements, $body);
        file_put_contents($cache, "<?php if(!defined('INVIEW'))die('cache page'); ?>\r\n".$body);
    }
}