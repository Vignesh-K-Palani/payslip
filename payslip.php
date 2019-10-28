<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>PAY SLIP</title>
	<style>
	img{
		position:absolute;
		left:115px;
		top:65px;
	}
	.rht{
		align:right;
	}
	</style>
	<script>  
          
        // Function to change the color of element 
        function print_page() { 
            document.getElementById("print").style.visibility="hidden";
			window.print();			
            //demo.style.color = "green"; 
        }  
        </script>  
  </head>
  <body style="font-size:100%;left:100px">
  
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	
	
	
<?php
//session_start();
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "pay_slip_generator";

$month = '';

//echo $_POST["Submit"];

//echo $_POST["Month"];

if(isset($_POST['Month']) && $_POST['Month'] !== ""){
	$month = $_POST['Month'];
}else{
	echo $_POST['Month'];
}
//echo $month;
 
//echo $month;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
//if(isset($faculty_id)) {
	//echo "Hi"."\n";
// If table is not created, use the following

// Employee Details Table
/*$sql = "CREATE TABLE Emp_Details (
faculty_id INT(9) NOT NULL UNSIGNED AUTO_INCREMENT,
name VARCHAR(30),
designation VARCHAR(30),
department VARCHAR(30), 
month VARCHAR(30) NOT NULL,
date_of_joining DATE,
probation_period INT,
PRIMARY KEY(faculty_id, month)
)";*/

// Employee Earning Details Table
/*$sql = "CREATE TABLE Emp_Earning_Details (
CONSTRAINT FK_Emp_Earning_Details FOREIGN KEY (faculty_id, month) REFERENCES Emp_Details(faculty_id, month),
basic FLOAT(10, 2),
agp FLOAT(10, 2),
da FLOAT(10, 2),
hra FLOAT(10, 2),
cca FLOAT(10, 2),
ca FLOAT(10, 2),
ma FLOAT(10, 2),
sa FLOAT(10, 2),
addl_remuneration FLOAT(10, 2),
gross_pay FLOAT(10, 2)
)";*/

// Employee Deduction Details Table
/*$sql = "CREATE TABLE Emp_Deduction_Details (
CONSTRAINT FK_Emp_Deduction_Details FOREIGN KEY (faculty_id, month) REFERENCES Emp_Details(faculty_id, month),
lop INT,
pf FLOAT(10, 2),
pt FLOAT(10, 2),
tds FLOAT(10, 2),
advance_loan FLOAT(10, 2),
)";*/

// LOP Formula
/*LOP=(GrossSal/DMonth)*LopDays;
NetSalary=((GrossSal-LOP)-Advance);*/


// variable decl.

$staff_id = 0;
$name = "";
$designation = "";
$department = "";
$date_of_joining = "";
$working_days = 0;
$days_present = 0;
$days_absent = 0;
$probation_period = "";
$hra = 0;
$basic= 0;
$grade_pay = 0;
$da = 0;
$hra= 0;
$cca= 0;
$ca= 0;
$ma= 0;
$sa= 0;
$arrear_pay= 0;
$over_time_pay = 0;
$advance_loan_given = 0;
$total_pay = 0;
$gross_pay= 0;
$net_pay = 0;
$lop = 0;
$epf = 0;
$vpf = 0;
$esi = 0;
$tds= 0;
$pt =0;
$loan_received = 0;
$Transport = 0;
$total_deductions= 0;

