<?php

	include 'PostObject.php';

	# call to function which creats the html header with whatever title is passed
	$page = post::getHeader("Main Page");

	# setting the body of the html
	$page .= <<<BODY
			<body>
				<form><br><br>
	    			<h1 class="display-3 text-center"> Application System </h1><br><br>
	    			<div class="container">
	    				<div class = "row m-0">
	    					<div class ="col-xs-4 col-md-3" id="left section">
	    					This is where I imagine the create post section would go.
	                		</div>
	                		<div class ="col-xs-4 col-md-6" id="middle section">
	                		<div class="panel panel-default" id="first" onmouseenter="expandPost(this)" onmouseleave="collapsePost(this)">
	    					<table frame="box" width="500">
								<tr><th> This is the title of the post</th></tr>
								<tr><td> This is the decription of the post. This part shoule be a little longer.</td></tr>
								<tr><td>Votes: 5 </td></tr>
							</table><br>
							</div>
							<table width="500" border="1">
								<tr><th> This is the title of the post</th></tr>
								<tr><td> This is the decription of the post. This part shoule be a little longer than the first one.</td></tr>
								<tr><td> &nbsp;&nbsp;&nbsp;&nbsp; vote up </td></tr>
								<tr><td><strong>Comments</td></tr>
								<tr><td>&nbsp; This is the first comment.</td></tr>
								<tr></tr>
								<tr><td>&nbsp; This is the second comment.</td></tr>
							</table>
	                		</div>
	                		<div class ="col-xs-4 col-md-3" id="right section">
	    					This is where I imagine the sorting of the posts would go.
	                		</div>
	                	</div>
	                </div>
	            </form>
	        </body>
	        <script>
	        	"use strict";
	        	main()

	        	function main(){
	        		document.getElementById("left section").addEventListener("click",setMiddleText);
	        	}

	        	function setMiddleText(){
	        		let mid = document.getElementById("middle section");
	        	}

	        	function makeAlert(){
	        		alert("it was clicked");
	        	}

	        	function expandPost(X){

	        		X.innerHTML = "<table frame=\"box\" width=\"500\"><tr><th> This is the title of the post</th></tr><tr><td> This is the decription of the post. This part should be a little longer.</td></tr><tr><td><tr><td><strong>Comments</td></tr><tr><td>&nbsp; Writer1: This is the first comment.</td></tr><tr></tr><tr><td>&nbsp; Writer:2 This is the second comment.</td></tr><tr><td><textarea rows=\"4\" cols=\"65\"></textarea><br><input type=\"submit\" value=\"Enter Comment\"></td></tr></table>";
	        	}

	        	function collapsePost(X){
	        		X.innerHTML = "<table frame=\"box\" width=\"500\"><tr><th> This is the title of the post</th></tr><tr><td> This is the decription of the post. This part shoule be a little longer.</td></tr><tr><td>Votes: 5 </td></tr></table><br>";
	        	}

	        </script>
	    </html>
			
BODY;

	echo $page;

?>