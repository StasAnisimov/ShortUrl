# ShortUrl
Used php 7.2 and MySQL
Before start need to create database test and short_url table
With fields
id INT PRIMARY AUTOINCREMENT
long_url VARCHAR(255) NOT NULL
short_code - VARBINARY (6) 
counter - int default 0
date_end - DateTime NOT NULL
date_start - DateTime NOT NULL