$sql_month = "SELECT pay_slip_details.`Staff ID No.`, pay_slip_details.`Month` from pay_slip_details where pay_slip_details.Month = '".$month."'";//.$faculty_id."";
$result_month = mysqli_query($conn, $sql_month);
//echo $result_month;
if (mysqli_num_rows($result_month) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result_month)) {
		$staff_id = $row['Staff ID No.'];
		$month = $row['Month'];
		//echo $staff_id;
		$sql = "SELECT pay_slip_details.* from pay_slip_details where pay_slip_details.`Month` = '".$month."' and pay_slip_details.`Staff ID No.` = ".$staff_id." group by pay_slip_details.`Department`";//`Staff ID No.`, pay_slip_details.`Name`, pay_slip_details.`Designation`, pay_slip_details.`Department`, pay_slip_details.`Date of joining`, pay_slip_details.`Month`, pay_slip_details.`No of Working days`, pay_slip_details.`No of Days Present`, pay_slip_details.`No of Days Absent`, pay_slip_details.`Scale of Pay`, pay_slip_details.`Basic Pay`, pay_slip_details.`Grade Pay`, pay_slip_details.`Da`, pay_slip_details.`HRA`, pay_slip_details.`CCA`,pay_slip_details.`CA`, pay_slip_details.`Ma`, pay_slip_details.`SA`, pay_slip_details.`Gross Pay`, pay_slip_details.`Arrear Pay`, pay_slip_details.`Overtime Pay`, pay_slip_details.`Advance Loan Given`, pay_slip_details.`Loss of Pay`, pay_slip_details.`EPF`, pay_slip_details.`ESI`, pay_slip_details.`TDS`, pay_slip_details.`PT`, pay_slip_details.`Advance Loan Deducted`, pay_slip_details.`Transport`, pay_slip_details.`Total Deductions`, pay_slip_details.`Net Pay` from pay_slip_details where pay_slip_details.`Month` = 'Sep-2019' and pay_slip_details.`Staff ID No.` = ".$staff_id."";
		$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		$staff_id = $row["Staff ID No."];
		//echo $staff_id;
		$name = $row["Staff Name"];
		$designation = $row["Designation"];
		$department = $row["Department"];
		$date_of_joining = $row["Date of Joining"];
		$month = $row["Month"];
		$working_days = $row["No. of Days Working"];
		$days_present = $row["No. of Days Present"];
		$days_absent = $row["No. of Days Absent"];
		$probation_period = $row["Scale of Pay"];
		
		$basic = $row[" Basic Pay"];
		$grade_pay = $row[" Grade Pay"];
		$da = $row["Dearness Allowance"];
		$hra = $row["House Rent Allowance"];
		$cca = $row[" City Compensatory Allowance"];
		$ca = $row["Conveyance Allowance"];
		$ma = $row["Medical Allowance"];
		$sa = $row["Special Allowance"];
		$gross_pay = $row["Gross Pay"];
		$arrear_pay = $row["Arrear Pay"];
		$over_time_pay = $row["Over Time Pay"];
		$advance_loan_given = $row["Loan Advanced"];
		$total_pay = $row["Total Pay"];
		$net_pay = $row["Net Pay"];
		
		$lop = $row[" Loss of Pay"];
		$epf = $row["EPF"];
		$vpf = $row["VPF"];
		$esi = $row["ESI"];
		$tds = $row["TDS"];
		$pt = $row["Professional Tax"];
		$advance_loan_deducted = $row["Loan Recovered"];
		$Transport = $row["Transport"];
		$total_deductions = $row["Total Deductions"];
    }
} else {
    echo "0 results";
}

if($name == ''){
	$name = '-';
}
if($designation == ''){
	$designation = '-';
}
if($department == ''){
	$department = '-';
}
if($date_of_joining == ''){
	$date_of_joining = '-';
}
if($month == ''){
	$month = '-';
}
if($working_days == ''){
	$working_days = '-';
}
if($days_present == ''){
	$days_present = '-';
}
if($days_absent == ''){
	$days_absent = '-';
}
if($probation_period == ''){
	$probation_period = '-';
}
if($basic == ''){
	$basic = '-';
}
if($grade_pay == ''){
	$grade_pay = '-';
}
if($da == ''){
	$da = '-';
}
if($hra == ''){
	$hra = '-';
}
if($cca == ''){
	$cca = '-';
}
if($ca == ''){
	$ca = '-';
}
if($ma == ''){
	$ma = '-';
}
if($sa == ''){
	$sa = '-';
}
if($gross_pay == ''){
	$gross_pay = '-';
}
if($arrear_pay == ''){
	$arrear_pay = '-';
}
if($over_time_pay == ''){
	$over_time_pay = '-';
}
if($advance_loan_given == ''){
	$advance_loan_given = '-';
}
if($total_pay == ''){
	$total_pay = '-';
}
if($net_pay == ''){
	$net_pay = '-';
}
if($lop == ''){
	$lop = '-';
}
if($epf == ''){
	$epf = '-';
}
if($vpf == ''){
	$vpf = '-';
}
if($esi == ''){
	$esi = '-';
}
if($tds == ''){
	$tds = '-';
}
if($pt == ''){
	$pt = '-';
}
if($advance_loan_deducted == ''){
	$advance_loan_deducted = '-';
}
if($Transport == ''){
	$Transport = '-';
}
if($total_deductions == ''){
	$total_deductions = '-';
}


