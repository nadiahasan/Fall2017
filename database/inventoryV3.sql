DROP DATABASE IF EXISTS INVENTORY;

CREATE DATABASE IF NOT EXISTS INVENTORY;

USE INVENTORY;


CREATE TABLE IF NOT EXISTS ADDRESS(
  ADDRESS_ID INT(10) AUTO_INCREMENT NOT NULL PRIMARY KEY ,
  ADDRESS_LINE1 CHAR(100) NOT NULL,
  ADDRESS_LINE2 CHAR(100) ,
  ZIPCODE CHAR(10) NOT NULL,
  COUNTY CHAR(50),
  STATE CHAR(2) NOT NULL

);

CREATE TABLE IF NOT EXISTS USERS(
  USERNAME VARCHAR(50) NOT NULL PRIMARY KEY,
  FIRSTNAME VARCHAR(50) NOT NULL,
  LASTNAME VARCHAR(50) NOT NULL,
  PASSWORD VARCHAR(255) NOT NULL,
  EMAIL VARCHAR(50) NOT NULL,
  ADDRESS_ID INT(10) REFERENCES ADDRESS(ADDRESS_ID),
  TYPE SMALLINT NOT NULL,
  PENDING_FLAG SMALLINT

);


CREATE TABLE IF NOT EXISTS VOLUNTEER(

  USERNAME VARCHAR(50) NOT NULL REFERENCES USERS(USERNAME),
  VOLUNTEER_ID INT(10)  NOT NULL ,
  PRIMARY KEY (USERNAME)

);

CREATE TABLE IF NOT EXISTS EMPLOYEE(


  USERNAME VARCHAR(50) NOT NULL REFERENCES USERS(USERNAME) ,
  EMPLOYEE_ID VARCHAR(50) NOT NULL,
  PRIMARY KEY (USERNAME)

);


CREATE TABLE IF NOT EXISTS CHECK_IN_TIMES(
  USERNAME VARCHAR(50) NOT NULL REFERENCES USERS(USERNAME)  ,
  VOLUNTEER_ID INT(10)  NOT NULL REFERENCES VOLUNTEER(VOLUNTEER_ID),

  CHECK_IN_DATE DATE NOT NULL,
  CHECK_IN_TIME TIME NOT NULL,
  CURRENT_ADDRESS_ID INT(10) NOT NULL REFERENCES ADDRESS(ADDRESS_ID),
  PRIMARY KEY (USERNAME, VOLUNTEER_ID)

);

CREATE TABLE IF NOT EXISTS TYPE(
  BARCODE CHAR(25) NOT NULL PRIMARY KEY ,
  TYPE CHAR(1) NOT NULL
);


CREATE TABLE IF NOT EXISTS DONATION (

  DONATION_ID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  ACCOUNT_NUM DECIMAL(10) NOT NULL,
  DONOR_NAME VARCHAR(100) NOT NULL,
  DONOR_ADDRESS_ID DECIMAL(10) NOT NULL REFERENCES ADDRESS(ADDRESS_ID),
  DONATION_DATE DATE NOT NULL,
  EMPLOYEE_ID DECIMAL(10) NOT NULL REFERENCES EMPLOYEE(EMPLOYEE_ID) ,
  TOTAL_PRICE DECIMAL(6,2) NOT NULL,
  NOTES TEXT

);

CREATE TABLE IF NOT EXISTS PURCHASE (

  PURCHASE_ID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  DONATION_DATE DATE NOT NULL,
  EMPLOYEE_ID DECIMAL(10) NOT NULL REFERENCES EMPLOYEE(EMPLOYEE_ID) ,
  TOTAL_PRICE DECIMAL(6,2) NOT NULL,
  STORE_BOUGHT VARCHAR(100) ,
  NOTES TEXT

);


