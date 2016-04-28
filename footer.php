    <!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
  	
    <script type="text/javascript">
    	//Cuando apretamos log in o sign up
    	$(".toggleForms").click(function() {

    		//hide
    		$("#signUpForm").toggle();
    		//show
    		$("#logInForm").toggle();

    	});


        //$("#cambios").hide();

        $('#notas').bind('input propertychange', function() {

            $('#cambios').text("Guardando...");
            //Vamos a usar AJAX para guardar los datos en la DB
            $.ajax({
                method: "POST",
                url: "updateNotas.php",
                data: { content: $("#notas").val() }

            })
                .done(function(msg){
                    $('#cambios').text(msg);
                });

            

        });




    </script>


  </body>
</html>