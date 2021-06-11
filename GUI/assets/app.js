/*Normal Switches*/
function classModifier(className, data) {
	var cols = document.getElementsByClassName(className);
	for (i = 0; i < cols.length; i++) {
		cols[i].style.display = data;
	}
}

function modifyEnd(status) {
	var tc = document.getElementsByClassName("tagContainer");
	var target = tc[tc.length - 1];
	if (target !== undefined) {
		if (status) {
			target.classList.add('rmvExtra');
		} else {
			target.classList.remove('rmvExtra');
		}
	}
}

var isTagVisible = true;

function viewHideTags() {
	var btn = document.getElementsByClassName("button")[0].childNodes[3];
	if (isTagVisible) {
		isTagVisible = false;
		btn.setAttribute("data-element", "Show Tags");
		document.getElementsByClassName("tobebigbtn")[0].style.color = "#333";
		return classModifier("tagContainer", "none");
	}

	isTagVisible = true;
	btn.setAttribute("data-element", "Hide Tags");
	document.getElementsByClassName("tobebigbtn")[0].style.color = "#00c875";
	return classModifier("tagContainer", "block");
}

var isBucketVisible = true;

function viewHideBucket() {
	var btn = document.getElementsByClassName("button")[0].childNodes[5];
	if (isBucketVisible) {
		isBucketVisible = false;
		btn.setAttribute("data-element", "Show Sub-Buckets");
		document.getElementsByClassName("tobebigbtn")[1].style.color = "#333";
		modifyEnd(true);
		return classModifier("bucketContainer", "none");
	}

	isBucketVisible = true;
	btn.setAttribute("data-element", "Hide Sub-Buckets");
	document.getElementsByClassName("tobebigbtn")[1].style.color = "#00c875";
	modifyEnd(false);
	return classModifier("bucketContainer", "block");
}

function showProgree() {
	document.getElementById("popupsContainer").style.display = "grid";
	document.getElementById("progressBox").style.display = "block";
}

function hideProgree() {
	document.getElementById("popupsContainer").style.display = "none";
	document.getElementById("progressBox").style.display = "none";
}


/*db functions*/
function storeForm(tag, value) {
	value = ((value == undefined) ? "" : value);
	if (tag == undefined) {
		tag = "";
		document.getElementById("btag").disabled = false;
		document.getElementById("bname").disabled = false;
	} else {
		document.getElementById("btag").disabled = true;
		document.getElementById("bname").disabled = true;
	}
	/*assign Values*/
	document.getElementById("bname").value = document.getElementById("currentBucket").value;
	document.getElementById("btag").value = tag;
	document.getElementById("bvalue").value = value;
	/*view form*/
	document.getElementById("popupsContainer").style.display = "grid";
	document.getElementById("confirmDeletes2").style.display = "none";
	document.getElementById("storeData").style.display = "block";
}

function dismissForm() {
	document.getElementById("popupsContainer").style.display = "grid";
	document.getElementById("storeData").style.display = "none";
	document.getElementById("confirmDeletes2").style.display = "none";
	document.getElementById("progressBox").style.display = "block";
}

function dismissForm2() {
	document.getElementById("popupsContainer").style.display = "none";
	document.getElementById("storeData").style.display = "none";
	document.getElementById("confirmDeletes2").style.display = "none";
	document.getElementById("progressBox").style.display = "none";
}

/*on tag=>value selection*/
document.getElementById("dataContainerTree").addEventListener("click", (e) => {
	var temp = true;
	if (e.target.nodeName == "DIV") {
		temp = false;
		if (e.target.getAttribute("data-type") == "tag") {
			storeForm(e.target.innerHTML, e.target.nextSibling.innerHTML);
		} else if (e.target.getAttribute("data-type") == "bucket") {
			changeBucket(e.target.innerText);
		}
	}
	/*on delete tag click*/
	if (e.target.nodeName == "I" && e.target.classList[1] == "fa-trash-o" && temp) {
		//storeForm(tag.innerHTML, tag.nextSibling.innerHTML);
		document.getElementById("bname").value = document.getElementById("currentBucket").value;
		document.getElementById("btag").value = e.target.nextElementSibling.innerHTML;
		/*showpopup*/
		document.getElementById("popupsContainer").style.display = "grid";
		document.getElementById("confirmDeletes2").style.display = "block";
	}
});

