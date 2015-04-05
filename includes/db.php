<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of db
 *
 * @author Ran Ding
 */
class db extends mysqli {
    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "rad";
    private $pass = "Trjf4zhBCR9ZuW2u";
    private $dbName = "FinalProject";
    private $dbHost = "localhost";
    //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }
    
    private function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }
    
    public function get_all_region_manager() {
        return $this->query("SELECT region_manager_id, region_manager_name, email, salary FROM region_manager");
    }
    
    public function get_all_salesman() {
        return $this->query("SELECT salesman_id, salesman_name, email, salary, store_id FROM salesman");
    }

    public function get_all_store_manager() {
        return $this->query("SELECT store_manager_id, manager_name, email, salary FROM store_manager");
    }    
    public function get_salesman_information_by_name($name){
        $name = $this->real_escape_string($name);
        return $this->query("SELECT Employee.EmployeeID, Name, Job_Title, Street, City, State, Zipcode, Email, Salary, Assigned_Store From Employee, Store_Mapping WHERE Name = '" . $name . "' and Job_Title = 'Salesperon' and Employee.EmployeeID = Store_Mapping.EmployeeID");
    }
    
    public function get_region_manager_information_by_name($name){
        $name = $this->real_escape_string($name);
        return $this->query("SELECT Employee.EmployeeID, Employee.Name, Job_Title, Street, City, State, Zipcode, Email, Salary, Region_Name From Employee, Region WHERE Employee.Name = '" . $name . "' and Job_Title = 'Region Manager' and Employee.EmployeeID = Region_ManagerID");
    }
    
    public function get_store_manager_information_by_name($name){
        $name = $this->real_escape_string($name);
        return $this->query("SELECT Employee.EmployeeID, Name, Job_Title, Street, City, State, Zipcode, Email, Salary, Assigned_Store From Employee, Store_Mapping WHERE Name = '" . $name . "' and Job_Title = 'Store Manager' and Employee.EmployeeID = Store_Mapping.EmployeeID");
    }
    
    public function insert_salesman($salesman_name, $email, $salary, $storeid){
        $salesman_name = $this->real_escape_string($salesman_name);
        $email = $this->real_escape_string($email);
        $this->query("INSERT INTO salesman (salesman_name, email, salary, store_id)" . 
                        " VALUES ('" . $salesman_name . "', '" . $email . "', " 
                        . $salary . ", ". $storeid .")");
    }
    
    public function insert_region_manager($region_manager_name, $email, $salary){
        $salesman_name = $this->real_escape_string($region_manager_name);
        $email = $this->real_escape_string($email);
        $this->query("INSERT INTO region_manager (region_manager_name, email, salary)" . 
                        " VALUES ('" . $region_manager_name . "', '" . $email . "', " 
                        . $salary . ")");
    }
    
    public function insert_store_manager($manager_name, $email, $salary){
        $manager_name = $this->real_escape_string($manager_name);
        $email = $this->real_escape_string($email);
        $this->query("INSERT INTO store_manager (manager_name, email, salary)" . 
                        " VALUES ('" . $manager_name . "', '" . $email . "', " 
                        . $salary . ")");
    }
    
    public function delete_store_manager($store_manager_id){
        $this->query("DELETE FROM store_manager WHERE store_manager_id = " . $store_manager_id);
    }
    
    public function delete_salesman ($salesman_id){
        $this->query("DELETE FROM salesman WHERE salesman_id = " . $salesman_id);
    }
    
    public function delete_region_manager ($region_manager_id){
        $this->query("DELETE FROM region_manager WHERE region_manager_id = " . $region_manager_id);
    }
    
    public function get_salesman_by_id($salesman_id){
        return $this->query("SELECT salesman_id, salesman_name, email, salary, store_id FROM salesman WHERE salesman_id = " . $salesman_id);
    }
    
    public function get_store_manager_by_id($store_manager_id){
        return $this->query("SELECT store_manager_id, manager_name, email, salary FROM store_manager WHERE store_manager_id = " . $store_manager_id);
    }
    
    public function get_region_manager_by_id($region_manager_id){
        return $this->query("SELECT region_manager_id, region_manager_name, email, salary FROM region_manager WHERE region_manager_id = " . $region_manager_id);
    }
    
    public function update_salesman($salesman_id, $salesman_name, $email, $salary, $storeid){
        $salesman_name = $this->real_escape_string($salesman_name);
        $email = $this->real_escape_string($email);
        $this->query("UPDATE salesman SET salesman_name = '" . $salesman_name .
                "', email = '" . $email . "', salary = " . $salary .", store_id = " . $storeid . " WHERE salesman_id = " . $salesman_id);
    }  
    
    public function update_store_manager($store_manager_id, $manager_name, $email, $salary){
        $manager_name = $this->real_escape_string($manager_name);
        $email = $this->real_escape_string($email);
        $this->query("UPDATE store_manager SET manager_name = '" . $manager_name .
                "', email = '" . $email . "', salary = " . $salary ." WHERE store_manager_id = " . $store_manager_id);
    }  
    
    public function update_region_manager($region_manager_id, $region_manager_name, $email, $salary){
        $region_manager_name = $this->real_escape_string($region_manager_name);
        $email = $this->real_escape_string($email);
        $this->query("UPDATE region_manager SET region_manager_name = '" . $region_manager_name .
                "', email = '" . $email . "', salary = " . $salary ." WHERE region_manager_id = " . $region_manager_id);
    }  
    
    public function get_all_region(){
        return $this->query("SELECT region_id, region_name, region_manager_name FROM region, region_manager WHERE region.region_manager_id = region_manager.region_manager_id");
    }
    
    public function delete_region($region_id){
        $this->query("DELETE FROM region WHERE region_id = ". $region_id);
    }
    
    public function insert_region($region_name, $region_manager_name){
        $region_manager_name = $this->real_escape_string($region_manager_name);
        $region_name = $this->real_escape_string($region_name);
        $result = $this->query("SELECT region_manager_id FROM region_manager WHERE region_manager_name = '". $region_manager_name . "'");
        $row = mysqli_fetch_array($result);
        $region_manager_id = $row["region_manager_id"];
        mysqli_free_result($result);
        $this->query("INSERT INTO region (region_name, region_manager_id) VALUES('". $region_name ."',". $region_manager_id .")");
    }
    
    public function update_region($region_id, $region_name, $region_manager_name){
        $region_manager_name = $this->real_escape_string($region_manager_name);
        $region_name = $this->real_escape_string($region_name);
        $result = $this->query("SELECT region_manager_id FROM region_manager WHERE region_manager_name = '". $region_manager_name . "'");
        $row = mysqli_fetch_array($result);
        $region_manager_id = $row["region_manager_id"];
        mysqli_free_result($result);
        $sql = "UPDATE region SET region_name = '" . $region_name . 
                "', region_manager_id = " . $region_manager_id . " WHERE region_id = ". $region_id ;
        $this->query($sql);
    }
    
    public function delete_store($store_id){
        $this->query("DELETE FROM store WHERE store_id = ". $store_id);
    }
    
    public function get_region_by_id($region_id){
        return $this->query("SELECT region_id, region_name, region_manager_name FROM region, region_manager WHERE region.region_manager_id = region_manager.region_manager_id AND region_id = ". $region_id);
    }
    
    public function get_all_store(){
        $sql = "SELECT S.store_id, SM.manager_name, R.region_name, S.street_name, S.city, CS.state, S.zip_code
                FROM store AS S, store_manager AS SM, region AS R, city_state AS CS
                WHERE S.store_manager_id = SM.store_manager_id AND S.region_id = R.region_id AND CS.city = S.city
                GROUP BY (S.store_id)";
        return $this->query($sql);
    }
    
    public function get_number_of_salesman($store_id){
        $sql = "SELECT count(SA.salesman_id) as number_of_salesman"
                . " FROM store AS S, salesman AS SA"
                . " WHERE SA.store_id = S.store_id AND S.store_id = ". $store_id;
        return $this->query($sql);
                
    }
    
    public function get_store_by_id($store_id){
        $sql = "SELECT S.store_id, SM.manager_name, R.region_name, S.street_name, S.city, S.zip_code
                FROM store AS S, store_manager AS SM, region AS R
                WHERE S.store_manager_id = SM.store_manager_id AND S.region_id = R.region_id AND S.store_id = ". $store_id;
        return $this->query($sql);
    }
    
    public function insert_store($manager_name, $region_name, $street_name, $city, $zip_code){
        $manager_name = $this->real_escape_string($manager_name);
        $result = $this->query("SELECT store_manager_id FROM store_manager WHERE manager_name = '". $manager_name . "'");
        $row = mysqli_fetch_array($result);
        $store_manager_id = $row["store_manager_id"];
        mysqli_free_result($result);
        $region_name = $this->real_escape_string($region_name);
        $result = $this->query("SELECT region_id FROM region WHERE region_name = '". $region_name . "'");
        $row = mysqli_fetch_array($result);
        $region_id = $row["region_id"];
        mysqli_free_result($result);
        $street_name = $this->real_escape_string($street_name);
        $city = $this->real_escape_string($city);
        $sql = "INSERT INTO store (store_manager_id, region_id, street_name, city, zip_code) "
                . "VALUES(". $store_manager_id .",". $region_id . ",'". $street_name . "','". $city . "',". $zip_code .")";
        $this->query($sql);        
    }
    
    public function update_store($store_id, $manager_name, $region_name, $street_name, $city, $zip_code){
        $manager_name = $this->real_escape_string($manager_name);
        $result = $this->query("SELECT store_manager_id FROM store_manager WHERE manager_name = '". $manager_name . "'");
        $row = mysqli_fetch_array($result);
        $store_manager_id = $row["store_manager_id"];
        mysqli_free_result($result);
        $region_name = $this->real_escape_string($region_name);
        $result = $this->query("SELECT region_id FROM region WHERE region_name = '". $region_name . "'");
        $row = mysqli_fetch_array($result);
        $region_id = $row["region_id"];
        mysqli_free_result($result);
        $street_name = $this->real_escape_string($street_name);
        $city = $this->real_escape_string($city);
        $sql = "UPDATE store SET store_manager_id = ". $store_manager_id .", region_id = ". $region_id .
                ", street_name = '". $street_name ."', city = '". $city ."', zip_code = ". $zip_code . " WHERE store_id = ". $store_id;
        $this->query($sql);
    }
    
    public function get_all_city(){
        $sql = "SELECT distinct City FROM Customer";
        return $this->query($sql);              
    }
    
    public function get_all_state(){
        $sql = "SELECT distinct State FROM Customer";
        return $this->query($sql);              
    }
    
    public function get_all_business(){
        $sql ="select B.customer_id, B.business_name, B.business_category, B.company_gross_annual_income, C.street_name, C.city, CS.state, C.zip_code
                from customer AS C, business AS B, city_state AS CS
                where C.customer_id = B.customer_id and C.city = CS.city";
        return $this->query($sql);
    }
    
    public function get_all_transaction_home(){
        $sql = "select T.transaction_id, H.home_name, S.salesman_name, T.date, T.remark
                from transactions as T, home as H, salesman as S
                where T.customer_id = H.customer_id and T.salesman_id = S.salesman_id";
        return $this->query($sql);        
    }
    
    public function get_all_transaction_business(){
        $sql = "select T.transaction_id, B.business_name, S.salesman_name, T.date, T.remark
                from transactions as T, business as B, salesman as S
                where T.customer_id = B.customer_id and T.salesman_id = S.salesman_id";
        return $this->query($sql);        
    }
    
    public function get_all_product_by_transaction_id($transaction_id){
        $sql = "select P.name
                from transactions as T, order_specify as OS, product as P
                where T.transaction_id = OS.transaction_id and P.product_id = OS.product_id and T.transaction_id = ". $transaction_id;
        return $this->query($sql);
    }
    
    public function delete_transaction($transaction_id){
        $this->query("DELETE FROM transactions WHERE transaction_id = ". $transaction_id);
    }
    
    public function insert_transaction($customer_id, $salesman_name, $date, $remark){
        $salesman_name = $this->real_escape_string($salesman_name);
        $result = $this->query("SELECT salesman_id FROM salesman WHERE salesman_name = '". $salesman_name . "'");
        $row = mysqli_fetch_array($result);
        $salesman_id = $row["salesman_id"];
        mysqli_free_result($result);
        $date = $this->format_date_for_sql($date);
        $remark = $this->real_escape_string($remark);
        $sql = "INSERT INTO transactions (customer_id, salesman_id, date, remark) "
                . "VALUES(". $customer_id .",". $salesman_id . ", ". $date . ", '". $remark . "')";
        $this->query($sql);
    }
    
    public function insert_order_specify($last_transaction_id, $id, $amount){
        $sql = "INSERT INTO order_specify (transaction_id, product_id, amount) "
                . "VALUES(". $last_transaction_id .", ". $id .", ". $amount .")";
        $this->query($sql);
    }
    
    public function get_all_customer_id(){
        return $this->query("select customer_id from customer");
    }
    
    public function get_all_customer_business(){
        return $this->query("select business_name from business");
    }
    
    public function get_all_product(){
        return $this->query("select * from product");
    }
    
    public function reduce_product($product_id, $amount){
        $sql = "UPDATE product SET inventory_amount = inventory_amount-". $amount ." WHERE product_id=". $product_id;
        $this->query($sql);
    }
    
    function format_date_for_sql($date) {
        if ($date == "")
            return null;
        else {
            $dateParts = date_parse($date);
            return $dateParts['year'] * 10000 + $dateParts['month'] * 100 + $dateParts['day'];
        }
    }
    
    public function get_product_comp(){
        $sql = "select P.`name`, P.product_kind, P.price, sum(OS.amount) as total_sell, sum(OS.amount)*P.price as profit
                from order_specify as OS, product as P
                where OS.product_id = P.product_id
                group by P.product_id
                order by total_sell desc";
        return $this->query($sql);
    }
    
    public function get_salesman_comp(){
        $sql ="select S.salesman_name, S.email, S.store_id, count(T.transaction_id) as total_order
                from salesman as S, transactions as T
                where T.salesman_id = S.salesman_id
                group by T.salesman_id
                order by total_order desc";
        return $this->query($sql);
    }
    
    public function get_store_comp(){
        $sql = "select S.store_id, SM.manager_name, S.street_name, S.city, CS.`state`, S.zip_code, count(T.transaction_id) as total_order
                from store as S, store_manager as SM, salesman as SA, transactions as T, city_state as CS
                where S.store_manager_id = SM.store_manager_id and SA.store_id = S.store_id and S.city = CS.city and T.salesman_id = SA.salesman_id
                group by T.salesman_id
                order by total_order desc";
        return $this->query($sql);
    }
    
    public function get_region_comp(){
        $sql = "select R.region_name, RM.region_manager_name, count(T.transaction_id) as total_order
                from region as R, store as S, region_manager as RM, salesman as SA, transactions as T
                where R.region_id = S.region_id and R.region_manager_id = RM.region_manager_id and SA.store_id = S.store_id and T.salesman_id = SA.salesman_id
                group by T.salesman_id
                order by total_order desc";
        return $this->query($sql);
    }
    
    public function get_cusotmer_comp(){
        $sql = "select TEMP.name, count(T.transaction_id) as total_order
                from (select H.home_name as name, C.customer_id
                    from customer as C, home as H
                    where C.customer_id = H.customer_id
                    union
                    select B.business_name as name, C.customer_id
                    from customer as C, business as B
                    where C.customer_id = B.customer_id) as TEMP, transactions as T
                where TEMP.customer_id = T.customer_id
                group by TEMP.customer_id
                order by total_order desc";
        return $this->query($sql);
    }
    
    public function get_home_information_by_name($name){
        $name = $this->real_escape_string($name);
        return $this->query("SELECT Name, Street,City,State,ZipCode, Gender, Age, AnnualIncome, MarriageStatus FROM FinalProject.Customer,FinalProject.Home_Customer where Name = '" . $name. "' AND Home_Customer.CustomerID = Customer.CustomerID;");
    }
    
    public function get_business_information_by_name($name){
        $name = $this->real_escape_string($name);
        return $this->query("SELECT Name, Street,City,State,ZipCode, Business_Category, GrossAnnualIncome FROM FinalProject.Customer,FinalProject.Business_Customer where Name = '" . $name. "' AND Customer.CustomerID = Business_Customer.CustomerID;");
    }
    
     public function get_home_customer_by_id($customer_id){
        return $this->query("SELECT customer_id, home_name,age, gender, mariage_status, income FROM home WHERE customer_id = " . $customer_id);
    }
    
    public function get_customer_by_id($customer_id){
        return $this->query("SELECT Customer.CustomerID, Name, Street,City,State,ZipCode, Gender, Age, AnnualIncome, MarriageStatus FROM FinalProject.Customer,FinalProject.Home_Customer where Home_Customer.CustomerID=Customer.CustomerID and Customer.CustomerID = " . $customer_id );
    }
    
    public function get_business_customer_by_id($customer_id){
        return $this->query("SELECT Customer.CustomerID, Name, Street,City,State,ZipCode, Business_Category, GrossAnnualIncome FROM FinalProject.Customer,FinalProject.Business_Customer where Customer.CustomerID = Business_Customer.CustomerID and Customer.CustomerID = " . $customer_id );
    }
    
     public function get_all_home_customer() {
        return $this->query("SELECT Customer.CustomerID, Name, Street,City,State,ZipCode, Gender, Age, AnnualIncome, MarriageStatus  FROM FinalProject.Customer,FinalProject.Home_Customer where Type = 'Individual'and Home_Customer.CustomerID = Customer.CustomerID");
    }
    
     public function get_all_business_customer() {
        return $this->query("SELECT Customer.CustomerID, Name, Street,City,State,ZipCode, Business_Category, GrossAnnualIncome FROM FinalProject.Customer,FinalProject.Business_Customer where Type = 'Business' and Customer.CustomerID = Business_Customer.CustomerID");
    }
    
    public function insert_customer($home_name, $age, $gender, $marriage_status, $income, $street_name, $city, $zip_code, $state){
         
        $street_name = $this->real_escape_string($street_name);
        $city = $this->real_escape_string($city);
        $type = "Individual";
        $state = $this->real_escape_string($state);
        $home_name = $this->real_escape_string($home_name);
        $gender = $this->real_escape_string($gender);
        
        $this->query("INSERT INTO Customer (Name, Street, City, State, Zipcode, Type)".
                     "VALUES ('" . $home_name . "','" . $street_name . "','" . $city . "','" . $state . "', " . $zip_code . ",'" . $type . "')");
        $this->query("INSERT INTO Home_Customer (CustomerID, Gender, Age, AnnualIncome, MarriageStatus)" . 
                     "VALUES (LAST_INSERT_ID(),'" . $gender . "', ". $age . ", " . $income . ",'" . $marriage_status . "')");
    }

    
    public function update_home_customer($customer_id, $home_name, $age, $gender, $marriage_status, $income, $street_name, $city, $zip_code, $state){
        $Name = $this->real_escape_string($home_name);
        $gender = $this->real_escape_string($gender);
        $street_name = $this->real_escape_string($street_name);
        $city = $this->real_escape_string($city);
        $this->query("UPDATE Customer SET Name = '". $home_name ."', Street = '". $street_name ."', City = '". $city ."', Zipcode = ". $zip_code . " WHERE CustomerID = ". $customer_id);
        $this->query("UPDATE Home_Customer SET  Age = ". $age .", Gender ='". $gender . "', MarriageStatus = '". $marriage_status . "', AnnualIncome = ". $income . " WHERE CustomerID = ". $customer_id);
    }  
    
     public function delete_home_customer($customer_id){
        $this->query("DELETE FROM Customer WHERE CustomerID = ". $customer_id);
        $this->query("DELETE FROM Home_Customer WHERE CustomerID = ". $customer_id);
    }
    
     public function insert_business_customer($business_name, $business_category, $company_gross_annual_income, $street_name, $city, $zip_code, $state){
         
        $street_name = $this->real_escape_string($street_name);
        $city = $this->real_escape_string($city);
        $business_name = $this->real_escape_string($business_name);
        $business_category = $this->real_escape_string($business_category);
        $type = "Business";
        $this->query("INSERT INTO Customer (Name, Street, City, State, Zipcode, Type)".
                     "VALUES ('" . $business_name . "','" . $street_name . "','" . $city . "','" . $state . "', " . $zip_code . ",'" . $type . "')");

        $this->query("INSERT INTO Business_Customer (CustomerID, Business_Category, GrossAnnualIncome)" . 
                     "VALUES (LAST_INSERT_ID(),'" . $business_category . "', ". $company_gross_annual_income . ")");
    }

     public function update_business_customer($customer_id, $business_name, $business_category, $company_gross_annual_income, $street_name, $city, $zip_code, $state){
        $business_name = $this->real_escape_string($business_name);
        $business_category = $this->real_escape_string($business_category);
        $street_name = $this->real_escape_string($street_name);
        $city = $this->real_escape_string($city);
        $state = $this->real_escape_string($state);
        $this->query("UPDATE Customer SET Name = '". $business_name."', Street = '". $street_name ."', City = '". $city ."', Zipcode = ". $zip_code . ", State = '". $state . "' WHERE CustomerID = ". $customer_id);
        $this->query("UPDATE Business_Customer SET  Business_Category = '". $business_category ."', GrossAnnualIncome = ". $company_gross_annual_income ." WHERE CustomerID = ". $customer_id);
        
    }  
    
    public function delete_business_customer($customer_id){
        $this->query("DELETE FROM Customer WHERE CustomerID = ". $customer_id);
        $this->query("DELETE FROM Business_Customer WHERE CustomerID = ". $customer_id);
    }
    
    public function view_product_Face_Wash (){
        $sql = "select P.ProductID, Name, ProductType, Base_Price, ImageFile, Inventory from Product P where Category='Face Wash'";
        return $this->query($sql);
    }
    
    public function view_product_Moisturizer (){
        $sql = "select P.ProductID, Name, Inventory, ProductType, Base_Price, ImageFile from Product P where Category='Moisturizer'";
        return $this->query($sql);
    }
    
    public function view_product_Eyeshadow (){
        $sql = "select P.ProductID, Name, ProductType, Inventory, Base_Price, ImageFile from Product P where Category='Eyeshadow'";
        return $this->query($sql);
    }
    
    public function view_product_Lipstick (){
        $sql = "select P.ProductID, Name, Inventory,ProductType, Base_Price, ImageFile from Product P where Category='Lipstick'";
        return $this->query($sql);
    }
    
    public function view_product_Remover (){
        $sql = "select P.ProductID, Name, Inventory, ProductType, Base_Price, ImageFile from Product P where Category='Remover'";
        return $this->query($sql);
    }
    
    public function view_product_Fragrance (){
        $sql = "select P.ProductID, Name, Inventory, ProductType, Base_Price, ImageFile from Product P where Category='Fragrance'";
        return $this->query($sql);
    }
    
    public function get_product_by_id($product_id){
        return $this->query("SELECT ProductID, Name, Cost, ProductType, Category, ImageFile, Base_Price, Inventory FROM FinalProject.Product Where ProductId = ".$product_id);
    }
    public function insert_product($name, $product_kind, $cost, $inventory_amount, $price, $category) {
        $name = $this->real_escape_string($name);
        $product_kind = $this->real_escape_string($product_kind);
        $category = $this->real_escape_string($category);
        $this->query("INSERT INTO Product (Name,Cost,ProductType,Category,Base_Price,Inventory) VALUES('". $name ."', ".$cost.", '".$product_kind."','".$category."', ".$price.",".$inventory_amount.")");
    }
    
    public function get_all_product_kind(){
        $sql = "SELECT Distinct ProductType FROM FinalProject.Product";
        return $this->query($sql);
    }
    
    public function get_all_product_category(){
        $sql = "SELECT Distinct Category FROM FinalProject.Product";
        return $this->query($sql);
    } 
    
    public function update_product($product_id, $name, $product_kind, $cost, $inventory_amount, $price, $category) {
        $name = $this->real_escape_string($name);
        $product_kind = $this->real_escape_string($product_kind);
        $category = $this->real_escape_string($category);
        $this->query("update product set Name='".$name."',ProductType='".$product_kind."',Inventory=".$inventory_amount.", Base_Price=".$price.", Cost=".$cost.",Category='".$category."'  Where ProductID=".$product_id);        
        
    }
    
    public function delete_product($product_id){
        $this->query("DELETE FROM product WHERE ProductID = ". $product_id);
    }
    
    public function get_product_information_by_name($name){
        $name = $this->real_escape_string($name);
        return $this->query("select Name, ProductType, Category, Base_Price, ImageFile from Product where name= '" . $name . "'");
    }
    
    public function verify_users ($name, $password){
        $name = $this->real_escape_string($name);
        $password = $this->real_escape_string($password);
        $result = $this->query("SELECT 1 FROM Login
 	           WHERE User_Name = '" . $name . "' AND Password = '" . $password . "'");
        return $result->data_seek(0);
    }
}
