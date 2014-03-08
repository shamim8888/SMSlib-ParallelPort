CREATE TABLE money_receipt (
   mreceipt_id serial NOT NULL,
   mreceipt_date date,
   amount float8,
   account_id int4,
   ship_id int4 ,
   from_id int4,
   to_id int4,
   mat_one int4,
   mat_two int4,
   pay_type char(15),
   bank_name char(50),
   branch char(20),
   cheque_receive_date date,
   mreceipt_serial char(9),
   departure_date date,
   receive_location int4,
   trip_id int4,
   comment char(50),

   PRIMARY KEY (mreceipt_id)
);



