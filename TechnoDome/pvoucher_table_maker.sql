CREATE TABLE payment_voucher (
   voucher_id serial NOT NULL,
   pay_voucher_date date,amount float8,account_id int4,
   ship_id int4 ,
   from_id int4,
   to_id int4,
   mat_one int4,
   mat_two int4,
   pay_type char(15), 
bank_name char(50),
branch char(20), cheque_pay_date date, payment_serial char(9),
pay_location int4,departure_date date, comment char(50),
   PRIMARY KEY (voucher_id)
);



