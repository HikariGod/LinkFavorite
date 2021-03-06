<?php
/*===功能设置===*/
define('TARGET_BLANK',true); //是否新页面打开

/*===数据库设置===*/
define('DATABASE_HOST','localhost'); //数据库地址
define('DATABASE_USER','root'); //数据库用户
define('DATABASE_PASS','root'); //数据库密码
define('DATABASE_DB','link_favorites'); //数据库名
define('DATABASE_PREFIX','link_'); //数据库前缀

/*===身份验证设置===*/
/**
 * 身份验证类型：
 * NONE为无验证（强烈警告！无验证所有人都能直接编辑删除！）
 * PASSWORD为密码
 * GOOGLE为谷歌身份验证器
 */
define('VERIFY_TYPE', 'PASSWORD');
define('PASSWORD','123456'); //密码（当启用密码验证模式才有效）
define('SECRET','EB5Q1IFMCFAIYQMD'); //密钥secret
define('EXPIRED_TIME',60); //2为1分钟 60为30分钟

/*===页面设置===*/
define('INDEX_PAGE','index.php'); //主页文件名
define('ADD_PAGE','add.php'); //添加修改页文件名
define('EDIT_PAGE','edit.php'); //添加修改页文件名

//连接不上数据库的警告语
define('DATABASE_ERROR', <<<EOT
<html>
    <head>
        <meta charset="utf-8">
        <title>网站维护中</title>
        <style>
            html{
                *overflow:auto;
                _overflow-x:hidden;
                -webkit-text-size-adjust:none;
                height:100%;
                background:#80CBF3
            }
            body{
                margin:0; 
                height:100%;
                font-family:"Microsoft YaHei",tahoma,arial,simsun;
            }
            p,h1,h2,h3,h4{ 
                margin-top:0; 
                margin-bottom:0;
            }
            .main{ 
                width:900px; 
                margin:0 auto;
            }
            .container{ 
                padding-left:300px; 
                padding-top:180px;
            }
            h1{ 
                font-size:42px;
            }
            h2{ 
                font-size:22px; 
                font-weight:100; 
                margin-top:2px; 
                margin-bottom:2px;
            }
            .Countdown{ 
                padding-top: 30px; 
                font-size:30px; 
                font-family: tahoma,arial,simsun; 
                color: #4A4A4A;
            }
            .Countdown span{ 
                display:inline-block;
                *display:inline;*zoom:1; 
                width:auto;
                line-height:55px;
                text-align:center;
                margin-left:2px;
            }
            .Countdown .bd{ 
                width:16px; 
                background-image:none;
            }
        </style>
    </head>
    
    <body>
        <div class="main">
            <div class="container">
                <div class="content">
                    <h1>网站正在维护中...</h1>
                    <h2>我们将尽快恢复正常访问</h2>
                </div>
            </div>
        </div>
    </body>
</html>
EOT
);
