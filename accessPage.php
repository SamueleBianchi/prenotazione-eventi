<html>
    <head>
        <meta charset="UTF-8">
        <title>Accesso</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="./stili/style_access.css">
    </head>
    <body>
       <div class="login-page">
  <div class="form">
    <form class="register-form">
        <h2> Registrati </h2>
      <input type="text" placeholder="Nome"/>
      <input type="text" placeholder="Cognome"/>
      <input type="email" placeholder="Email"/>
      <input type="password" placeholder="Password"/>
      <button>Registrati</button>
      <p class="message">Sei già registrato? <a href="#">Accedi</a></p>
    </form>
    <form class="login-form">
        <h2> Accedi </h2>
      <input type="email" placeholder="Email"/>
      <input type="password" placeholder="Password"/>
      <button>Accedi</button>
      <p class="message">Non hai un account? <a href="#">Registrati</a></p>
    </form>
  </div>
</div>
    <script>$(".message a").click(function (){ 
            $("form").animate({ height: "toggle", opacity: "toggle" }, "slow");});
    </script>
    </body>
</html>
