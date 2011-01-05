<?php

/**
 * 表单配置
 */
return array(
    // 网站设置
    'site' => array(
        'webname' => array(
            'label' => '网站名称',
            'type' => 'text', // text,password,textarea,option,checkbox
            'name' => 'webname', // 表单的name，提交时用的字段
            'desc' => '将用于整站范围内需要显示网站名称的位置', // 表单的附加说明，部分表单会有此项
        ),
        'basehost' => array(
            'label' => '网站根地址',
            'type' => 'text',
            'name' => 'basehost',
            'value' => '/',
        ),
        'indexurl' => array(
            'label' => '首页地址',
            'type' => 'text',
            'name' => 'indexurl',
            'value' => '/',
        ),
        'default_style' => array(
            'label' => '默认风格',
            'type' => 'text',
            'name' => 'default_style',
            'desc' => '为空时使用系统默认模板',
        ),
        'copyright' => array(
            'label' => '版权声明',
            'type' => 'text',
            'name' => 'copyright',
        ),
        'keywords' => array(
            'label' => '关键词',
            'type' => 'text',
            'name' => 'keywords',
            'desc' => '将会用于meta keyword标签中，供搜索引擎索引',
            'value' => '',
            'message' => '',
            'min_len' => 0,
            'max_len' => 100,
        ),
        'description' => array(
            'label' => '网站说明',
            'type' => 'textarea',
            'name' => 'description',
            'desc' => '将会用于meta description标签中，供搜索引擎索引',
            'value' => '',
            'message' => '',
            'min_len' => 0,
            'max_len' => 200,
        ),
        'beian' => array(
            'label' => '备案号',
            'type' => 'text',
            'name' => 'beian',
            'desc' => '没有则不填',
        ),
    ),
    // 缓存设置
    'cache' => array(
        'is_open' => array(
            'label' => '是否启用缓存',
            'name' => 'is_open',
            'type' => 'select',
            'value' => array(
                'select' => '0',
                'data' => array(
                    '0' => '关闭',
                    '1' => '启用',
                ),
            ),
        ),
        'driver' => array(
            'label' => '缓存组件',
            'name' => 'driver',
            'type' => 'select',
            'value' => array(
                'select' => 'apc',
                'data' => array(
                    'apc' => 'APC',
                    'sqlite' => 'sqlite',
                    'file' => '文件',
                ),
            ),
        ),
    ),
    // 图片上传设置
    'up_img' => array(
        'path' => array(
            'label' => '保存路径',
            'name' => 'path',
            'type' => 'text',
            'desc' => '相对于程序目录的路径',
            'value' => '/upload/img',
        ),
        'max_size' => array(
            'label' => '图片大小最大值',
            'name' => 'max_size',
            'type' => 'text',
            'desc' => '单位KB',
            'value' => '1024',
        ),
        'min_size' => array(
            'label' => '图片大小最小值',
            'name' => 'min_size',
            'type' => 'text',
            'desc' => '单位KB',
            'value' => '0',
        ),
        'max_width' => array(
            'label' => '图片宽度最大值',
            'name' => 'max_width',
            'type' => 'text',
            'desc' => '单位PX',
            'value' => '0',
        ),
        'max_height' => array(
            'label' => '图片高度最大值',
            'name' => 'max_height',
            'type' => 'text',
            'desc' => '单位PX',
            'value' => '0',
        ),
        'type' => array(
            'label' => '允许的图片类型',
            'name' => 'type',
            'type' => 'text',
            'desc' => '多个后缀用逗号分隔，如：jpg,gif,png',
            'value' => 'jpg,jpeg,png,gif,bmp',
        ),
        'watermark_status' => array(
            'label' => '水印启用状态',
            'name' => 'watermark_status',
            'type' => 'select',
            'value' => array(
                'select' => '0',
                'data' => array(
                    '0' => '关闭',
                    '1' => '开启',
                ),
            ),
        ),
        'watermark_path' => array(
            'label' => '水印图片路径',
            'name' => 'watermark_path',
            'type' => 'text',
            'value' => 'http://daxiniu.cms/assets/admin/img/logo.png',
        ),
        'watermark_position' => array(
            'label' => '水印位置',
            'name' => 'watermark_position',
            'type' => 'text',
            'desc' => '图片水印位置 1上左 |2上中|3上右|4中左 |5中中|6中右|7下左 |8下中|9下右',
            'value' => '9',
        ),
        'watermark_opacity' => array(
            'label' => '水印透明度',
            'name' => 'watermark_opacity',
            'type' => 'text',
            'desc' => '图片水印透明度',
            'value' => '70',
        ),
        'watermark_border_space' => array(
            'label' => '水印边距',
            'name' => 'watermark_border_space',
            'type' => 'text',
            'desc' => '水印与边框距离 单位：PX',
            'value' => '10',
        ),
    ),
    // 文件上传设置
    'up_file' => array(
        'path' => array(
            'label' => '保存路径',
            'type' => 'text',
            'name' => 'path',
            'desc' => '相对于程序目录的路径',
            'value' => '/upload/file',
        ),
        'max_size' => array(
            'label' => '文件大小最大值',
            'name' => 'max_size',
            'type' => 'text',
            'desc' => '单位KB',
            'value' => '2048',
        ),
        'min_size' => array(
            'label' => '文件大小最小值',
            'name' => 'min_size',
            'type' => 'text',
            'desc' => '单位KB',
            'value' => '0',
        ),
        'type' => array(
            'label' => '允许的文件类型',
            'name' => 'type',
            'type' => 'text',
            'desc' => '多个后缀用逗号分隔，如：doc,pdf,zip,rar',
            'value' => 'doc,pdf,zip,rar,7z,ppt,csv',
        ),
    ),
    // 用户设置
    'user' => array(
        'reg_open' => array(
            'label' => '是否开启注册',
            'type' => 'select',
            'name' => 'reg_open',
            'value' => array(
                'select' => '1',
                'data' => array(
                    '0' => '关闭',
                    '1' => '开启',
                ),
            ),
        ),
        'default_avatar' => array(
            'label' => '默认用户头像路径',
            'type' => 'text',
            'name' => 'default_avatar',
            'value' => '',
        ),
        'up_avatar.path' => array(
            'label' => '头像上传路径',
            'type' => 'text',
            'name' => 'up_avatar.path',
            'value' => '/upload/avatar',
        ),
        'up_avatar.max_size' => array(
            'label' => '头像大小最大值',
            'name' => 'up_avatar.max_size',
            'type' => 'text',
            'desc' => '单位KB',
            'value' => '1024',
        ),
        'up_avatar.min_size' => array(
            'label' => '头像大小最小值',
            'name' => 'up_avatar.min_size',
            'type' => 'text',
            'desc' => '单位KB',
            'value' => '0',
        ),
        'up_avatar.max_width' => array(
            'label' => '头像宽度最大值',
            'name' => 'up_avatar.max_width',
            'type' => 'text',
            'desc' => '单位PX',
            'value' => '0',
        ),
        'up_avatar.max_height' => array(
            'label' => '头像高度最大值',
            'name' => 'up_avatar.max_height',
            'type' => 'text',
            'desc' => '单位PX',
            'value' => '0',
        ),
        'up_avatar.type' => array(
            'label' => '头像图片允许的类型',
            'name' => 'up_avatar.type',
            'type' => 'text',
            'desc' => '多个后缀用逗号分隔，如：jpg,gif,png',
            'value' => 'jpg,jpeg,png,gif,bmp',
        ),
        'up_avatar.watermark_status' => array(
            'label' => '头像水印启用状态',
            'name' => 'up_avatar.watermark_status',
            'type' => 'select',
            'value' => array(
                'select' => '0',
                'data' => array(
                    '0' => '关闭',
                    '1' => '开启',
                ),
            ),
        ),
        'up_avatar.watermark_path' => array(
            'label' => '头像水印图片路径',
            'name' => 'up_avatar.watermark_path',
            'type' => 'text',
            'value' => 'http://daxiniu.cms/assets/admin/img/logo.png',
        ),
        'up_avatar.watermark_position' => array(
            'label' => '头像水印位置',
            'name' => 'up_avatar.watermark_position',
            'type' => 'text',
            'desc' => '图片水印位置 1上左 |2上中|3上右|4中左 |5中中|6中右|7下左 |8下中|9下右',
            'value' => '9',
        ),
        'up_avatar.watermark_opacity' => array(
            'label' => '头像水印透明度',
            'name' => 'up_avatar.watermark_opacity',
            'type' => 'text',
            'desc' => '图片水印透明度',
            'value' => '70',
        ),
        'up_avatar.watermark_border_space' => array(
            'label' => '头像水印边距',
            'name' => 'up_avatar.watermark_border_space',
            'type' => 'text',
            'desc' => '水印与边框距离 单位：PX',
            'value' => '10',
        ),
    ),
    // 文章设置
    'post' => array(
        'title_repeat' => array(
            'label' => '是否允许标题重复',
            'type' => 'select',
            'name' => 'title_repeat',
            'value' => array(
                'select' => '1',
                'data' => array(
                    '0' => '不允许',
                    '1' => '允许',
                ),
            ),
        ),
        'retrial' => array(
            'label' => '是否需要审核',
            'type' => 'select',
            'name' => 'retrial',
            'value' => array(
                'select' => '0',
                'data' => array(
                    '0' => '需要审核后通过系统自动发布',
                    '1' => '不需要审核直接发布',
                ),
            ),
        ),
    ),
    // 高级设置
    'advanced' => array(
        'throw_exception' => array(
            'label' => '异常输出方式',
            'type' => 'select',
            'name' => 'throw_exception',
            'value' => array(
                'select' => 'NULL',
                'data' => array(
                    'NULL' => '不输出',
                    'FILE' => '输出到文件',
                    'WEB' => '输出到Web视图',
                    'THROW' => '直接抛出',
                ),
            ),
        ),
    ),
);
?>
