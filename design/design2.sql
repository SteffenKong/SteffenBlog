create database if not exists blog charset=utf8;

use blog;


-- 管理员
create table if not exists blog_admin(
    id mediumint unsigned not null auto_increment,
    account varchar(191) not null comment '用户名',
    password varchar(191) not null comment '密码',
    status tinyint not null comment '状态值 0 - 禁用 1 - 启用',
    is_admin tinyint not null comment '是否为管理员 0 - 不是  1 - 是',
    created_at datetime,
    updated_at datetime,
    primary key (id),
    unique key uk_account(account),
    index idx_status(status)
)charset=utf8,engine=innodb;

-- 管理员信息附属表
create table if not exists blog_admin_info(
    id mediumint unsigned not null auto_increment,
    user_id mediumint unsigned not null comment '用户id',
    email varchar(191)  comment '邮箱',
    phone varchar(32)  comment '电话号码',
    last_login_ip varchar(191) comment '上次登录的ip',
    last_login_time datetime comment '上次登录时间',
    created_at datetime,
    updated_at datetime,
    primary key (id),
    index idx_user_id(user_id)
)charset=utf8,engine=innodb;

-- 管理员角色中间表
create table if not exists blog_role_admin(
    id mediumint unsigned not null auto_increment,
    role_id mediumint unsigned not null comment '角色id',
    admin_id mediumint unsigned not null comment '管理员id',
    created_at datetime,
    updated_at datetime,
    primary key (id),
    index idx_role_id(role_id),
    index idx_admin_id(admin_id)
)charset=utf8,engine=innodb;

-- 角色表
create table if not exists blog_role(
    id mediumint unsigned not null auto_increment,
    role_name varchar(191) not null comment '角色名称',
    description text not null comment '描述',
    created_at datetime,
    updated_at datetime,
    primary key (id),
    unique key uk_role_name(role_name)
)charset=utf8,engine=innodb;

-- 角色权限表
create table if not exists blog_role_permission(
    id mediumint unsigned not null auto_increment,
    role_id mediumint unsigned not null comment '角色id'
    permission_id mediumint unsigned not null comment '权限id',
    created_at datetime,
    updated_at datetime,
    primary key(id),
    index idx_role_id (role_id),
    index idx_permission_id (permission_id)
)charset=utf8,engine=innodb;


-- 权限表
create table if not exists blog_permission(
    id mediumint unsigned not null auto_increment,
    permission_name varchar(191) not null comment '权限名',
    parent_id mediumint default 0 comment '父级权限id',
    url varchar(191) comment '路由url',
    method varchar(191) no null comment '请求方法',
    created_at datetime,
    updated_at datetime,
    primary key(id),
    index idx_parent_id(parent_id),
    index idx_method(method),
)charset=utf8,engine=innodb;

-- 博客导航栏表
create table if not exists blog_nav(
    id mediumint unsigned not null auto_increment,
    title varchar(191) not null comment '导航名',
    description text not null comment '导航描述',
    url varchar(191) comment '导航栏跳转的url',
    is_break tinyint not null comment '是否可以跳转',
    status tinyint not null default 1  comment '状态 0 - 启用 1 - 禁用',
    created_at datetime,
    updated_at datetime,
    primary key (id),
    unique key uk_title(title),
    unique key uk_url(url),
    index idx_status (status)
    index idx_is_break (is_break)
)charset=utf8,engine=innodb;

-- 文章分类表(管理员操作)
create table if not exists blog_cate(
    id mediumint unsigned not null auto_increment,
    cate_name varchar(191) not null comment '分类名',
    parent_id mediumint unsigned default 0 comment '父级菜单'
    status tinyint default 0 comment '是否启用 0 - 禁用 1 - 启用',
    cate_parent_str varchar(191) not null comment 'json字符串，存储上级以及本级的分类'
    created_at datetime,
    update_at datetime,
    primary key (id),
    unique key uk_cate_name(cate_name),
)charset=utf8,engine=innodb;


-- 文章标签
create table if not exists blog_tags(
    id mediumint unsigned not null auto_increment,
    tag_name varchar(191) not null comment '标签名',
    created_at datetime,
    updated_at datetime,
    primary key (id),
    unique key uk_tag_name(tag_name)
)charset=utf8,engine=innodb;

-- 前台用户
create table if not exists blog_user(
    id mediumint unsigned not null auto_increment,
    account varchar(191) not null comment '用户昵称',
    password varchar(191) not null comment '用户密码',
    status tinyint  default 0 comment '状态 0 - 禁用 1 - 启用',
    is_active tinyint default 0 comment '是否启用 0 - 未激活 1 - 已激活',
    created_at datetime,
    updated_at datetime,
    primary key (id),
    unique key uk_account(account),
    is_delete tinyint not null default 0 comment '删除状态 0 - 未删除 1 - 已删除',
    index idx_status(status),
    index idx_is_delete(is_delete),
    index idx_is_active(is_active)
)charset=utf8,engine=innodb;

-- 用户信息副属表
create table if not exists blog_user_info(
    id mediumint unsigned not null auto_increment,
    user_id mediumint unsigned not null comment '用户id',
    verify_code varchar(191) not null comment '校验字符',
    gender tinyint not null comment '性别 0 - 女 1 - 男',
    image varchar(191) not null comment '头像大图',
    small_image varchar(191) not null comment '头像小图',
    phone varchar(32) not null comment '手机号码',
    email varchar(191) not null comment '邮箱',
    realName varchar(191) not null comment '用户真实姓名',
    address varchar(191)  comment '家庭地址',
    created_at datetime,
    updated_at datetime,
    primary key (id),
    unique key uk_phone (phone),
    unique key uk_email (email),
    unique key uk_nickname (nickname),
    index idx_user_id(user_id)
)charset=utf8,engine=innodb;

