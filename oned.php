<?php

if (isset($_GET['3141592654'])) die(highlight_file(__FILE__, 1));

function getPageJS($canvas, $width, $height)
{
	$output = '';

	$output .= '<script src="surface.js"></script>';

	$output .= '<script>';

	$output .= "var canvas = '$canvas';";
	$output .= "var width = '$width';";
	$output .= "var height = '$height';";

	$output .= <<< 'EOD'

function randomValue()
{
	if(Math.random() > 0.5)
	{
		return true;
	}
	else
	{
		return false;
	}
}

var buffer;
var y;
var rules;

function automataInit()
{
	buffer = new Array(2);
	buffer[0] = new Array(width);
	buffer[1] = new Array(width);

	rules = [[[randomValue(), randomValue()], [randomValue(), randomValue()]], [[randomValue(), randomValue()], [randomValue(), randomValue()]]];

	for(var x = 1; x < (width / 2); x++) buffer[0][x] = buffer[0][width - x - 1] = randomValue();

	y = 0;
}

function automataLoop()
{
	if(y < height)
	{
		for(var x = 1; x < width - 2; x++)
		{
			buffer[1][x] = rules[buffer[0][x - 1]?0:1][buffer[0][x]?0:1][buffer[0][x + 1]?0:1];
			Surface.plot(x, y, (buffer[1][x]?'0xFFFFFF':'0x000000'));
		}

		for(var x = 1; x < width - 1; x++)
		{
			buffer[0][x] = buffer[1][x];
		}

		y++;
	}

	Surface.render();
}

function main(canvas, width, height, mainFunc, loopFunc)
{
	var canvasContext = document.getElementById(canvas);

	Surface.init(canvasContext, width, height);

	mainFunc();

	Surface.loop(loopFunc, 60);
}

main(canvas, width, height, automataInit, automataLoop);

EOD;
	$output .= '</script>';

	return $output;
}

function getPageHTML($canvas, $width, $height)
{
	$output = '';

	$output .= '<!DOCTYPE html>';
	$output .= '<html>';

		$output .= '<head>';

		$output .= '</head>';

		$output .= '<body>';

		$output .= '<canvas id="'.$canvas.'" width="'.$width.'" height="'.$height.'">';
		$output .= 'herp derp nice browser';
		$output .= '</canvas>';

		$output .= getPageJS($canvas, $width, $height);

		$output .= '</body>';

	$output .= '</html>';

	return $output;
}

$output = '';

$output .= getPageHTML('canvas', 320, 200);

echo $output;

?>
