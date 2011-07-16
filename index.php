<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	<title>Da Capo</title>
	<link rel="icon" type="image/png" href="favicon.png" />
	<link rel="stylesheet" href="style.css" />
	<script src="jquery-1.6.1.min.js"></script>
	<script type="text/javascript">
	var timer = false;
	var currentString = 0;
	var currentLetter = 0;
	var audioDiv = document.createElement('audio');
	
	// preload
	var img1 = new Image();
	img1.src = 'images/cafet.png';
	var img1 = new Image();
	img1.src = 'images/outside.png';
	var img2 = new Image();
	img2.src = 'images/nemu.png';
	var img3 = new Image();
	img3.src = 'images/nemu_facepalm.png';
	var img4 = new Image();
	img4.src = 'images/nemu_laugh.png';
	// end preload
	
	var textes = new Array();
	
	function next_letter()
	{
		$('#text').html($('#text').html() + textes[currentString].text[currentLetter]);
		currentLetter++;
		
		if(currentLetter < textes[currentString].text.length)
		{
			timer = setTimeout('next_letter()', 60);
		}
		else
		{
			currentString++;
			currentLetter = 0;
			timer = false;
		}
	}
	
	function check_data()
	{
		if(typeof textes[currentString].personnage != 'undefined')
		{
			if(textes[currentString].personnage == '')
				$('#personnage').hide();
			else
			{
				$('#personnage img').attr('src', textes[currentString].personnage);
				$('#personnage').show();
			}
		}
		if(typeof textes[currentString].background != 'undefined')
		{
			$('#game').css('backgroundImage', textes[currentString].background);
		}
		if(typeof textes[currentString].music != 'undefined')
		{
			audioDiv.autoplay = 'autoplay';
			audioDiv.src = textes[currentString].music;
		}
	}
	
	$(document).ready(function() {
		$.ajax({
			url: 'arcs/1.json',
			dataType: 'json',
			success: function(donnees) {
				textes = donnees;
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert(textStatus + ": " + errorThrown);
			}
		});
		
		$('#start').click(function() {
			$('#menu').hide();
			$('#game').show();
			
			check_data();
			
			timer = setTimeout('next_letter()', 60);
		});
		
		$('#load, #config, #scenario, #music, #cg').click(function() {
			alert('no implemented');
		});
		
		$('#extra').hover(function() {
			$('.button-extra').show();
		}, function() {
			$('.button-extra').hide();
		});
		
		$('#quit').click(function() {
			alert('Want to quit this webpage ? close it yourself.');
		});
		
		$('#game').click(function() {
			if(currentString < textes.length)
			{
				if(timer == false)
				{
					check_data();
					
					$('#text').html('');
					$('#name').html(textes[currentString].name);
					timer = setTimeout('next_letter()', 100);
				}
				else
				{
					clearTimeout(timer);
					$('#text').html(textes[currentString].text);
					currentString++;
					currentLetter = 0;
					timer = false;
				}
			}
			else
			{
				audioDiv.pause();
				currentString = 0;
				currentLetter = 0;
				$('#game').hide();
				$('#menu').show();
				$('#text').html('');
			}
		});
	});
	</script>
</head>
<body>
	<div id="menu">
		<div id="start" class="button"></div>
		<div id="load" class="button"></div>
		<div id="extra" class="button">
			<div id="scenario" class="button-extra"></div>
			<div id="cg" class="button-extra"></div>
			<div id="music" class="button-extra"></div>
		</div>
		<div id="config" class="button"></div>
		<div id="quit" class="button"></div>
	</div>
		
	<div id="game">
		<div id="personnage">
			<img src="" alt="" />
		</div>
		<div id="textbox">
			<div id="tb-img"></div>
			<div id="name">Nemu</div>
			<div id="text"></div>
		</div>
	</div>
	<p style="text-align: center"><em>Da Capo</em>, a game by <strong>Circus</strong><br />
	<a style="color:blue;text-decoration:none" href="http://www.mangagamer.com/r18/Titles/Details/B12AEB7E-B6E4-46CF-B5D6-B6B01AA4AC65/da-capo">Try the official english demo by <strong>MangaGamer</strong></a></p>
</body>
</html>