/*simple button actions*/
function hideErrorBox() {
	document.getElementById("popupsContainer").style.display = "none";
	document.getElementById("errorOccured").style.display = "none";
	document.getElementById("confirmDeletes").style.display = "none";
	document.getElementById("currentBucket").value = currentBuket;
	document.getElementById("progressBox").style.display = "none";
}

function hideErrorBox2() {
	document.getElementById("popupsContainer").style.display = "grid";
	document.getElementById("errorOccured").style.display = "none";
	document.getElementById("confirmDeletes").style.display = "none";
	document.getElementById("currentBucket").value = currentBuket;
	document.getElementById("progressBox").style.display = "block";
}

/*show confirm delete*/
function showCDBox() {
	document.getElementById("popupsContainer").style.display = "grid";
	document.getElementById("confirmDeletes").style.display = "block";
}
/*DB operations*/
var currentBuket = "";

function setCurrentBucket(data) {
	document.getElementById("currentBucket").value = data;
	currentBuket = data;
	/*to reset button of hide and show buttons for bucket and tag*/
	isBucketVisible = false;
	isTagVisible = false;
	viewHideBucket();
	viewHideTags();
}

function showProgress() {
	document.getElementById("popupsContainer").style.display = "grid";
	document.getElementById("progressBox").style.display = "block";
}

function hideProgress() {
	document.getElementById("popupsContainer").style.display = "none";
	document.getElementById("progressBox").style.display = "none";
}

/*get data from database to display*/
var bucketContent = {};

function connectDB() {
	var url = document.getElementById("serverurl").value;
	var bucket = document.getElementById("cbucket").value;
	var accessKey = document.getElementById("accesskey").value;
	if(accessKey == ""){
		document.getElementById("popupsContainer").style.display = "grid";
		var tempElm = document.getElementById("errorOccured");
		tempElm.childNodes[3].childNodes[1].innerText = "Enter your access Key";
		tempElm.style.display = "block";
		return;
	}
	
	document.getElementById("statusRoot").innerHTML = "Loading...";
	showProgress();
	/*label url*/
	document.getElementById("serverurllabel").innerHTML = url;
	/*server Request*/
	var url = url + "/get.php?bucket=" + bucket;
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", url, true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.setRequestHeader("Authorization", "Basic " + accessKey);
	xhttp.send();
	xhttp.onreadystatechange = function () {
		if (this.readyState == 4) {
			hideProgress();
			document.getElementById("statusRoot").innerHTML = "root-data";
			var responseData = {"msg" : "Invalid bucket URL"};
			if (this.status == 200) {
				responseData = JSON.parse(this.responseText);
				document.getElementById("dataContainerTree").innerHTML = "";
				responseData["tags"].forEach((e, i) => {
					$("#dataContainerTree").append('<li class="tagContainer"><div class="datacapsule"><i class="fa fa-trash-o" aria-hidden="true"></i><div data-type="tag">' + e + '</div><p>' + responseData["values"][i] + '</p></div></li>');
				});

				responseData["sub_buckets"].forEach((e) => {
					$("#dataContainerTree").append('<li class="bucketContainer"><div class="datacapsule"><i class="fa fa-inbox" aria-hidden="true"></i><div data-type="bucket">' + e + '</div></div></li>');
				});

				bucketContent = {
					"db_name": "xTinyDB",
					"db_version": "1.0.2",
					"data_type": "JSON",
					"content": {
						"bucket": bucket,
						"sub_buckets": responseData["sub_buckets"],
						"tags": responseData["tags"],
						"values": responseData["values"]
					}
				};
				setCurrentBucket(bucket);
				document.getElementById('logintodb').style.display = 'none';
				document.getElementById('mainBodyContainer').style.display = 'block';
			} else {
				document.getElementById("popupsContainer").style.display = "grid";
				var tempElm = document.getElementById("errorOccured");
				tempElm.childNodes[3].childNodes[1].innerText = responseData['msg'];
				tempElm.style.display = "block";
			}
		}
		

	};
}

/*change bucket*/
function changeBucket(data) {
	var newbucket = document.getElementById("currentBucket").value;
	if (newbucket !== "") {
		newbucket += "/";
	}

	newbucket += data;
	document.getElementById("cbucket").value = newbucket;
	connectDB();
}

document.getElementById('currentBucket').onkeypress = function (e) {
	if (!e) e = window.event;
	var keyCode = e.code || e.key;
	if (keyCode == 'Enter') {
		document.getElementById("cbucket").value = document.getElementById('currentBucket').value;
		connectDB();
	}
}

