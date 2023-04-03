<?php
echo view('cpanel-layout/header');
// Top Bar Start
echo view('cpanel-layout/topbar');
// Top Bar End
echo view('cpanel-layout/navbar');
// Left Sidebar End

?>
<style>

.main-img{
    display: flex;
    justify-content: center;
}
.first img{
    width: 120px;
    display: flex;
    justify-content: center;
    border: 3px solid black;
    margin-top: 30px;
    height: 120px;
}
.first h2{
    display: flex;
    justify-content: center;
}
.first h4{
    display: flex;
    justify-content: center;
}
label {
    /* Other styling... */
    text-align: right;
    clear: both;
    float:left;
    width: 100px;
    margin-top: 10px;
     margin-right:15px; 
}
 table{
    border: none;    
} 
tbody{
    border: none;    
}
table tr {
    display: flex;
    justify-content: space-between;
   margin: 10px;
   align-items: center;
   border-bottom: 1px solid  rgb(228, 228, 228);    
   
}
input{
    width: 80%;
    border: 1px solid lightgrey;
    height: 40px;
  margin-top: 10px;
}
table td{
    padding: 2px !important; 
    text-align: center; 
    border-top: none !important;
}
/* .second .table2{
    border: 1px solid black;
} */
/* .second h2{
    text-align: center;
} */
@media only screen and (max-width:576px){
    .first h4{
        font-size: 13px;
    }
    .first h2{
        font-size: 30px;
    }
    .second h2{
        font-size: 20px;
    }
}
</style>
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<div class="page-title-box">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<h4 class="page-title">My Profile</h4>
					</div>
				</div>
			</div>
			<!-- end row -->
			<!-- <div class="row">
				<div class="col-md-12">
					<p>Page content here with seprate rows</p>
				</div>
			</div> -->
			<div class="row">
            <div class="first col-lg-5">
                <!-- <h2>My Profile</h2> -->
                <div class="main-img">
                    <img src="./images/small.jpg" class="rounded-circle border-primary"
                        alt="Cinque Terre"></div>
                <h2>Husnain Babar</h2>
                <h4>hnbajdbcb@gmail.com</h4>
                <table class="table">
                 
                    <tbody>
                        <tr>
                            <td>Dept:</td>
                            <td>IT/Software</td>
                        </tr>
                        <tr>
                            <td>Designation:</td>
                            <td>SR.Developer</td>
                        </tr>
                        <tr>
                            <td>Contract Type:</td>
                            <td class="badge badge-info rounded mr-2 pt-2">Full Time</td>
                        </tr>
                        <tr>
                            <td>Working Days:</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Grace Time:</td>
                            <td class="badge badge-success h-10 rounded mr-2 pt-2">10:15 am</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="second col-lg-7">
                <h2>Contract Detail</h2>
                <table class="table">
                    <!-- <thead>
                        
                    </thead> -->
                    <tbody>
                        <tr>
                            <th>Name:</th>
                            <td>Husnain</td>
                        </tr>
                        <tr>
                            <th>Husband/Father Name:</th>
                            <td>ffff</td>
                        </tr>
                        <tr>
                            <th>Gender:</th>
                            <td>Male</td>
                        </tr>
                        <tr>
                            <th>DOB:</th>
                            <td>7/17/2006</td>
                        </tr>
                        <tr>
                            <th>Country:</th>
                            <td>Pakistan</td>
                        </tr>
                        <tr>
                            <th>City:</th>
                            <td>Karachi</td>
                        </tr>
                        <tr>
                            <th>NIC NO:</th>
                            <td>42301-44444-22222 </td>
                        </tr>
                        <tr>
                            <th>Religion:</th>
                            <td>Muslim</td>
                        </tr>
                        <tr>
                            <th>Martial Status:</th>
                            <td>Married</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
			<!-- end row -->
		</div>
		<!-- container-fluid -->
		
	</div>
	
	<!-- content -->
	
<?php 
echo view('cpanel-layout/footer');
?>
