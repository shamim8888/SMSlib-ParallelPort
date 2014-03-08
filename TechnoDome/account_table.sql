CREATE TABLE accounts (
   account_id serial NOT NULL,
account_type char (20),
   account_name char(50),
   office_address char(100),
home_address char(100),
off_phone char(15), 
res_phone char(15),
mobile_phone char(15),
   PRIMARY KEY (account_id)
);
