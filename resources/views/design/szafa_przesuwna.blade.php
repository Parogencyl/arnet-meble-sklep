@extends('layouts.nav')

@section('style')
<link rel="stylesheet" href="{{ asset('css/order.css') }}">
<style>
    #drawing {
        width: 100%;
        height: 100%;
    }

    form {
        width: calc(100% - 600px);
    }
</style>
@endsection

@section('content')
@yield('style')
<h1 class="text-center mb-sm-5 mb-3 mt-sm-4 mt-0 font-weight-bold text-uppercase"> projektowanie </h1>


<div id="drawing" class="row">
    <canvas id="myCanvas" class="col" style="border:1px solid #c3c3c3;"> </canvas>
    <form class="col">
        Szerokość:<input id="x1" type="range" value="150" min="0" max="350">
        <br>
        Długośc:<input id="x2" type="range" value="20" min="0" max="50">
        <br>
        Wysokośc: <input id="y" type="range" value="50" min="0" max="200">
    </form>
</div>



<script>
    var canvas = document.getElementById("myCanvas");
    var ctx = canvas.getContext("2d");
    canvas.setAttribute('width', '600px');
    canvas.setAttribute('height', '400px');
    ctx.fillStyle = "#999";

    var x1 = document.querySelector('#x1');
var x2 = document.querySelector('#x2');
var y = document.querySelector('#y');
var color = document.querySelector('#color');

function draw(){
  // clear the canvas
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  
  // Wobble the cube using a sine wave
  var wobble = Math.sin(Date.now()/250)*window.innerHeight/50;
   /* Animacja /\ */


  // draw the cube
  drawCube(
    document.getElementById('myCanvas').offsetWidth/2 + x1.value/2,
    document.getElementById('myCanvas').offsetHeight/2 + y.value/2 +50,
    Number(x1.value),
    Number(x2.value),
    Number(y.value),
  );

    requestAnimationFrame(draw);

}
draw();

// Draw a cube to the specified specs
function drawCube(x, y, szerokosc, dlugosc, wysokosc) {
    ctx.beginPath();
    ctx.moveTo(x, y);
    ctx.lineTo(x - szerokosc, y - szerokosc * 0.5);
    ctx.lineTo(x - szerokosc, y - wysokosc - szerokosc * 0.5);
    ctx.lineTo(x, y - wysokosc * 1);
    ctx.closePath();
    ctx.stroke();
    ctx.fill();

    ctx.beginPath();
    ctx.moveTo(x, y);
    ctx.lineTo(x + dlugosc, y - dlugosc * 0.5);
    ctx.lineTo(x + dlugosc, y - wysokosc - dlugosc * 0.5);
    ctx.lineTo(x, y - wysokosc * 1);
    ctx.closePath();
    ctx.stroke();
    ctx.fill();

    ctx.beginPath();
    ctx.moveTo(x, y - wysokosc);
    ctx.lineTo(x - szerokosc, y - wysokosc - szerokosc * 0.5);
    ctx.lineTo(x - szerokosc + dlugosc, y - wysokosc - (szerokosc * 0.5 + dlugosc * 0.5));
    ctx.lineTo(x + dlugosc, y - wysokosc - dlugosc * 0.5);
    ctx.closePath();
    ctx.stroke();
    ctx.fill();
}


</script>

@endsection