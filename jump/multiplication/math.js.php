<?php
	// default GET values
	if( !array_key_exists('num', $_GET) )
		$_GET['num'] = '1..12';
	if( !array_key_exists('lim', $_GET) )
		$_GET['lim'] = 12;
	if( !array_key_exists('liv', $_GET) )
		$_GET['liv'] = 3;
	
	// parse GET fields
	
	$js_num = null;
	{	$nums = []; // array of numbers to be converted to a string containing a js array, e.g. '[1,2,3]'
		$arr = explode(',', $_GET['num']);
		foreach( $arr as $ele ) {
			$arr = explode('..', $ele, 2);
			if( count($arr) <= 1 ) {
				array_push( $nums, intval($ele) );
			} else {
				$min = intval($arr[0]);
				$max = intval($arr[1]);
				for( $i = $min; $i <= $max; $i++ ) {
					array_push($nums, $i);
				}
			}
		}
		$js_num = '[' . implode(',', $nums) . ']';
	}
	$js_lim = intval($_GET['lim']);
	$js_liv = intval($_GET['liv']);
?>

var NUMBER = <?php echo $js_num; ?>;
var LIMIT = <?php echo $js_lim; ?>;
var LIVES = <?php echo $js_liv; ?>;

var DEFAULT_COLOR = "#444444";
var GOOD_COLOR = "#44CC44";
var ERROR_COLOR = "#CC4444";

document.addEventListener("DOMContentLoaded", function() {

	var question_ele = document.getElementById("question");
	var multiplicand_ele = document.getElementById("multiplicand");
	var multiplier_ele = document.getElementById("multiplier");
	var product_ele = document.getElementById("product");
	var score_ele = document.getElementById("score");
	var lives_ele = document.getElementById("lives");
	var high_score_ele = document.getElementById("high_score");

	if( question_ele && multiplicand_ele && multiplier_ele && product_ele ) {
		
		score_ele.value = "0";
		lives_ele.value = "" + LIVES;
		high_score.value = "0";

		score_ele.style.backgroundColor = DEFAULT_COLOR;
		lives_ele.style.backgroundColor = DEFAULT_COLOR;
		high_score_ele.style.backgroundColor = DEFAULT_COLOR;

		var Question = function() {
			var n = Array.isArray(NUMBER) ? NUMBER[Math.floor(NUMBER.length * Math.random())] : NUMBER;
			if( Math.random() < 0.5 ) {
				this.multiplicand = n;
				this.multiplier = Math.floor( LIMIT * Math.random() + 1 );
			} else {
				this.multiplicand = Math.floor( LIMIT * Math.random() + 1 );
				this.multiplier = n;
			}
			this.product = this.multiplicand * this.multiplier;
			multiplicand_ele.value = "" + this.multiplicand;
			multiplier_ele.value = "" + this.multiplier;
		};
		var question = new Question();

		question_ele.addEventListener("submit", function(event) {
			event.preventDefault();
			
			score_ele.style.backgroundColor = DEFAULT_COLOR;
			lives_ele.style.backgroundColor = DEFAULT_COLOR;
			high_score_ele.style.backgroundColor = DEFAULT_COLOR;

			if( product_ele.value.trim() == "" )
				return false;

			if( Number.parseInt(product_ele.value) == question.product ) {
				var score = Number.parseInt(score_ele.value) + 1;
				score_ele.value = "" + score;
				score_ele.style.backgroundColor = GOOD_COLOR;
				if( Number.parseInt(high_score_ele.value) < score ) {
					high_score_ele.value = "" + score;
					high_score_ele.style.backgroundColor = GOOD_COLOR;
				}
				if( score % 10 == 0 ) {
					lives_ele.value = "" + (Number.parseInt(lives_ele.value) + 1);
					lives_ele.style.backgroundColor = GOOD_COLOR;
				}
				question = new Question();
			} else {
				lives_ele.value = "" + (Number.parseInt(lives_ele.value) - 1);
				lives_ele.style.backgroundColor = ERROR_COLOR;
				if( lives_ele.value == "0" ) {
					// game over. restart
					score_ele.value = "0";
					lives_ele.value = "" + LIVES;
					
					score_ele.style.backgroundColor = DEFAULT_COLOR;
					lives_ele.style.backgroundColor = DEFAULT_COLOR;
					high_score_ele.style.backgroundColor = DEFAULT_COLOR;
				} else {
					question = new Question();
				}
			}
			product_ele.value = "";
			return false;
		});
	}

});