//$sql = "SELECT basic, agp, da, hra, cca, ca, ma, sa, addl_remuneration FROM emp_earning_details where emp_earning_details.month = \'Aug 2019\'";
/*
$sql = "SELECT emp_earning_details.* from emp_earning_details where emp_earning_details.month = '".$month."' and emp_earning_details.faculty_id = '".$faculty_id."'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
		$basic = $row["basic"];
		$agp = $row["agp"];
		$da = $row["da"];
		$hra = $row["hra"];
		$cca = $row["cca"];
		$ca = $row["ca"];
		$ma = $row["ma"];
		$sa = $row["sa"];
		$addl_remuneration = $row["addl_remuneration"];
    }
} else {
    echo "0 results";
}

// HRA Calc.

$hra = $hra1;
$hra2 = 0.1*($basic + $agp + $da);
$hra3 = 0.5*($basic + $agp + $da);
if($hra1 > $hra2){
	if($hra1 > $hra3){
		$hra = $hra1;
	}
	else{
		$hra = $hra3;
	}
}else{
	if($hra2 > $hra3){
		$hra = $hra2;
	}
}


$sql1 = "SELECT lop, pf, pt, tds, advance_loan FROM emp_deduction_details where emp_deduction_details.month = '".$month."' and emp_deduction_details.faculty_id = '".$faculty_id."'";
$result1 = mysqli_query($conn, $sql1);

if (mysqli_num_rows($result1) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result1)) {
		$lop = $row["lop"];
		$pf = $row["pf"];
		$pt = $row["pt"];
		$tds = $row["tds"];
		$advance_loan = $row["advance_loan"];
    }
} else {
    echo "0 results";
}

$gross_pay = $basic + $agp + $da + $hra + $cca + $ca + $ma + $sa + $addl_remuneration;
$total_deduction = $lop + $pf + $pt + $tds + $advance_loan;
$net_pay = $gross_pay - $total_deduction;
*/
//header("Location: ");

