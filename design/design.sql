create database if not exists blog charset=utf8;

use blog;

-- 后台管理员
create table if not exists blog_admin(
    id mediumint unsigned auto_increment not null,
    account varchar(191) not null comment '帐号',
    password varchar(191)  not null comment '密码',
    image varchar(191) not null comment '头像',
    small_image varchar(191) not null comment '头像缩略图',
    status tinyint not null default 1 comment '0 - 禁用　1 - 启用',
    email varchar(191) not null comment '管理员邮箱',
    tel varchar(19) not null comment '电话号码',
    created_at datetime,
    updated_at datetime,
    primary key (id),
    unique key uk_account(account),
    index idx_status (status),
    index idx_email (email),
    index idx_tel (tel)
)charset=utf8,engine=innodb;

-- 导航栏
create table if not exists blog_nav(
    id mediumint unsigned auto_increment,
    name varchar(32) not null comment '导航菜单名',
    description text not null comment '分类描述',
    is_selected tinyint not null comment '是否下拉',
    pid mediumint unsigned comment '父导航id',
    status tinyint not null comment '是否启用 0 - 禁用 1 - 启用',
    created_at datetime,
    updated_at datetime,
    primary key(id),
    unique key uk_name(name),
    key idx_is_selected (is_selected),
    key idx_pid (pid),
    key idx_status (status)
)charset=utf8,engine=innodb;

-- 文章分类
create table if not exists blog_cate(
    id mediumint unsigned auto_increment,
    cate_name varchar(32) not null comment '分类名称',
    description text not null comment '分类描述',
    pid mediumint unsigned comment '父分类id',
    status tinyint not null comment '是否启用 0 - 禁用 1 - 启用',
    created_at datetime,
    updated_at datetime,
    primary key(id),
    unique key uk_cate_name(cate_name),
    key idx_pid (pid),
    key idx_status (status)
)charset=utf8,engine=innodb;

-- 标签表
create table if not exists blog_tags(
    id mediumint unsigned not null,
    tag_name varchar(191) not null comment '标签名',
    description text not null comment '标签描述',
    status tinyint unsigned not null comment '是否启用 0 - 禁用 1 - 启用',
    created_at datetime,
    updated_at datetime,
    primary key(id),
    unique key uk_tag_name(tag_name)
)charset=utf8,engine=innodb;

-- 文章表
create table if not exists blog_article(
    id mediumint unsigned auto_increment,
    title varchar(191) not null comment '文章标题',
    image varchar(191) not null comment '文章大图片',
    thumb varchar(191) not null comment '文章缩略图',
    description text not null comment '文章简介',
    status tinyint not null comment '状态 0 - 禁用　1 - 启用',
    is_hot tinyint not null comment '是否热门 0 - 不是　１ - 是',
    is_reco tinyint not null comment '是否推荐 0 - 不是 1 - 推荐',
    view_number int not null comment '阅读量',
    created_at datetime,
    updated_at datetime,
    primary key (id),
    unique key uk_title(title),
    key idx_status (status),
    key idx_is_hot (is_hot),
    key idx_is_reco (is_reco)
)charset=utf8,engine=innodb;


-- 文章分类中间表
create table if not exists blog_cate_article(
    id mediumint unsigned auto_increment,
    article_id mediumint unsigned comment '文章id',
    cate_id mediumint unsigned comment '分类id',
    primary key (id)
    key idx_article_id(article_id),
    key idx_cate_id(cate_id)
)charset=utf8,engine=innodb;


-- 文章标签中间表
create table if not exists blog_tag_article(
    id mediumint unsigned auto_increment,
    article_id mediumint unsigned comment '文章id',
    tag mediumint unsigned comment '标签id',
    primary key (id)
    key idx_article_id(article_id),
    key idx_tag_id(tag_id)
)charset=utf8,engine=innodb;


-- 文章详情表
create table if not exists blog_article_details(
    id mediumint unsigned auto_increment,
    content text not null comment '文章内容',
    created_at datetime,
    updated_at datetime,
    primary key (id)
)charset=utf8,engine=innodb;


-- 友情链接
create table if not exists blog_link(
    id mediumint unsigned not null,
    name varchar(191) not null comment '网站名称',
    url varchar(191) not null comment '网站url',
    sort mediumint not null comment '排序权重',
    status tinyint not null comment '是否禁止 0 - 禁止 1 - 显示',
    created_at datetime,
    updated_at datetime,
    primary key (id),
    unique  key uk_name(name),
    unique key uk_url(name),
    key idx_sort (sort),
    key idx_status (status)
)charset=utf8,engine=innodb;


-- 网站设置表
create table if not exists blog_setting(
    id mediumint unsigned auto_increment,
    site_name varchar(32) not null comment '网站博客名',
    logo varchar(191) not null comment '网站logo',
    author_china_name varchar(32) not null comment '作者中文名',
    author_english_name varchar(32) not null comment '作者英文名',
    address varchar(191) not null comment '作者居住地址',
    job varchar(191) not null comment '工作岗位',
    email varchar(191) not null comment '电子邮箱',
    qq  varchar(191) not null comment 'qq号',
    wechat varchar(191) not null comment '微信号',
    wechat_qrcode varchar(191) not null comment '微信二维码',
    add_time datetime not null comment '网站上线时间',
    created_at datetime,
    updated_at datetime,
    primary key(id)
)charset=utf8,engine=innodb;
