<!DOCTYPE html>
<html>
<head>
  <title>Digi-Stickers | (404)</title>
  <script src="//use.typekit.net/vbr8xjq.js"></script>
  <script>try{Typekit.load();}catch(e){}</script>
  <style type="text/css">
    body {
      background-color: white;
      margin: 0px;
      padding: 0px;
      font-family: "Proxima Nova", Helvetica, sans-serif;
    }
    h1 {
      font-size: 40px;
      color: #4b4b4b;
      font-weight: bold;
      text-align: center;
      margin-top: 0;
      margin-bottom: 0;
    }

    .sub-copy a {
      color: #474747;
      border-bottom: 1px dotted #474747;
      text-decoration: none;
    }

    .sub-copy {
      padding-top: 15px;
      font-size: 24px;
      font-weight: normal;
      color: #3686be;
      line-height: 1.5;
      max-width: 800px;
      margin: 0 auto;
      text-align: center;
    }

    .sammy {
      display: block;
      margin: 0 auto;
      max-width: 100%;
      position: relative;
      left: -50px;
    }

    .header {
      background: #3686be;
      padding: 40px;
    }

    .header a {
      margin: 0 auto;
      display: block;
    }

    .header img {
      margin: 0 auto;
      display: block;
      width:12%;
    }

    @keyframes wave-animation{
      0%{background-position:0 top};
      100%{background-position:100px top};
    }

    @-moz-keyframes wave-animation {
      0%{background-position:0 top};
      100%{background-position:100px top};
    }

    @-webkit-keyframes wave-animation {
      0%{background-position:0 top};
      100%{background-position:100px top};
    }

    @keyframes loading-animation{
      0%{background-size:100px 0px};
      100%{background-size:100px 100px};
    }

    @-moz-keyframes loading-animation {
      0%{background-size:100px 0px};
      100%{background-size:100px 100px};
    }

    @-webkit-keyframes loading-animation {
      0%{background-size:100px 0px};
      100%{background-size:100px 100px};
    }

    .waves {
      width: 100%;
      height: 100px;
      background-image:url("/img/wave.png");
      animation: wave-animation 2s infinite linear, loading-animation 5s infinite linear alternate;
      -webkit-animation: wave-animation 2s infinite linear, loading-animation 5s infinite linear alternate;
      background-size:100px 100px;
      background-repeat:repeat-x;
      opacity:1;
    }
  </style>
</head>

<body>
  <div class="header">
   <?php echo $this->Html->link($this->Html->image('logo.png',array('width')),array('controller'=>'Users'),array('escape'=>false));?> 

  </div>
  <div class="waves"></div>
  <div class="oops-copy">
    <h1>Oh no! Sammy ate the page you were looking for.</h1>
    <p class="sub-copy"> Head back to <?php echo $this->Html->link('Home',$this->request->referer());?>.</p>
  </div>
  <?php echo $this->Html->image('sammy-404.gif',array('class'=>'sammy'))?>
</body>
</html>