echo "
	
	<div class=\"container\">
	
	<img src=\"licet.png\" style=\"width:70px;min-height:70px;position:relative;left:1px;top:65px;\">
  <center><b>LOYOLA-ICAM COLLEGE OF ENGINEERING AND TECHNOLOGY (LICET)&nbsp;</center>
  <center>&nbsp;LOYOLA CAMPUS, CHENNAI</center>
  <center>&nbsp;<u>PAY SLIP</u></b>&nbsp;</center>
  
  
		<div class=\"row\">
			<div class=\"col-sm-6\">
				<table>
					<tr>
						<td>Staff ID No. </td>
						<td>&nbsp;&nbsp;&nbsp;".$staff_id."</td>
					</tr>
					<tr>
						<td>Staff Name </td>
						<td>&nbsp;&nbsp;&nbsp;".$name."</td>
					</tr>
					<tr>
						<td>Designation </td>
						<td>&nbsp;&nbsp;&nbsp;".$designation."</td>
					</tr>
					<tr>
						<td>Department </td>
						<td>&nbsp;&nbsp;&nbsp;".$department."</td>
					</tr>
					<tr>
						<td>Date of Joining </td>
						<td>&nbsp;&nbsp;&nbsp;".$date_of_joining."</td>
					</tr>
				</table>
			</div>
			<div class=\"col-sm-6\">
				<table>
					<tr>
						<td>For the Month of</td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;".$month."</td>
					</tr>
					<tr>
						<td>No. of Days Worked</td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;".$working_days."</td>
					</tr>
					<tr>
						<td>No. of Days Present </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;".$days_present."</td>
					</tr>
					<tr>
						<td>No. of Days Absent </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;".$days_absent."</td>
					</tr>
					<tr>
						<td>Scale of Pay </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;".$probation_period."</td>
					</tr>
				</table>
			</div>
		</div>
		
		
		
		<div class=\"row\">
			<div class=\"col-sm-6\">
				<table>
					<tr>
						<th>Earnings:</th>
					</tr>
					<tr>
						<td>Basic Pay </td>
						<td class=\"text-right\">".$basic."</td>
					</tr>
					<tr>
						<td>Grade Pay </td>
						<td class=\"text-right\">".$grade_pay."</td>
					</tr>
					<tr>
						<td>Dearness Allowance </td>
						<td class=\"text-right\">".$da."</td>
					</tr>
					<tr>
						<td>House Rent Allowance </td>
						<td class=\"text-right\">".$hra."</td>
					</tr>
					<tr>
						<td>City Compensatory Allowance </td>
						<td class=\"text-right\">".$cca."</td>
					</tr>
					<tr>
						<td>Conveyance Allowance </td>
						<td class=\"text-right\">".$ca."</td>
					</tr>
					<tr>
						<td>Medical Allowance </td>
						<td class=\"text-right\">".$ma."</td>
					</tr>
					<tr>
						<td>Special Allowance </td>
						<td class=\"text-right\">".$sa."</td>
					</tr>
					<tr>
						<th>Gross Pay </th>
						<td class=\"text-right\"><b>".$gross_pay."</b></td>
					</tr>
					<tr>
						<td><b></b>Arrear Pay </td>
						<td class=\"text-right\">".$arrear_pay."</td>
					</tr>
					<tr>
						<td><b></b>Over Time Pay </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$over_time_pay."</td>
					</tr>
					<tr>
						<td><b></b>Loan Advanced</td>
						<td class=\"text-right\">".$advance_loan_given."</td>
					</tr>
					<tr>
						<td><b>Total Pay</b></td>
						<td class=\"text-right\"><b>".$total_pay."</b></td>
					</tr>
					<tr>
						<td><b></b>Total Deductions </td>
						<td class=\"text-right\">".$total_deductions."</td>
					</tr>
					<tr>
						<td><b>Net Pay </b></td>
						<td class=\"text-right\"><b>".$net_pay."</b></td>
					</tr>
				</table>
			</div>
			<div class=\"col-sm-6\">
				<table>
					<tr>
						<th>Deductions:</th>
					</tr>
					<tr>
						<td>Loss of Pay </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$lop."</td>
					</tr>
					<tr>
						<td>EPF </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$epf."</td>
					</tr>
					<tr>
						<td>VPF </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$vpf."</td>
					</tr>
					<tr>
						<td>ESI </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$esi."</td>
					</tr>
					<tr>
						<td>TDS </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tds."</td>
					</tr>
					<tr>
						<td>Professional Tax </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pt."</td>
					</tr>
					<tr>
						<td>Loan Recovered </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$advance_loan_deducted."</td>
					</tr>
					<tr>
						<td>Transport </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$Transport."</td>
					</tr>
					<tr>
						<th>Total Deductions </th>
						<td class=\"text-right\"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$total_deductions."</b></td>
					</tr>
					<tr>
						<th><br></th>
						<td class=\"text-right\"></td>
					</tr>
					<tr>
						<th><br></th>
						<td class=\"text-right\"></td>
					</tr>
					<tr>
						<th><br></th>
						<td class=\"text-right\"></td>
					</tr>
					<tr>
						<th><br></th>
						<td class=\"text-right\"></td>
					</tr>
					<tr>
						<th><br></th>
						<td class=\"text-right\"></td>
					</tr>
					<tr>
						<td><h6 style=\"font-size:90%;\">Staff Signature</h6></td>
						<td class=\"text-right\"><h6 style=\"font-size:90%;\">Authorized Signatory</h6></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<br><hr>


