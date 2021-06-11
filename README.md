# xTinyDB
The xTinyDB is an experimental database service that communicates with a Web service to store and retrieve information. This micro document-based no-SQL database is inspired by the TinyWebDB component of MIT Appinventor. I have made many changes to CRUD data easily with a little bit of security and more features. 

Although this service as an extension is usable, it is very limited and meant primarily as a demonstration for people who would like to create their cloud database that talks to the Web. In this we have methods to store a value under a tag, retrieve the value associated with the tag and delete/clear tags and values from the server. The interpretation of what “store” and “retrieve” means is up to the Web service.

## What's new?
- Multiple values associated with the tags can be stored/updated in a bucket at a time..
- Can call the entire bucket which returns a list of Tags, Values of those tags and Sub Buckets.
- One or more required tags can be called from a particular bucket at a time.
- One or more tags can be removed/cleared from the bucket.
- Entire bucket can be remove/cleared from the server

## How to host xTinyDB?
We have GUI and Vendor files to host on the server. Let's first set up the vendor/xTinyDB database on our server. Also, note that you don't have to rename any of these four files.
- Step1 - Download the four files available in the vendor folder of this git repository. (storeValue.php, getValue.php, clearValue.php, dbInfo.php).
- Step2 - Open dbInfo.php file using any editor ( you can even use notepad ) and change 'storage' & 'accessKey'  Here, storage is the secured path to DB files.  AccessKey is the
key to make secure calls from the client side.
- Step3 - On your cPanel, go to the public directory and create a directory/folder 'xTinyDB'. Now create another dir/folder and name it anything you like to name your first database. And upload all these four files here. Note that 

Create an index.php file (5th file). Only if the direct access to dir 'xTinyDB' is public.

### Now let's host xTinyDB GUI
Click here to download the zip files of xTinyDB GUI or download files of the GIU section of this git repository. Upload it to the 'xTinyDB' directory that we created earlier. Done, now simply open xTinyDB 'index.php' in new tab. (Example: https://yourdomain.com/xTinyDB/)

## Important Links
- Extension for appinventor and distributions.
- Tutorial Video On YouTube
- Demo Dashboard

Note that, I made this just for the experiment. It is not a complete database solution. But yeah! Anyone can use this in their small project or say test projects at their own risk. Also, if you want to do any modification in codes of server or client-side GUI. Feel free to do it and give your contribution to make it more stable and useful. And if you have any queries, feel free to contact me on Twitter or Instagram.

Enjoy…!!
