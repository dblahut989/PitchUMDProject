<?php

	class post{
			
		private $user;
		private $topic;
		private $comments;
		private $votes;
		private $description;
		private $title;
		private $date;
		private $id_num;
			
		# the course name, section number, array of students and grades, and student count are initialized
		public function __construct(string $creator, string $topic, string $desc, string $title, string $date, int $votes, string $comments, int $id){
			
			$this->user = $creator;
			$this->topic = $topic;
			//comments is a string with all the comments delimmetd by "|"
			$this->comments = $comments;
			$this->description = $desc;
			$this->title = $title;
			$this->date = $date;
			$this->votes = $votes;
			$this->id_num = $id;
		}

		public function get_user(){
			return $this->user;
		}
		
		# this function adds a student to the roster with a grade of "N/A" since their grade has not been sent
		public function addComment($comment, $commenter){
			
			$this->comments[] = $commenter.": ".$comment;
			
		}
		
		# this function returns the roster of students
		public function incrementVote(){
			return $this->votes++;
		}

		public function getPostHTML($currentUser){
			$title = $this->title;
			$desc = $this->description;
			$v = $this->votes;
			$comm = $this->comments;
			$id = $this->id_num;
			$user = $this->user;

			$code = <<<BODY
				<div class="rounding">
					<form action="MainPage.php" method="post">
						<h1 class="display-5 text-center">$title</h1><div class="text-center"> by $user</div><br>
						$desc<br><br>
						Votes: $v
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="Voting" value="Vote This Idea Up"><br>
						<input type="hidden" name="ID" value=$id>
						<input type="hidden" name="Comments" value=$comm>
						<input type="hidden" name="NumVotes" value=$v>

BODY;
			if ($currentUser === $this->user){
				$code .= <<<BODY
					<input type="submit" name="EditPost" value="Edit Post">
BODY;
			} 

			$code .= "<br><br>Comments:<br>";
			if ($comm != ""){
				$comArray = explode("|",$comm);
				foreach ($comArray as $comment){
					$splitUp = explode(":",$comment);
					$commenter = $splitUp[0];
					$message = $splitUp[1];
					$code .= "<div class=\"rounding\"<em>$commenter</em>: $message</td></tr></div>";
			}

			}
			
			$code .= <<<BODY

			</table><br>
			<textarea rows="4" cols="68" name="NewComment"></textarea>
			<input type="submit" name="SubmitComment" value="Submit Comment">
			</form><br>
			</div>
BODY;

			return $code;

		}

		# this function creates the header section of the html which will be displayed
		public static function getHeader($title){
			$head = <<<TOPPAGE
				<!doctype html>
				<html>
					<head> 
						<meta charset="utf-8" />
						<meta name="viewport" content="width=device-width, initial-scale=1.0" />
						<title>$title</title>	
						<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
						<style>
							.rounding{
								border-radius: 10px;
	  							/*background: #f88;*/
	  							border-style: groove;
							}
						</style>
						
					</head>
TOPPAGE;
			return $head;

		}
		
	}
?>