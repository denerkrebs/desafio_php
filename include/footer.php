</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

<script>
$(document).on('click', '.delete-object', function(){
 
    var page = $(this).attr('page');
    var id = $(this).attr('delete-id');
 
    bootbox.confirm({
        message: "<h4>Você tem certesa que quer excluir?</h4>",
        buttons: {
            confirm: {
                label: '<span class="glyphicon glyphicon-ok"></span> Sim',
                className: 'btn-danger'
            },
            cancel: {
                label: '<span class="glyphicon glyphicon-remove"></span> Não',
                className: 'btn-primary'
            }
        },
        callback: function (result) {
            if(result==true){
                $.post('excluir.php', {
                    object_page: page,
                    object_id: id
                }, function(data){
                    location.reload();
                }).fail(function() {
                    alert('Não foi possivel excluir');
                });
            }
        }
    });
 
    return false;
});
</script>

</body>
</html>