CREATE TABLE IF NOT EXISTS PURCHASED_ITEMS (

  ITEMS_ID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  PURCHASE_ID INT(10) NOT NULL REFERENCES PURCHASE(PURCHASE_ID),
  BARCODE CHAR(25) NOT NULL REFERENCES TYPE(BARCODE),
  EXPIRATION_DATE DATE,
  ITEM_COUNT DECIMAL(3)

);

CREATE TABLE IF NOT EXISTS PRODUCT(

  PRODUCT_BARCODE CHAR(25) NOT NULL  REFERENCES TYPE(BARCODE),
  PRODUCT_NAME CHAR(100) NOT NULL,
  PRODUCT_PRICE DECIMAL(5,2) NOT NULL,
  QUANTITY_IN_STOCK DECIMAL(10) NOT NULL DEFAULT 0,
  MIN_QUANTITY_IN_STOCK DECIMAL(10) NOT NULL DEFAULT 3000,
  PROD_DESCRIPTION TEXT,
  PRIMARY KEY (PRODUCT_BARCODE)

);


CREATE TABLE IF NOT EXISTS CONTAINER_TYPE(


  CONTAINER_TYPE_ID INT(10) AUTO_INCREMENT PRIMARY KEY ,
  CONTAINER_TYPE VARCHAR(50) NOT NULL

);

INSERT INTO CONTAINER_TYPE VALUES (1, 'packs');
INSERT INTO CONTAINER_TYPE VALUES (2, 'pouches');




CREATE TABLE IF NOT EXISTS CONTAINER(


  CONTAINER_BARCODE CHAR(25) NOT NULL REFERENCES TYPE(BARCODE) ,
  PRODUCT_BARCODE CHAR(25) NOT NULL REFERENCES PRODUCT(PRODUCT_BARCODE),
  CONTAINER_TYPE_ID INT(10) NOT NULL REFERENCES CONTAINER_TYPE(CONTAINER_TYPE_ID),
  COUNT_PER_CONTAINER DECIMAL(10) NOT NULL DEFAULT 1,
  QUANTITY_IN_STOCK DECIMAL(10) NOT NULL DEFAULT 0,
  CONTAINER_PRICE DECIMAL(5,2) NOT NULL,
  PRIMARY KEY (CONTAINER_BARCODE)
);




CREATE TABLE IF NOT EXISTS ITEMS(

  ITEM_ID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  DONATION_ID INT(10) NOT NULL  REFERENCES DONATION(DONATION_ID),
  BARCODE CHAR(25) NOT NULL  REFERENCES TYPE(BARCODE),
  EXPIRATION_DATE DATE,
  ITEM_COUNT DECIMAL(3) NOT NULL DEFAULT 1

);

CREATE TABLE IF NOT EXISTS PULL_SHEET(
  PULL_SHEET_ID INT(10) AUTO_INCREMENT NOT NULL PRIMARY KEY,
  PACKING_SITE_ADDRESS INT(10) NOT NULL REFERENCES ADDRESS(ADDRESS_ID),
  PULL_DATE DATE NOT NULL ,
  DELIVERY_DATE DATE NOT NULL ,
  NUM_PACKAGING_WEEKS DECIMAL NOT NULL ,
  NUM_CELLS_PER_WEEK DECIMAL NOT NULL,
  TOTAL_PER_PACKAGING DECIMAL NOT NULL,
  NOTES TEXT

);



CREATE TABLE IF NOT EXISTS PULL_SHEETS_ITEMS(

  PULL_SHEET_ID INT(10)  NOT NULL REFERENCES PULL_SHEET(PULL_SHEET_ID),
  PRODUCT_BARCODE INT(10) NOT NULL REFERENCES PRODUCT(PRODUCT_BARCODE),
  NUM_CASES DECIMAL(10)NOT NULL ,
  EMPLOYEE_ID INT(10) NOT NULL REFERENCES EMPLOYEE(EMPLOYEE_ID),
  CASE_QUANTITY DECIMAL(10) NOT NULL,
  AMOUNT_PER_KIDPACK INT NOT NULL,
  PRIMARY KEY(PULL_SHEET_ID, PRODUCT_BARCODE)

);
