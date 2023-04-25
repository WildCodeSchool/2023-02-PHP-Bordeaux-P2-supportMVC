create table ff_user
(
    id          int auto_increment
        primary key,
    firstname   varchar(100) null,
    lastname    varchar(100) null,
    email       varchar(255) null,
    ff_password varchar(255) null
);
