$(document).ready(function(){
  let tab = [];
  let count = 0;
  $('#request').click(function(){
    $('#table_emails tr').each(function(value,key){
          tab[count] = $(this).text().trim();
          count++;
    });
  });

   $('#send_client_urgent').click(function(){

        if($('#message-text').val() == ""){
           $('#message-text').css("border", "1px solid red");
           return;
        }

        $.ajaxSetup({
          headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf_token"]').attr('content')
          }
        });

        $('#sending_progress').modal('show');

        $.ajax({
          method: "POST",
          dataType: "JSON",
          url: '/address-book/sendEmailRequest',
          data: {
              message: $('#message-text').val(),
              emails: tab,
              client_name: $('#client_name').val(),
              reference: $('#job_reference').text(),
              title: $('#job_title').text()
          },
          success : function(data){
            $('#sending_progress').modal('hide');
            $("#myModal").modal('hide');
            $('#emailRequest').trigger('reset');
            $("#messge-text").css("border", "1px solid black");
            alert("Message sent");
          },
          error: function(error){
              alert("Message could not be sent at this moment");
          }
        });


   });

  $('#close_btn').click(function(){
    $('#message-text').css("border", "1px solid grey");
  });




});
