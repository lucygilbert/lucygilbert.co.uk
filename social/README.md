SocialNet
=========

A Social Network project utilizing PHP, MySQL, HTML, CSS, JavaScript, AJAX and just 
about anything else I can throw into it. 

Check todo.txt for the current To Do list.

MySQL Table Descriptions
------------------------
<pre>
mysql> DESCRIBE Users \T c:\tables.txt
-> ;
+----------+-------------+------+-----+---------+-------+
| Field    | Type        | Null | Key | Default | Extra |
+----------+-------------+------+-----+---------+-------+
| username | varchar(20) | NO   | PRI | NULL    |       |
| password | char(40)    | NO   |     | NULL    |       |
+----------+-------------+------+-----+---------+-------+
2 rows in set (0.01 sec)

mysql> DESCRIBE Profiles \T c:\tables.txt
-> ;
+----------+-------------------------------+------+-----+------------+-------+
| Field    | Type                          | Null | Key | Default    | Extra |
+----------+-------------------------------+------+-----+------------+-------+
| username | varchar(20)                   | NO   | PRI | NULL       |       |
| name     | varchar(30)                   | NO   |     | John Doe   |       |
| sex      | enum('Male','Female','Other') | NO   |     | Male       |       |
| dob      | date                          | NO   |     | 1970-01-01 |       |
| about    | varchar(101)                  | YES  |     | NULL       |       |
| media    | varchar(101)                  | YES  |     | NULL       |       |
| hobbies  | varchar(101)                  | YES  |     | NULL       |       |
+----------+-------------------------------+------+-----+------------+-------+
7 rows in set (0.01 sec)

mysql> DESCRIBE Messages \T c:\tables.txt
-> ;
+------------+--------------+------+-----+---------+----------------+
| Field      | Type         | Null | Key | Default | Extra          |
+------------+--------------+------+-----+---------+----------------+
| message_id | bigint(20)   | NO   | PRI | NULL    | auto_increment |
| recipient  | varchar(20)  | NO   |     | NULL    |                |
| sender     | varchar(20)  | NO   |     | NULL    |                |
| msgdate    | date         | NO   |     | NULL    |                |
| heading    | varchar(30)  | YES  |     | NULL    |                |
| bodytext   | varchar(101) | YES  |     | NULL    |                |
| msgread    | tinyint(1)   | NO   |     | 0       |                |
+------------+--------------+------+-----+---------+----------------+
7 rows in set (0.01 sec)
</pre>