-- 文章表
create table if not exists blog_article(
    id mediumint unsigned not null auto_increment,
    title varchar(255) not null comment '文章详情',
    description text not null comment '文章简介',
    user_id mediumint unsigned not null comment '用户id',
    image varchar(191) not null comment '文章大图',
    small_image varchar(191) not null comment '文章缩略图',
    manager_id mediumint unsigned not null comment '审核人id',
    click int unsigned not null comment '阅读量',
    is_rec tinyint unsigned not null comment '是否推荐 0 - 不是 1 - 是',
    is_hot tinyint unsigned not null comment '是否热门 0 - 不是 1 - 是',
    public_mode tinyint not null comment '发布形式 1 - 公开 2 - 私密',
    status tinyint default 0 comment '状态 0 - 可查看 1 - 不可查看',
    is_verify tinyint default 0 comment '审核状态 0 - 待审核  1 - 不通过 2 - 通过',
    public_time datetime comment '提交时间',
    is_delete tinyint not null default 0 comment '删除状态 0 - 未删除 1 - 已删除',
    created_at datetime,
    updated_at datetime,
    primary key (id),
    index idx_user_id (user_id),
    index idx_status (status),
    index idx_is_delete (is_delete),
    index idx_is_verify (is_verify)
)charset=utf8,engine=innodb;


-- 文章标签中间表
create table if not exists blog_article_tag(
    id mediumint unsigned not null auto_increment,
    article  mediumint unsigned not null comment '文章id',
    tag_id mediumint unsigned not null comment '标签id',
    created_at datetime,
    updated_at datetime,
    primary key (id),
)charset=utf8,engine=innodb;


-- 文章分类中间表
create table if not exists blog_article_cate(
    id mediumint unsigned not null auto_increment,
    article mediumint unsigned not null comment '文章id',
    cate_id mediumint unsigned not null comment '分类id',
    created_at datetime,
    updated_at datetime,
    primary key (id),
)charset=utf8,engine=innodb;


-- 文章详情表
create table if not exists blog_article_details(
    id mediumint unsigned not null auto_increment,
    article_id mediumint unsigned not null comment '文章id',
    content text not null comment '文章内容',
    created_at datetime,
    updated_at datetime,
    primary key(id),
    index idx_article_id (article_id)
)charset=utf8,engine=innodb;


-- 管理员登录日志表
create table if not exists blog_admin_login_log(
    id mediumint unsigned not null,
    admin_id mediumint unsigned not null comment '管理员id',
    ip int not null comment '登录ip',
    login_count int not null comment '每天的登录次数',
    params varchar(191) not null comment '请求参数',
    created_at datetime,
    updated_at datetime,
    primary key(id)
)charset=utf8,engine=innodb;


-- 前台用户登录日志表
create table if not exist blog_user_login_log(
    id mediumint unsigned no null auto_increment,
    user_id mediumint unsigned not null comment '用户id',
    ip int not null comment '登录ip',
    login_count int not null comment '每天的登录次数',
    params varchar(191) not null comment '请求参数',
    created_at datetime,
    updated_at datetime,
    primary key(id)
)charset=utf8,engine=innodb;


-- 邮箱发送表
create table if not exists blog_site_email_message(
    id mediumint unsigned not null auto_increment,
    send_email varchar(191) not null comment '发送的邮箱',
    re_email varchar(191) not null comment '接受的邮箱',
    content text not null comment '发送内容',
    is_read tinyint not null comment '状态 0 - 已读 1 - 未读',
    created_at datetime,
    updated_at datetime,
    primary key(id),
    index idx_is_read(is_read)
)charset=utf8,engine=innodb;


-- 友情链接
create table if not exists blog_link(
     id mediumint unsigned not null auto_increment,
     name varchar(191) not null comment '友情名称',
     url varchar(191) not null comment '友情链接',
     sort int default 50 comment '排序',
     is_rec tinyint not null comment '是否推荐',
     is_delete tinyint default 0 comment '删除状态 0 - 未删除 1 - 已删除',
     created_at datetime,
     updated_at datetime,
     primary key(id),
     unique key uk_name(name)
     unique key uk_url(url)
)charset=utf8,engine=innodb;

-- 管理员操作日志
create table if not exists blog_admin_logs(
    id mediumint unsigned not null auto_increment,
    account mediumint unsigned not null comment '管理员帐号',
    action varchar(191) not null comment '操作动作',
    route varchar(191) not null comment '路由',
    method varchar(191) not null comment '操作方法',
    params text not null comment '请求参数',
    created_at datetime,
    updated_at datetime,
    primary key(id)
)charset=utf8,engine=innodb;

-- 前台用户操作日志
create table if not exists blog_user_logs(
    id mediumint unsigned not null auto_increment,
    account mediumint unsigned not null comment '管理员帐号',
    action varchar(191) not null comment '操作动作',
    route varchar(191) not null comment '路由',
    method varchar(191) not null comment '操作方法',
    params text not null comment '请求参数',
    created_at datetime,
    updated_at datetime,
    primary key(id)
)charset=utf8,engine=innodb;


-- 短信发送表
create table if not exists blog_site_sms_message(

)charset=utf8,engine=innodb;
