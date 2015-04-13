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
    private $user = "root";
    private $pass = "root";
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
        return $this->query("SELECT Employee.EmployeeID, Employee.Name, Job_Title, Street, City, State, Zipcode, Email, Salary, Region_Name From Employee, Region WHERE Job_Title = 'Region Manager' and Employee.EmployeeID = Region_ManagerID");
    }
    
    public function get_all_region_manager_id() {
        return $this->query("SELECT Employee.EmployeeID, Employee.Name, Job_Title, Street, City, State, Zipcode, Email, Salary, Region_Name From Employee, Region WHERE Job_Title = 'Region Manager' Group By EmployeeID");
    }
    
    public function get_all_salesman() {
        return $this->query("SELECT Employee.EmployeeID, Name, Job_Title, Street, City, State, Zipcode, Email, Salary, Assigned_Store From Employee, Store_Mapping WHERE Job_Title = 'Salesperon' and Employee.EmployeeID = Store_Mapping.EmployeeID");
    }
    
    public function get_all_store_manager() {
        return $this->query("SELECT Employee.EmployeeID, Name, Job_Title, Street, City, State, Zipcode, Email, Salary, Assigned_Store From Employee, Store_Mapping WHERE Job_Title = 'Store Manager' and Employee.EmployeeID = Store_Mapping.EmployeeID");
    } 

    public function get_all_store_manager_id() {
        return $this->query("SELECT Employee.EmployeeID, Name, Job_Title, Street, City, State, Zipcode, Email, Salary, Assigned_Store From Employee, Store_Mapping WHERE Job_Title = 'Store Manager' Group By EmployeeID");
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
    
    public function insert_salesman($salesman_name, $street, $city, $state, $zipcode, $email, $salary, $store_id){
        $salesman_name = $this->real_escape_string($salesman_name);
        $street = $this->real_escape_string($street);
        $city = $this->real_escape_string($city);
        $jobtitle = "Salesperon";
        $state = $this->real_escape_string($state);
        $zipcode = $this->real_escape_string($zipcode);
        $email = $this->real_escape_string($email);
        $this->query("INSERT INTO FinalProject.Employee (Name, Job_Title, Street, City, State, Zipcode, Email, Salary)".
                     "VALUES ('" . $salesman_name . "', '$jobtitle','" . $street . "','" . $city . "', '" . $state . "','" . $zipcode . "','" . $email . "', " . $salary .")");
        $this->query("INSERT INTO Store_Mapping (EmployeeID, Assigned_Store)" . 
                        "VALUES (LAST_INSERT_ID(), " . $store_id . ")");
    }
    
    public function insert_region_manager($region_manager_name, $street, $city, $state, $zipcode, $email, $salary){
        $region_manager_name = $this->real_escape_string($region_manager_name);
        $street = $this->real_escape_string($street);
        $city = $this->real_escape_string($city);
        $jobtitle = "Region Manager";
        $state = $this->real_escape_string($state);
        $zipcode = $this->real_escape_string($zipcode);
        $email = $this->real_escape_string($email);
        $this->query("INSERT INTO FinalProject.Employee (Name, Job_Title, Street, City, State, Zipcode, Email, Salary)".
                     "VALUES ('" . $region_manager_name . "', '$jobtitle','" . $street . "','" . $city . "', '" . $state . "','" . $zipcode . "','" . $email . "', " . $salary .")");
    }
    
    public function insert_store_manager($manager_name, $street, $city, $state, $zipcode, $email, $salary, $store_id){
        $manager_name = $this->real_escape_string($manager_name);
        $street = $this->real_escape_string($street);
        $city = $this->real_escape_string($city);
        $jobtitle = "Store Manager";
        $state = $this->real_escape_string($state);
        $zipcode = $this->real_escape_string($zipcode);
        $email = $this->real_escape_string($email);
        $this->query("INSERT INTO FinalProject.Employee (Name, Job_Title, Street, City, State, Zipcode, Email, Salary)".
                     "VALUES ('" . $manager_name . "', '$jobtitle','" . $street . "','" . $city . "', '" . $state . "','" . $zipcode . "','" . $email . "', " . $salary .")");
        $this->query("INSERT INTO Store_Mapping (EmployeeID, Assigned_Store)" . 
                        "VALUES (LAST_INSERT_ID(), " . $store_id . ")");
    }
    
    public function delete_store_manager($store_manager_id){
        $this->query("DELETE FROM Employee WHERE EmployeeID = " . $store_manager_id);
        $this->query("DELETE FROM Store_Mapping WHERE EmployeeID = " . $store_manager_id);;
    }
    
    public function delete_salesman ($salesman_id){
        $this->query("DELETE FROM Employee WHERE EmployeeID = " . $salesman_id);
        $this->query("DELETE FROM Store_Mapping WHERE EmployeeID = " . $salesman_id);
    }
    
    public function delete_region_manager ($region_manager_id){
        $this->query("DELETE FROM region_manager WHERE region_manager_id = " . $region_manager_id);
    }
    
    public function get_all_store_id(){
        $sql = "SELECT Distinct StoreID FROM FinalProject.Store";
        return $this->query($sql);
    }
    
    public function get_salesman_by_id($salesman_id){
        return $this->query("SELECT Employee.EmployeeID, Name, Job_Title, Street, City, State, Zipcode, Email, Salary, Assigned_Store From Employee, Store_Mapping WHERE Employee.EmployeeID = " . $salesman_id . " and Job_Title = 'Salesperon' and Employee.EmployeeID = Store_Mapping.EmployeeID");
    }
    
    public function get_store_manager_by_id($store_manager_id){
        return $this->query("SELECT Employee.EmployeeID, Name, Job_Title, Street, City, State, Zipcode, Email, Salary, Assigned_Store From Employee, Store_Mapping WHERE Employee.EmployeeID = " . $store_manager_id . " and Job_Title = 'Store Manager' and Employee.EmployeeID = Store_Mapping.EmployeeID");
    }
    
    public function get_region_manager_by_id($region_manager_id){
        return $this->query("SELECT Employee.EmployeeID, Employee.Name, Job_Title, Street, City, State, Zipcode, Email, Salary, Region_Name, RegionID From Employee, Region WHERE Employee.EmployeeID = " . $region_manager_id . " and Job_Title = 'Region Manager' and Employee.EmployeeID = Region_ManagerID");
    }
    
    public function update_salesman($salesman_id, $salesman_name, $street, $city, $state, $zipcode, $email, $salary, $store_id){
        $salesman_name = $this->real_escape_string($salesman_name);
        $street = $this->real_escape_string($street);
        $city = $this->real_escape_string($city);
        $state = $this->real_escape_string($state);
        $email = $this->real_escape_string($email);
        $this->query("UPDATE Employee SET Name = '" . $salesman_name .
                "', Street = '" . $street . "', City = '" . $city . "', State = '" . $state . "', Zipcode = '" . $zipcode . "', Email = '" . $email . "', Salary = " . $salary ." WHERE EmployeeID = " . $salesman_id);
        $this->query("UPDATE Store_Mapping SET Assigned_Store = ". $store_id ." WHERE EmployeeID = " . $salesman_id);
        
    }  
    
    public function update_store_manager($store_manager_id, $manager_name, $street, $city, $state, $zipcode, $email, $salary, $store_id){
        $manager_name = $this->real_escape_string($manager_name);
        $street = $this->real_escape_string($street);
        $city = $this->real_escape_string($city);
        $state = $this->real_escape_string($state);
        $email = $this->real_escape_string($email);
        $this->query("UPDATE Employee SET Name = '" . $manager_name .
                "', Street = '" . $street . "', City = '" . $city . "', State = '" . $state . "', Zipcode = '" . $zipcode . "', Email = '" . $email . "', Salary = " . $salary ." WHERE EmployeeID = " . $store_manager_id);
        $this->query("UPDATE Store_Mapping SET Assigned_Store = ". $store_id ." WHERE EmployeeID = " . $store_manager_id);
    }  
    
    public function update_region_manager($region_manager_id, $region_manager_name, $street, $city, $state, $zipcode, $email, $salary){
        $region_manager_name = $this->real_escape_string($region_manager_name);
        $street = $this->real_escape_string($street);
        $city = $this->real_escape_string($city);
        $state = $this->real_escape_string($state);
        $email = $this->real_escape_string($email);
        $this->query("UPDATE Employee SET Name = '" . $region_manager_name .
                "', Street = '" . $street . "', City = '" . $city . "', State = '" . $state . "', Zipcode = '" . $zipcode . "', Email = '" . $email . "', Salary = " . $salary ." WHERE EmployeeID = " . $region_manager_id);
    }  
    
    public function get_all_region(){
        return $this->query("SELECT RegionID, Region_Name, Region_ManagerID, Employee.Name FROM Region, Employee WHERE region.Region_ManagerID = Employee.EmployeeID");
    }
    
    public function delete_region($region_id){
        $this->query("DELETE FROM Region WHERE RegionID = ". $region_id);
    }
    
    public function insert_region($region_name, $region_manager_id){
        $region_name = $this->real_escape_string($region_name);
        $this->query("INSERT INTO Region (Region_Name, Region_ManagerID) VALUES('". $region_name ."',". $region_manager_id .")");
    }
    
    public function update_region($region_id, $region_name, $region_manager_id){
        $region_name = $this->real_escape_string($region_name);
        $sql = "UPDATE region SET Region_Name = '" . $region_name . 
                "', Region_ManagerID = " . $region_manager_id . " WHERE RegionID = ". $region_id ;
        $this->query($sql);
    }
    
    public function delete_store($store_id){
        $result = $this->query("SELECT Store_ManagerID FROM Store WHERE StoreID = '". $store_id . "'");
        $row = mysqli_fetch_array($result);
        $store_manager_id = $row["Store_ManagerID"];
        $this->query("DELETE FROM Store WHERE StoreID  = ". $store_id);
        $this->query("DELETE FROM Store_Mapping WHERE EmployeeID  = ". $store_manager_id);
    }
    
    public function get_region_by_id($region_id){
        return $this->query("SELECT RegionID, Region_Name, Region_ManagerID FROM Region WHERE RegionID = ". $region_id);
    }
    
    public function get_all_store(){
        $sql = "SELECT StoreID, Store_ManagerID, Store_Name, Region_ID, Store.Street, Store.City, Store.State, Store.ZipCode, Employee.Name, Region.Region_Name From Store,Employee,Region WHERE Store_ManagerID = EmployeeID and Region_ID=RegionID GROUP BY (StoreID)";
        return $this->query($sql);
    }
    
    public function get_number_of_salesman($store_id){
        $sql = "SELECT Assigned_Store, count(EmployeeID) as Employee_Number 
                FROM Store_Mapping
                Where Assigned_Store = ". $store_id;
        return $this->query($sql);
                
    }
    
    public function get_store_by_id($store_id){
        $sql = "SELECT StoreID, Store_ManagerID, Region_ID, Store_Name, Store.Street, Store.City, Store.State, Store.ZipCode, Employee.Name, Region.Region_Name 
                From Store,Employee,Region WHERE Store_ManagerID = EmployeeID and Region_ID=RegionID and StoreID= " . $store_id ." GROUP BY (StoreID)";
        return $this->query($sql);
    }
    
    public function insert_store($manager_id, $region_id, $store_name, $street_name, $city, $state, $zip_code){
        $store_name = $this->real_escape_string($store_name);
        $street_name = $this->real_escape_string($street_name);
        $city = $this->real_escape_string($city);
        $state = $this->real_escape_string($state);
        $sql = "INSERT INTO FinalProject.Store (Store_ManagerID, Region_ID, Store_Name, Street, City, State, ZipCode) VALUES ('". $manager_id ."', '". $region_id ."', '". $store_name ."', '". $street_name ."', '". $city ."', '". $state ."', '". $zip_code . "')";
        //$result = mysql_query($sql) or trigger_error(mysql_error()." ".$sql);
        $this->query($sql);
        $this->query("INSERT INTO Store_Mapping (EmployeeID, Assigned_Store)" . 
                        "VALUES (" . $manager_id . ", LAST_INSERT_ID())");
    }
    
    public function update_store($store_id, $manager_id, $region_id, $store_name, $street_name, $city, $state, $zip_code){
        $store_name = $this->real_escape_string($store_name);
        $street_name = $this->real_escape_string($street_name);
        $city = $this->real_escape_string($city);
        $state = $this->real_escape_string($state);
        $sql = "UPDATE FinalProject.Store SET Store_ManagerID = ". $manager_id .", Region_ID = ". $region_id .
                ", Store_Name = '". $store_name ."', Street = '". $street_name ."', City = '". $city ."', State = '". $state ."', ZipCode = ". $zip_code . " WHERE StoreID = ". $store_id;
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
        $sql = "Select T.TransactionID, C.Name, E.Name as SalespersonName, T.date, T.Status
                From Transaction as T, Customer as C, Employee as E
                Where T.CustomerID = C.CustomerID and T.SalespersonID = E.EmployeeID and C.Type='Individual'";
        return $this->query($sql);        
    }
    
    public function get_all_transaction_business(){
        $sql = "Select T.TransactionID, C.Name, E.Name as SalespersonName, T.date, T.Status
                From Transaction as T, Customer as C, Employee as E
                Where T.CustomerID = C.CustomerID and T.SalespersonID = E.EmployeeID and C.Type= 'Business'";
        return $this->query($sql);        
    }
    
    public function get_all_product_by_transaction_id($transaction_id){
        $sql = "Select P.name
                From Transaction as T, TransactionDetails as TS, Product as P
                Where T.TransactionID = TS.TransactionID and P.ProductID = TS.ProductID and T.TransactionID = ". $transaction_id;
        return $this->query($sql);
    }
    
    public function confirm_transaction($transaction_id){
        $sql = "UPDATE Transaction SET Status = 'Completed' WHERE TransactionID =".$transaction_id;
        return $this->query($sql);
        $sql = "SELECT sum(ProductPrice*Quantity) as TotalAmount FROM FinalProject.TransactionDetails Where TransactionID =".$transaction_id;
        $result = $this->query($sql);
        $row = mysqli_fetch_array($result);
        $TotalAmount = $row["TotalAmount"];
        mysqli_free_result($result);
        $remark = "Completed";
        $sql = "INSERT INTO Transaction_Payment (TranscationID, Payment_Amout, Status)"
             . "VALUES(". $transaction_id .",". $TotalAmount . ", ' . $remark . ')";
        $this->query($sql);
    }
    
    public function delete_transaction($transaction_id){
        $this->query("DELETE FROM Transaction WHERE TransactionID = ". $transaction_id);
    }
    
    public function insert_transaction($customer_id, $salesman_name, $date, $remark){
        $salesman_name = $this->real_escape_string($salesman_name);
        $result = $this->query("SELECT Employee.EmployeeID, Assigned_Store FROM Employee, Store_Mapping WHERE Employee.EmployeeID=Store_Mapping.EmployeeID and Name = '". $salesman_name . "'");
        $row = mysqli_fetch_array($result);
        $salesman_id = $row["EmployeeID"];
        $store_id = $row["Assigned_Store"];
        mysqli_free_result($result);
        $remark = $this->real_escape_string($remark);
        $sql = "INSERT INTO Transaction (CustomerID, SalespersonID, StoreID, Date, Status) "
                . "VALUES(". $customer_id .",". $salesman_id . ",". $store_id . ", '". $date . "', '". $remark . "')";
        $this->query($sql);
    }
    
    public function insert_order_specify($last_transaction_id, $id, $amount){
        $result = $this->query("SELECT Inventory, Base_Price FROM Product WHERE ProductID = ". $id . "");
        $row = mysqli_fetch_array($result);
        $base_price = $row["Base_Price"];
        $Inventory = $row["Inventory"];
        mysqli_free_result($result);
        if($Inventory<$amount){
        $this->query("DELETE FROM Transaction WHERE TransactionID = ". $last_transaction_id);
        }
        else {
        $sql = "INSERT INTO TransactionDetails (TransactionID, ProductID, Quantity, ProductPrice) "
                . "VALUES(". $last_transaction_id .", ". $id .", ". $amount .",". $base_price .")";
        $this->query($sql);
        }
    }
    
    public function get_all_customer_id(){
        return $this->query("select CustomerID from customer");
    }
    
    public function get_all_customer_business(){
        return $this->query("select business_name from business");
    }
    
    public function get_all_product(){
        return $this->query("select * from Product where Inventory > 0");
    }
    
    public function reduce_product($product_id, $amount){
        $sql = "UPDATE Product SET Inventory = Inventory-". $amount ." WHERE ProductID=". $product_id;
        $this->query($sql);
    }
    
    public function get_product_comp(){
        $sql = "select P.name, P.Category, P.Base_Price, sum(TS.Quantity) as total_sell, (sum(TS.Quantity)*P.Base_Price-sum(TS.Quantity)*P.Cost) as profit
                from TransactionDetails as TS, product as P
                where TS.ProductID = P.ProductID
                group by P.ProductID
                order by total_sell desc";
        return $this->query($sql);
    }
    
    public function get_salesman_comp(){
        $sql ="select E.name, E.Email, SM.Assigned_Store as StoreID, count(T.TransactionID) as total_order
               from Employee as E, transaction as T, Store_Mapping as SM
               where T.SalespersonID = E.EmployeeID and E.EmployeeID=SM.EmployeeID
               group by T.SalespersonID
               order by total_order desc";
        return $this->query($sql);
    }
    
    public function get_store_comp(){
        $sql = "Select S.StoreID, S.Store_Name, E.name as Store_Manager, S.Street, S.City, S.State, S.Zipcode, count(T.TransactionID) as total_order
                From Store as S, Transaction as T, Employee as E
                Where T.StoreID=S.StoreID and E.EmployeeID=S.Store_ManagerID
                Group by T.StoreID
                Order by total_order desc";
        return $this->query($sql);
    }
    
    public function get_region_comp(){
        $sql = "Select R.Region_Name, E.name, count(T.TransactionID) as total_order
                From Region as R, Store as S, Employee as E, Transaction as T
                Where R.RegionID = S.Region_ID and R.Region_ManagerID = E.EmployeeID and T.StoreID=S.StoreID
                Group by R.RegionID
                Order by total_order desc";
        return $this->query($sql);
    }
    
    public function get_cusotmer_comp(){
        $sql = "select C.name,count(T.TransactionID) as total_order
                from Customer as C, Transaction as T
                where C.CustomerID = T.CustomerID
                group by C.CustomerID
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
    
    public function get_product_business_by_name($name){
        $name = $this->real_escape_string($name);
        return $this->query("select Business_Category, sum(Quantity) as Total_Bought
                             from FinalProject.Product,FinalProject.TransactionDetails,FinalProject.Transaction,FinalProject.Business_Customer
                             where FinalProject.Product.ProductID=FinalProject.TransactionDetails.ProductID 
                             and FinalProject.TransactionDetails.TransactionID=FinalProject.Transaction.TransactionID
                             and FinalProject.Transaction.CustomerID=FinalProject.Business_Customer.CustomerID
                             and FinalProject.Product.Name= '" . $name . "' group by Business_Category;");
        }     
    
    public function verify_users ($name, $password){
        $name = $this->real_escape_string($name);
        $password = $this->real_escape_string($password);
        $result = $this->query("SELECT 1 FROM Login
 	           WHERE User_Name = '" . $name . "' AND Password = '" . $password . "'");
        return $result->data_seek(0);
    }
}
