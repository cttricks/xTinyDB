<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home - xTinyDB</title>
	<link rel="icon" href="assets/favicon.png">
	<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link type="text/css" rel="stylesheet" href="assets/main.css">
	<link type="text/css" rel="stylesheet" href="assets/dashboard.css">
	<link type="text/css" rel="stylesheet" href="assets/tree.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
	<header>
		<div class="header-left">
			<img src="assets/cloud.png">
			<div class="header-text">
				<h1>xTiny DB</h1>
			</div>
		</div>
		<div class="header-middle">
			<ul>
				<li class="active">Home</li>
				<li><a href="https://github.com/cttricks/xTinyDB" target="_blank">GitHub</a></li>
			</ul>
		</div>
		<div class="header-right">
			<div class="userdetails">
				<div class="username" style="width: 70px">Ct-tricks</div>
				<div class="useravtar">
					<img src="assets/unnamed.png">
				</div>
			</div>
		</div>
	</header>
	<section id="logintodb">
		<div class="dburlform">
			<h1>Connect Database</h1>
			<p>Provide the required details to CRUD data using this web tool</p>
			<div class="inpForm">
				<div><i class="fa fa-link" aria-hidden="true"></i></div>
				<input type="text" placeholder="Server URL" id="serverurl" value="<?php echo "http://". $_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI'] . "Test1"; ?>"/>
			</div>
			<div class="inpForm">
				<div><i class="fa fa-archive" aria-hidden="true"></i></div>
				<input type="text" placeholder="Bucket Name" id="cbucket" />
			</div>
			<div class="inpForm">
				<div><i class="fa fa-lock" aria-hidden="true"></i></div>
				<input type="text" placeholder="Access Key" id="accesskey" value="sampleaccesskey01" />
			</div>
			<div class="btnContainer">
				<button onclick="connectDB()">Continue</button>
			</div>
		</div>
	</section>
	<section id="mainBodyContainer">
		<div class="mbc-head">
			<div class="links">
				<p><i class="fa fa-link" aria-hidden="true"></i><span id="serverurllabel">https://cttricks.com/xtinydb/help_cttricks</span></p>
			</div>
			<div class="button">
				<i onclick="storeForm()" class="fa fa-plus-square-o tobebig" aria-hidden="true" data-element="Add New Tag"></i>
				<i class="fa fa-tags tobebigbtn" aria-hidden="true" onclick="viewHideTags()" data-element="Hide Tags"></i>
				<i class="fa fa-inbox tobebigbtn" aria-hidden="true" onclick="viewHideBucket()" data-element="Hide Sub-Buckets"></i>
				<i onclick="connectDB()" class="fa fa-refresh" aria-hidden="true" data-element="Refresh"></i>
				<i onclick="copyData()" class="fa fa-clone" aria-hidden="true" data-element="Copy Bucket"></i>
				<i onclick="showCDBox()" class="fa fa-trash-o tobebig" aria-hidden="true" data-element="Delete"></i>
			</div>
		</div>
		<div class="mbc-head">
			<div class="linksBucket">
				<i class="fa fa-archive" aria-hidden="true"></i>
				<input type="text" placeholder="Bucket_Name" id="currentBucket" />
			</div>
		</div>
		<div class="treeContainer">
			<ul class="tree">
				<li>
					<div class="datacapsule">
						<i class="fa fa-database" aria-hidden="true"></i>
						<div id="statusRoot">root-data</div>
					</div>
					<ul id="dataContainerTree"></ul>
				</li>
			</ul>
		</div>
	</section>
	<!--Popups-->
	<section id="popupsContainer">
		<!--Confirm Delete1-->
		<div id="confirmDeletes">
			<div class="topBox">
				<h3>Confirm Delete?</h3>
			</div>
			<div class="bodyBox">
				<p>Are you sure you want to delete this bucket? It'll permanently delete all tags and sub+buckets from the database.</p>
				<div class="buttonHolder">
					<button onclick="hideErrorBox()">Cancel</button>
					<button onclick="removeBucket()">Delete</button>
				</div>
			</div>
		</div>
		<!--Confirm Delete2-->
		<div id="confirmDeletes2">
			<div class="topBox">
				<h3>Confirm Delete?</h3>
			</div>
			<div class="bodyBox">
				<p>Are you sure you want to delete this tag? It'll permanently delete this  from the database.</p>
				<div class="buttonHolder">
					<button onclick="hideErrorBox()">Cancel</button>
					<button onclick="clearTag()">Delete</button>
				</div>
			</div>
		</div>
		<!--ErrorBOX-->
		<div id="errorOccured">
			<div class="topBox">
				<h3>Error Occured</h3>
			</div>
			<div class="bodyBox">
				<p>Detailed message about the error</p>
				<div class="buttonHolder">
					<button onclick="hideErrorBox()">OK</button>
				</div>
			</div>
		</div>
		<!--progressbox-->
		<div id="progressBox">
			<img src="assets/loadcat.gif">
			<h3>Syncing Data</h3>
			<p>please wait</p>
		</div>
		<!--Form-->
		<div id="storeData">
			<div class="headMM">
				<div>
					<h2>Store Data</h2>
				</div>
				<img src="assets/loadcat.gif">
			</div>
			<h4>Bucket</h4>
			<input type="text" placeholder="e.g: bucket1" id="bname"/>
			<h4>Tag</h4>
			<input type="text" placeholder="e.g: tag1" id="btag"/>
			<h4>Value<i class="fa fa-info-circle" aria-hidden="true" data-element="Currently multiline is not supported" ></i></h4>
			<textarea id="bvalue" placeholder="e.g: This is a smaple value"></textarea>
			<ul>
				<li onclick="dismissForm2()">Cancel</li>
				<li onclick="storeData()">Submit</li>
			</ul>
		</div>
	</section>
	<!--Footer-->
	<footer>
		<p>xTinyDB &copy; <?php echo date("Y", time()) ?> - A Micro Database Solutions By <a href="https://cttricks.com" target="_blank" title="Ct tricks">Cttricks</a></p>
		<p style="text-align: right; margin-right: 35px">Icons by <a href="https://www.freepik.com" title="Freepik" target="_blank">Freepik</a></p>
		<input type="text" value="" id="copyinput"/>
	</footer>
	<script type="text/javascript" src="assets/app.js"></script>
</body>
</html>