<div class=\"container\">
	
	<img src=\"licet.png\" style=\"width:70px;min-height:70px;position:relative;left:1px;top:65px;\">
  <center><b>LOYOLA-ICAM COLLEGE OF ENGINEERING AND TECHNOLOGY (LICET)&nbsp;</center>
  <center>&nbsp;LOYOLA CAMPUS, CHENNAI</center>
  <center>&nbsp;<u>PAY SLIP</u></b>&nbsp;</center>
  
  
		<div class=\"row\">
			<div class=\"col-sm-6\">
				<table>
					<tr>
						<td>Staff ID No. </td>
						<td>&nbsp;&nbsp;&nbsp;".$staff_id."</td>
					</tr>
					<tr>
						<td>Staff Name </td>
						<td>&nbsp;&nbsp;&nbsp;".$name."</td>
					</tr>
					<tr>
						<td>Designation </td>
						<td>&nbsp;&nbsp;&nbsp;".$designation."</td>
					</tr>
					<tr>
						<td>Department </td>
						<td>&nbsp;&nbsp;&nbsp;".$department."</td>
					</tr>
					<tr>
						<td>Date of Joining </td>
						<td>&nbsp;&nbsp;&nbsp;".$date_of_joining."</td>
					</tr>
				</table>
			</div>
			<div class=\"col-sm-6\">
				<table>
					<tr>
						<td>For the Month of</td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;".$month."</td>
					</tr>
					<tr>
						<td>No. of Days Worked</td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;".$working_days."</td>
					</tr>
					<tr>
						<td>No. of Days Present </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;".$days_present."</td>
					</tr>
					<tr>
						<td>No. of Days Absent </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;".$days_absent."</td>
					</tr>
					<tr>
						<td>Scale of Pay </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;".$probation_period."</td>
					</tr>
				</table>
			</div>
		</div>
		
		
		
		<div class=\"row\">
			<div class=\"col-sm-6\">
				<table>
					<tr>
						<th>Earnings:</th>
					</tr>
					<tr>
						<td>Basic Pay </td>
						<td class=\"text-right\">".$basic."</td>
					</tr>
					<tr>
						<td>Grade Pay </td>
						<td class=\"text-right\">".$grade_pay."</td>
					</tr>
					<tr>
						<td>Dearness Allowance </td>
						<td class=\"text-right\">".$da."</td>
					</tr>
					<tr>
						<td>House Rent Allowance </td>
						<td class=\"text-right\">".$hra."</td>
					</tr>
					<tr>
						<td>City Compensatory Allowance </td>
						<td class=\"text-right\">".$cca."</td>
					</tr>
					<tr>
						<td>Conveyance Allowance </td>
						<td class=\"text-right\">".$ca."</td>
					</tr>
					<tr>
						<td>Medical Allowance </td>
						<td class=\"text-right\">".$ma."</td>
					</tr>
					<tr>
						<td>Special Allowance </td>
						<td class=\"text-right\">".$sa."</td>
					</tr>
					<tr>
						<th>Gross Pay </th>
						<td class=\"text-right\"><b>".$gross_pay."</b></td>
					</tr>
					<tr>
						<td><b></b>Arrear Pay </td>
						<td class=\"text-right\">".$arrear_pay."</td>
					</tr>
					<tr>
						<td><b></b>Over Time Pay </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$over_time_pay."</td>
					</tr>
					<tr>
						<td><b></b>Loan Advanced</td>
						<td class=\"text-right\">".$advance_loan_given."</td>
					</tr>
					<tr>
						<td><b>Total Pay</b></td>
						<td class=\"text-right\"><b>".$total_pay."</b></td>
					</tr>
					<tr>
						<td><b></b>Total Deductions </td>
						<td class=\"text-right\">".$total_deductions."</td>
					</tr>
					<tr>
						<td><b>Net Pay </b></td>
						<td class=\"text-right\"><b>".$net_pay."</b></td>
					</tr>
				</table>
			</div>
			<div class=\"col-sm-6\">
				<table>
					<tr>
						<th>Deductions:</th>
					</tr>
					<tr>
						<td>Loss of Pay </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$lop."</td>
					</tr>
					<tr>
						<td>EPF </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$epf."</td>
					</tr>
					<tr>
						<td>VPF </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$vpf."</td>
					</tr>
					<tr>
						<td>ESI </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$esi."</td>
					</tr>
					<tr>
						<td>TDS </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tds."</td>
					</tr>
					<tr>
						<td>Professional Tax </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pt."</td>
					</tr>
					<tr>
						<td>Loan Recovered </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$advance_loan_deducted."</td>
					</tr>
					<tr>
						<td>Transport </td>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$Transport."</td>
					</tr>
					<tr>
						<th>Total Deductions </th>
						<td class=\"text-right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".$total_deductions."</b></td>
					</tr>
					<tr>
						<th><br></th>
						<td class=\"text-right\"></td>
					</tr>
					<tr>
						<th><br></th>
						<td class=\"text-right\"></td>
					</tr>
					<tr>
						<th><br></th>
						<td class=\"text-right\"></td>
					</tr>
					<tr>
						<th><br></th>
						<td class=\"text-right\"></td>
					</tr>
					<tr>
						<th><br></th>
						<td class=\"text-right\"></td>
					</tr>
					<tr>
						<td><h6 style=\"font-size:90%;\">Staff Signature</h6></td>
						<td class=\"text-right\"><h6 style=\"font-size:90%;\">Authorized Signatory</h6></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<br><hr>

	";

}
echo "<form>
    <input id=\"print\" class=\"w3-display-topright\" type=\"button\" value=\"Print\" 
               onclick=\"print_page()\" />  
    </form>";}//}



mysqli_close($conn);
?>
</div>
</body>
</html>