<?php
	// default GET values
	if( !array_key_exists('max_q', $_GET) )
		$_GET['max_q'] = '12';
	if( !array_key_exists('div', $_GET) )
		$_GET['div'] = '1..12';
	if( !array_key_exists('liv', $_GET) )
		$_GET['liv'] = '3';
	
	// parse GET fields
	
	$js_div = null;
	{	$divs = []; // array of numbers to be converted to a string containing a js array, e.g. '[1,2,3]'
		$arr = explode(',', $_GET['div']);
		foreach( $arr as $ele ) {
			$arr = explode('..', $ele, 2);
			if( count($arr) <= 1 ) {
				array_push( $divs, intval($ele) );
			} else {
				$min = intval($arr[0]);
				$max = intval($arr[1]);
				for( $i = $min; $i <= $max; $i++ ) {
					array_push($divs, $i);
				}
			}
		}
		$js_div = '[' . implode(',', $divs) . ']';
	}
	$js_max_q = intval($_GET['max_q']);
	$js_liv = intval($_GET['liv']);
?>

var MAX_QUOTIENT = <?php echo $js_max_q; ?>;
var DIVISOR = <?php echo $js_div; ?>;
var LIVES = <?php echo $js_liv; ?>;

var DEFAULT_COLOR = "#444444";
var GOOD_COLOR = "#44CC44";
var ERROR_COLOR = "#CC4444";

document.addEventListener("DOMContentLoaded", function() {

	var question_ele = document.getElementById("question");
	var dividend_ele = document.getElementById("dividend");
	var divisor_ele = document.getElementById("divisor");
	var quotient_ele = document.getElementById("quotient");
	var numerator_ele = document.getElementById("numerator");
	var denominator_ele = document.getElementById("denominator");
	var score_ele = document.getElementById("score");
	var lives_ele = document.getElementById("lives");
	var high_score_ele = document.getElementById("high_score");

	if( question_ele && dividend_ele && divisor_ele && quotient_ele && numerator_ele && denominator_ele ) {
		
		score_ele.value = "0";
		lives_ele.value = "" + LIVES;
		high_score.value = "0";

		score_ele.style.backgroundColor = DEFAULT_COLOR;
		lives_ele.style.backgroundColor = DEFAULT_COLOR;
		high_score_ele.style.backgroundColor = DEFAULT_COLOR;

		var Question = function() {
			this.divisor = Array.isArray(DIVISOR) ? DIVISOR[Math.floor(DIVISOR.length * Math.random())] : DIVISOR;
			this.quotient = Math.floor((MAX_QUOTIENT + 1) * Math.random());
			this.remainder = Math.floor(this.divisor * Math.random());
			this.dividend = this.divisor * this.quotient + this.remainder;
			dividend_ele.value = "" + this.dividend;
			divisor_ele.value = "" + this.divisor;
		};
		var question = new Question();

		question_ele.addEventListener("submit", function(event) {
			event.preventDefault();
			
			score_ele.style.backgroundColor = DEFAULT_COLOR;
			lives_ele.style.backgroundColor = DEFAULT_COLOR;
			high_score_ele.style.backgroundColor = DEFAULT_COLOR;

			quotient_ele.value = quotient_ele.value.trim();
			numerator_ele.value = numerator_ele.value.trim();
			denominator_ele.value = denominator_ele.value.trim();

			if( (quotient_ele.value == "" && (numerator_ele.value == "" || denominator_ele.value == "")) ||
				((numerator_ele.value == "") != (denominator_ele.value == ""))
			) {
				return false;
			}

			if(
				(
					(question.quotient == 0 && quotient_ele.value == "") ||
					(Number.parseInt(quotient_ele.value) == question.quotient)
				) && (
					(question.remainder == 0 && numerator_ele.value == "" && denominator_ele.value == "") ||
					(question.remainder * Number.parseInt(denominator_ele.value) == question.divisor * Number.parseInt(numerator_ele.value))
				)
			) {
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
			quotient_ele.value = "";
			numerator_ele.value = "";
			denominator_ele.value = "";
			return false;
		});
	}

});
