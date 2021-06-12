<h1 align="center" style="border: none !important"><img src="https://cttricks.com/xTinyDB/banner12.png"/> xTinyDB<br></h1>
<p align="center">✨ The Open Source TinyWebDB Alternative ✨</p>

<div align="center">
 
![Build Status](https://badgen.net/apm/license/linter)
![Node version](https://badgen.net/packagist/php/monolog/monolog)
[![Twitter](https://img.shields.io/twitter/url.svg?url=https%3A%2F%2Ftwitter.com%2Fct_tricks&style=social&label=Follow%20%40ct_tricks)](https://twitter.com/ct_tricks)

</div>

<p align="center">
    <a href="http://cttricks.com/xTinyDB/"><b>Website</b></a> •
    <a href="https://community.niotron.com/"><b>Community</b></a> • 
    <a href="https://twitter.com/ct_tricks"><b>Twitter</b></a>
</p>  

The xTinyDB is an experimental database service that communicates with a Web service to store and retrieve information. This micro document-based no-SQL database is inspired by the TinyWebDB component of MIT Appinventor. I have made many changes to CRUD data easily with a little bit of security and more features. 

Although this service as an extension is usable, it is very limited and meant primarily as a demonstration for people who would like to create their cloud database that talks to the Web. In this we have methods to store a value under a tag, retrieve the value associated with the tag and delete/clear tags and values from the server. The interpretation of what “store” and “retrieve” means is up to the Web service.

# Features
- ⚡ Multiple values associated with the tags can be stored/updated in a bucket at a time..
- ⚡ Can call the entire bucket which returns a list of Tags, Values of those tags and Sub Buckets.
- ⚡ One or more required tags can be called from a particular bucket at a time.
- ⚡ One or more tags can be removed/cleared from the bucket.
- ⚡ Entire bucket can be remove/cleared from the server

# Production Setup
We have GUI and Vendor files to host on the server. Let's first set up the vendor/xTinyDB database on our server. Also, note that you don't have to rename any of these four files.
- Step1 - Download the four files available in the vendor folder of this git repository. (storeValue.php, getValue.php, clearValue.php, dbInfo.php).
- Step2 - Open dbInfo.php file using any editor ( you can even use notepad ) and change `storage` & `accessKey`  Here, storage is the secured path to DB files.  AccessKey is the
key to make secure calls from the client side.
```php
$xTinyDB = array(
	"storage" => "storage-area"
	"accessKey" => "sampleaccesskey01"
);
```
- Step3 - On your cPanel, go to the public directory and create a directory/folder `xTinyDB`. Now create another dir/folder and name it anything you like to name your first database. And upload all these four files here. Note that 

:warning: Create an index.php file (5th file). Only if the direct access to dir `xTinyDB` is public.

# GUI Setup
![image|690x252](https://cttricks.com/xTinyDB/banner2.png)

Click here to download the zip files of xTinyDB GUI or download files of the GIU section of this git repository. Upload it to the `xTinyDB` directory that we created earlier. 

Done, now simply open xTinyDB `index.php` in new tab. ( Example: https://yourdomain.com/xTinyDB/ )

## Control Buttons On GUI
![image|600x50](https://cttricks.com/xTinyDB/banner3.png)
1. Add a new tag in the current bucket or in a sub bucket of the current bucket.
2. Hide/Show tags and values in UI
3. Hide/Show sub buckets in UI
4. Refresh current bucket
5. Copy JSON of the current bucket
6. Delete/remove/clear the current bucket

![image|300x40](https://cttricks.com/xTinyDB/banner4.png)

Here we have an input field to enter the bucket path to view it. On top of all these, you can also use `ctrl+b` to move back to the previous bucket.

# 🎯  Why i'm building this ?
Most app developers equip themselves with either spreadsheet or a database to solve their cloud-storage needs. Spreadsheet, MySQL DB, Airtable, and Firebase, etc. are used by a +Thousand app developers making apps on MIT Appinventor and its distributions every single day. However, I made this document-based no-SQL database just as an experiment. It is inspired by the TinyWebDB component of appinventor. As very few developers actually use this component. So I took an approach to improve it a bit more and came up with this xTinyDB stuff. It is not a complete database solution. But yeah! Anyone can use this in their small/big projects at their own risk. :smile:


# :pushpin: Important Links
- [Download Extension](https://cttricks.com/xTinyDB/com.cttricks.xTinyDB.aix) for appinventor and distributions.
- Tutorial Video On YouTube
- [Demo Dashboard](https://cttricks.com/xTinyDB)
