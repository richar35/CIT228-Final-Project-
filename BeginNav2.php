<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>Bootstrap Theme The Band</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link href="css/finalProject.css" rel="stylesheet" />

</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#myPage">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#myPage">Add a Race</a></li>
        <li><a href='BeginNav.php'>Change a Race</a></li>
        <li><a href="#tour">Delete a Race</a></li>
        <li><a href="#contact">Create XML Race List</a></li>
        <li><a href="#contact">Create Json Race List</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Container (Contact Section) -->
<div id="contact" class="container">
  <h3 class="text-center">Post Your Question or Topic Below</h3>
  <p class="text-center"><em>We love Running!</em></p>

  <div class="row">
    <div class="col-md-4">
      <p>Questions or Concerns</p>
      <p><span class="glyphicon glyphicon-map-marker"></span>Chicago, US</p>
      <p><span class="glyphicon glyphicon-phone"></span>Phone: +00 1515151515</p>
      <p><span class="glyphicon glyphicon-envelope"></span>Email: mail@mail.com</p>
    </div>
    <form method="post" action="do_addtopic.php">
    <div class="col-md-8">
      <div class="row">
        <div class="col-sm-6 form-group">
            <form method="post" action="do_addtopic.php">

                <p><label for="topic_owner">Your Email Address:</label><br/>
                <input type="email" id="topic_owner" name="topic_owner" size="40"
                        maxlength="150" required="required" /></p>
                
                <p><label for="topic_title">Topic Title:</label><br/>
                <input type="text" id="topic_title" name="topic_title" size="40"
                        maxlength="150" required="required" /></p>
                
                <p><label for="post_text">Post Text:</label><br/>
                <textarea id="post_text" name="post_text" rows="8"
                          cols="40" ></textarea></p>
                
                <button type="submit" name="submit" value="submit">Add Topic</button>
                <input type="button" name="menu" id="menu" value="Return to Menu" onclick="location.href='discussionMenu.html'">
                </form>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  <br>


<!-- Footer -->
<footer class="text-center">
  <a class="up-arrow" href="#myPage" data-toggle="tooltip" title="TO TOP">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a><br><br>
</footer>

<script>
$(document).ready(function(){
  // Initialize Tooltip
  $('[data-toggle="tooltip"]').tooltip(); 
  
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {

      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
})
</script>

</body>
</html>
