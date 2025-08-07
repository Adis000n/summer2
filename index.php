<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona głowna</title>
    <link rel="icon" href="img/logo.jpg" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Kalam&family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>
    <p1 id="tekst">DO</p1>
    <p1 id="tekst">IT</p1>
    <p1 id="tekst2">NOW!</p1>
    <section id="section07" class="demo">
    <a href="#section08"><span></span><span>
    </span><span></span>Kliknij aby przejść dalej</a>
    </section>
    <section id="section08" class="demo">
    <hr class="new5">
    <h1>O projekcie:</h1>
    <h2>DO IT <strong>NOW</strong> to aplikacja, która pomoga zaplanować czas. Możesz w niej planować wydarzenia takie jak: <strong>sprawdziany, kartkówki, zadania i obowiązki domowe</strong>. Aplikacja jest skierowana głównie do <strong>uczniów</strong>. Możesz również zaplanować kiedy będziesz się uczył na dane wydarzenie. Aplikacja przystosowana jest do użytku na komputerze jak i <strong>na telefonie</strong>. Aplikacja również zbiera <strong>statystyki</strong> z każdego tygodnia, które możesz wyświetlić. </h2>
    <hr class="new5">
    <form action="login.php">  
        <div class="text-center"> <!-- Add a new container to center the button -->
            <button type="submit" method="post">Zaloguj się</button>
        </div>
    </section>
</body>
<style>
strong{
  color: #0071f2;
}

.text-center {
        text-align: center;
    }

    .text-center button {
        display: inline-block;
    }


.demo a {
  z-index: 2;
  display: inline-block;
  -webkit-transform: translate(0, -50%);
  transform: translate(0, -50%);
  color: #fff;
  font : normal 400 20px/1 'Josefin Sans', sans-serif;
  letter-spacing: .1em;
  text-decoration: none;
  transition: opacity .3s;
}
.demo a:hover {
  opacity: .5;
}


#section07 a {
  padding-top: 80px;
}
#section07 a span {
  position: absolute;
  top: 0;
  left: 50%;
  width: 24px;
  height: 24px;
  margin-left: -12px;
  border-left: 1px solid #fff;
  border-bottom: 1px solid #fff;
  -webkit-transform: rotate(-45deg);
  transform: rotate(-45deg);
  -webkit-animation: sdb07 2s infinite;
  animation: sdb07 2s infinite;
  opacity: 0;
  box-sizing: border-box;
}
#section07 a span:nth-of-type(1) {
  -webkit-animation-delay: 0s;
  animation-delay: 0s;
}
#section07 a span:nth-of-type(2) {
  top: 16px;
  -webkit-animation-delay: .15s;
  animation-delay: .15s;
}
#section07 a span:nth-of-type(3) {
  top: 32px;
  -webkit-animation-delay: .3s;
  animation-delay: .3s;
}
@-webkit-keyframes sdb07 {
  0% {
    opacity: 0;
  }
  50% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}
@keyframes sdb07 {
  0% {
    opacity: 0;
  }
  50% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}




    @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap');

    hr.new5 {
  border: 7px solid #ffffff;
  border-radius: 5px;
  width:90%;
  opacity: 0.8;
  margin: 0 auto; 
}
h1{
    font-family: 'Pacifico', cursive;
    font-size: 4rem;
    text-align: center;
}
h2{
    font-family: 'Kalam', cursive;
    font-size: 3rem;
    width: 85%;
    text-align: center;
    margin: 0 auto; 
}

@media only screen and (max-width: 700px) {
  h2{
    font-size: 1rem;
}
h1{
    font-size: 2rem;
}
}
    #tekst{
        transition: 0.3s;
    color: white;
    text-shadow: 1px 1px 0 #b9bcbd, 1px 2px 0 #b9bcbd, 1px 3px 0 #b9bcbd, 1px 4px 0 #b9bcbd,
    1px 5px 0 #b9bcbd, 1px 6px 0 #b9bcbd, 1px 7px 0 #b9bcbd, 1px 8px 0 #b9bcbd,
    5px 13px 15px black;
    }
    #tekst:hover{
        text-shadow: 1px -1px 0 #b9bcbd, 1px -2px 0 #b9bcbd, 1px -3px 0 #b9bcbd,
    1px -4px 0 #b9bcbd, 1px -5px 0 #b9bcbd, 1px -6px 0 #b9bcbd, 1px -7px 0 #b9bcbd,
    1px -8px 0 #b9bcbd, 5px -13px 15px black, 5px -13px 25px #808080;
    }
    #tekst2{
        transition: 0.3s;
    color: #0091f2;
    text-shadow: 1px 1px 0 #0070ba, 1px 2px 0 #0070ba, 1px 3px 0 #0070ba, 1px 4px 0 #0070ba,
    1px 5px 0 #0070ba, 1px 6px 0 #0070ba, 1px 7px 0 #0070ba, 1px 8px 0 #0070ba,
    5px 13px 15px black;
    }
    #tekst2:hover{
        text-shadow: 1px -1px 0 #0070ba, 1px -2px 0 #0070ba, 1px -3px 0 #0070ba,
    1px -4px 0 #0070ba, 1px -5px 0 #0070ba, 1px -6px 0 #0070ba, 1px -7px 0 #0070ba,
    1px -8px 0 #0070ba, 5px -13px 15px black, 5px -13px 25px #808080;
    }
    
    /* Presentational styles */
    body {
    display: flex;
    color: white;
    flex-direction: column;
    font-family: 'Raleway', sans-serif;
    font-size: 7rem;
    font-weight: 800;
    min-height: 100vh;
    place-items: center;
    justify-content: center;
    background: linear-gradient(120deg, rgba(0, 185, 255, 1) 0%, rgba(44, 232, 255, 1) 48%, rgba(130, 251, 255, 1) 100%);
    background-size: cover;
    background-attachment: fixed;
}


button{
  padding: 30px 30px;
  background-color: #b8f8ff;
  color: #0091f2;
  font-weight: bold;
  border: none;
  border-radius: 5px;
  letter-spacing: 4px;
  overflow: hidden;
  transition: 0.8s;
  cursor: pointer;
  font-size: 3rem;
  margin-bottom: 40%;
}

button:hover{
    background: #0091f2;
    color: #b8f8ff;
    box-shadow: 0 0 5px #0091f2,
                0 0 25px #0091f2,
                0 0 50px #0091f2,
                0 0 200px #0091f2;
     -webkit-box-reflect:below 1px linear-gradient(transparent, #0009);
}
</style>
<script>
    $(function() {
  $('a[href*=#]').on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top}, 500, 'linear');
  });
});
</script>
</html>

