<?php
?>
<!-- <h1 align="center">TE IT-B</h1> -->
<!-- <h2 align="center">mini Project</h2> -->
<!-- <h3 align="center">Group members</h3> -->
<!-- <p style="width:25%;float:left;">Swastik Sonkusare - 16101B0051</p> -->
<!-- <p style="width:25%;float:left;">Mohit Singhvi - 16101B0056</p> -->
<!-- <p style="width:25%;float:left;">Kedar Atkar - 16101B0063</p> -->
<!-- <a href="home.php" align="center" >home</a> -->








<!doctype html>
<!-- This tells everyone that this is an AMP file. `<html amp>` works too. -->
<html ⚡>
<!-- ## Head -->
<!-- -->
<head>
  <!-- The charset definition must be the first child of the `<head>` tag. -->
  <meta charset="utf-8">
  <title> Hello World</title>
  <!-- The AMP runtime must be loaded as the second child of the `<head>` tag.-->
  <script async src="https://cdn.ampproject.org/v0.js"></script>
  <!--
    AMP HTML files require a canonical link pointing to the regular HTML. If no HTML version exists, it should point to itself.
  -->
  <link rel="canonical" href="">
  <!--
    AMP HTML files require a viewport declaration. It's recommended to include initial-scale=1.
  -->
  <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
  <!--
    CSS must be embedded inline.
  -->
  <style amp-custom>
    h1 {
      color: red;
      text-align: center;
    }
  </style>
  <!--
    The AMP boilerplate.
  -->
  <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
</head>
<!-- ## Body -->
<!-- -->
<body>
  <!--
    Most HTML tags can be used directly in AMP HTML.
  -->
  <h1>About Us</h1>
  <!--
    Certain tags, such as the `<img>` tag, are replaced with equivalent or slightly enhanced custom AMP HTML tags (see [HTML Tags in the specification](https://github.com/ampproject/amphtml/blob/master/spec/amp-html-format.md)). You can use the [AMP Validator](/documentation/guides-and-tutorials/learn/validation-workflow/validate_amp) to check
    if your AMP HTML file is valid AMP HTML. Simply add `#development=1` to an AMP URL. Validation errors will be printed in the Javascript console. You can try it with this website which is built with AMP.

    Check out the [other examples](/documentation/examples/) to learn more about AMP.
  -->


  <!-- <img src="https://preview.amp.dev/static/samples/img/amp.jpg" width="1080" height="610" layout="responsive" ><img> -->
  <!-- <amp-img src="https://preview.amp.dev/static/samples/img/amp.jpg" width="10800" height="6100" layout="responsive"></amp-img> -->


  <amp-list height="24"
  layout="fixed-height"
  src="product.json"
  binding="no"
  class="m1">
  <template type="amp-mustache">
    {{name}}: ${{price}}
  </template>
</amp-list>


</body>
</html>