/*store>update data*/
function storeData() {
	dismissForm();
	var bucket = document.getElementById("bname").value;
	var tag = document.getElementById("btag").value;
	var value = document.getElementById("bvalue").value;
	if (bucket !== "" && tag !== "") {
		tag = '["' + tag + '"]';
		value = '["' + value.replace(/\n/g, ' ') + '"]';
		var url = document.getElementById("serverurl").value + "/store.php";
		var xhttp = new XMLHttpRequest();
		xhttp.open("POST", url, true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.setRequestHeader("Authorization", "Basic " + document.getElementById("accesskey").value);
		xhttp.send("bucket=" + bucket + "&tag=" + tag + "&value=" + value);
		console.log(value);
		xhttp.onreadystatechange = function () {
			if (this.readyState == 4) {
				var responseData = JSON.parse(this.responseText);
				hideProgress();
				if (this.status == 200) {
					document.getElementById("cbucket").value = bucket;
					connectDB();
				} else {
					document.getElementById("popupsContainer").style.display = "grid";
					var tempElm = document.getElementById("errorOccured");
					tempElm.childNodes[3].childNodes[1].innerText = responseData['msg'];
					tempElm.style.display = "block";
				}
			}
		};
	}
}

/*short cut keys*/
document.body.onkeypress = function (e) {
	if (!e) e = window.event;
	var keyCode = e.code || e.key;
	if (keyCode == "KeyB" && e.ctrlKey) {
		setepBack();
	}
}

/*got to previous bucket*/
function setepBack() {
	var newbucket = document.getElementById("currentBucket").value;
	var temp = newbucket.split('/');
	newbucket = "";
	if (temp.length > 1) {
		for (var i = 0; i < temp.length - 1; i++) {
			newbucket += ((newbucket == "") ? temp[i] : "/" + temp[i]);
		}
	}

	document.getElementById("cbucket").value = newbucket;
	connectDB();
}

/*copy bucket data*/
function setItBack() {
	var elem = document.getElementsByClassName("fa-clone")[0];
	elem.setAttribute("data-element", "Copy Bucket");
	elem.style.color = "#333";
}

function copyData() {
	var elem = document.getElementsByClassName("fa-clone")[0];
	elem.setAttribute("data-element", "Copied");
	elem.style.color = "#20d827";
	/*action*/
	var copyText = document.getElementById('copyinput');
	copyText.value = JSON.stringify(bucketContent);
	copyText.select();
	copyText.setSelectionRange(0, 99999);
	document.execCommand("copy");
	/*set normal*/
	setTimeout(setItBack, 1500);
}

function clearTag(e) {
	var bucket = document.getElementById("bname").value;
	dismissForm();
	if (bucket == "") {
		return;
	}
	showProgress();
	var tag = document.getElementById("btag").value;
	tag = '["' + tag + '"]';
	var url = document.getElementById("serverurl").value;
	var accessKey = document.getElementById("accesskey").value;

	/*server Request*/
	var url = url + "/clear.php?bucket=" + bucket + "&tag=" + tag;
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", url, true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.setRequestHeader("Authorization", "Basic " + accessKey);
	xhttp.send();
	/*process response*/
	xhttp.onreadystatechange = function () {
		if (this.readyState == 4) {
			var responseData = JSON.parse(this.responseText);
			hideProgress();
			if (this.status == 200) {
				document.getElementById("cbucket").value = bucket;
				connectDB();
			} else {
				document.getElementById("popupsContainer").style.display = "grid";
				var tempElm = document.getElementById("errorOccured");
				tempElm.childNodes[3].childNodes[1].innerText = responseData['msg'];
				tempElm.style.display = "block";
			}
		}
	};
}

function removeBucket() {
	hideErrorBox2();
	var url = document.getElementById("serverurl").value;
	var bucket = document.getElementById("cbucket").value;
	if (bucket == "") {
		return;
	}

	var accessKey = document.getElementById("accesskey").value;
	/*server Request*/
	var url = url + "/clear.php?bucket=" + bucket;
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", url, true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.setRequestHeader("Authorization", "Basic " + accessKey);
	xhttp.send();
	/*process response*/
	xhttp.onreadystatechange = function () {
		if (this.readyState == 4) {
			var responseData = JSON.parse(this.responseText);
			hideProgress();
			if (this.status == 200) {
				setepBack();
			} else {
				document.getElementById("popupsContainer").style.display = "grid";
				var tempElm = document.getElementById("errorOccured");
				tempElm.childNodes[3].childNodes[1].innerText = responseData['msg'];
				tempElm.style.display = "block";
			}
		}
	};
}