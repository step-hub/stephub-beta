insert into step_hub_database.announcement (id, user_id, title, details, file, date, deadline, announcement_status_id) values (5, 9, 'pjoij', null, null, '2020-03-13', '2020-03-20', 4);
insert into step_hub_database.announcement (id, user_id, title, details, file, date, deadline, announcement_status_id) values (9, 9, 'sfas', 'saf', null, '2020-03-27', '2020-03-17', 3);

insert into step_hub_database.announcement_status (id, status) values (1, 'actual');
insert into step_hub_database.announcement_status (id, status) values (2, 'frozen');
insert into step_hub_database.announcement_status (id, status) values (3, 'solved');
insert into step_hub_database.announcement_status (id, status) values (4, 'banned');

insert into step_hub_database.user (id, email, password, login, telegram_username, student_num, user_status_id, is_online, token) values (9, 'qw', 'qwert', 'dfghn', 'bcvnb', 'wer', 4, 1, '');

insert into step_hub_database.user_status (id, status) values (1, 'admin');
insert into step_hub_database.user_status (id, status) values (2, 'user');
insert into step_hub_database.user_status (id, status) values (3, 'moderator');
insert into step_hub_database.user_status (id, status) values (4, 'banned');
